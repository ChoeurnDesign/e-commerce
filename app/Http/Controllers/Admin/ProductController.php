<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use App\Notifications\NewProductNotification;
use App\Notifications\DiscountNotification;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

class ProductController extends Controller
{
    /**
     * Products listing with reusable filter fields.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'q'            => 'nullable|string|max:120',
            'category_id'  => 'nullable|integer|exists:categories,id',
            'is_active'    => 'nullable|in:0,1',
            'on_sale'      => 'nullable|in:0,1',
            'is_featured'  => 'nullable|in:0,1',
            'price_min'    => 'nullable|numeric|min:0',
            'price_max'    => 'nullable|numeric|gte:price_min',
            'stock_min'    => 'nullable|integer|min:0',
            'stock_max'    => 'nullable|integer|gte:stock_min',
            'created_from' => 'nullable|date',
            'created_to'   => 'nullable|date|after_or_equal:created_from',
            'sort'         => 'nullable|string',
            'dir'          => 'nullable|string',
        ]);

        $query = Product::with('category');

        if ($search = $request->q) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%")
                ->orWhere('slug','like', "%{$search}%")
                ->orWhere('description','like', "%{$search}%");
            });
        }

        if ($cid = $request->category_id) {
            $query->where('category_id', $cid);
        }

        // Accept 0 or 1 (filled() would skip "0")
        foreach (['is_active','on_sale','is_featured'] as $flag) {
            if ($request->has($flag) && $request->$flag !== '') {
                $query->where($flag, (int)$request->$flag);
            }
        }

        if ($request->filled('price_min'))  $query->where('price', '>=', $request->price_min);
        if ($request->filled('price_max'))  $query->where('price', '<=', $request->price_max);
        if ($request->filled('stock_min'))  $query->where('stock_quantity', '>=', $request->stock_min);
        if ($request->filled('stock_max'))  $query->where('stock_quantity', '<=', $request->stock_max);
        if ($request->filled('created_from')) $query->whereDate('created_at', '>=', $request->created_from);
        if ($request->filled('created_to'))   $query->whereDate('created_at', '<=', $request->created_to);

        // --------- SANITIZE SORT & DIR -------------
        $allowedSorts = ['id','price','created_at','stock_quantity'];
        $sortInput = $request->query('sort');        // raw (may be empty string)
        $dirInput  = $request->query('dir');         // raw (may be empty string)

        $sort = in_array($sortInput, $allowedSorts, true) ? $sortInput : 'id';
        $dir  = in_array(strtolower((string)$dirInput), ['asc','desc'], true) ? strtolower($dirInput) : 'desc';

        $query->orderBy($sort, $dir);

        // AJAX quick name suggestions (optional)
        if ($request->ajax() && $request->q) {
            return Product::where('name','like','%'.$request->q.'%')
                ->limit(8)
                ->get(['name']);
        }

        $products = $query->paginate(15)->appends($request->query());

        $categories = Category::orderBy('name')->get(['id','name']);

        $filterFields = [
            ['name'=>'q','type'=>'text','label'=>'Search','placeholder'=>'Name / SKU / Slug'],
            ['name'=>'category_id','type'=>'select','label'=>'Category','options'=>$categories->pluck('name','id')->toArray(),'placeholder'=>'All'],
            ['name'=>'is_active','type'=>'boolean','label'=>'Active?','placeholder'=>'Any','true_label'=>'Yes','false_label'=>'No'],
            ['name'=>'on_sale','type'=>'boolean','label'=>'On Sale','placeholder'=>'Any','true_label'=>'Yes','false_label'=>'No'],
            ['name'=>'is_featured','type'=>'boolean','label'=>'Featured','placeholder'=>'Any','true_label'=>'Yes','false_label'=>'No'],
            ['name'=>'price_min','type'=>'number','label'=>'Price Min','step'=>'0.01'],
            ['name'=>'price_max','type'=>'number','label'=>'Price Max','step'=>'0.01'],
            ['name'=>'stock_min','type'=>'number','label'=>'Stock Min'],
            ['name'=>'stock_max','type'=>'number','label'=>'Stock Max'],
            ['name'=>'created_from','type'=>'date','label'=>'From'],
            ['name'=>'created_to','type'=>'date','label'=>'To'],
            ['name'=>'sort','type'=>'select','label'=>'Sort By','options'=>[
                'id'=>'ID','price'=>'Price','created_at'=>'Created','stock_quantity'=>'Stock'
            ],'placeholder'=>'Default'],
            ['name'=>'dir','type'=>'select','label'=>'Dir','options'=>[
                'asc'=>'ASC','desc'=>'DESC'
            ],'placeholder'=>'Default'],
        ];

        return view('admin.products.index', compact('products','filterFields'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'on_sale' => 'boolean',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery' => 'nullable',
            'specifications' => 'nullable',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        // Checkbox defaults
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['on_sale'] = $request->has('on_sale') ? 1 : 0;
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;

        // Main image
        if ($request->hasFile('image')) {
            $category = Category::find($validated['category_id']);
            $categorySlug = $category ? Str::slug($category->name) : 'uncategorized';
            $destinationPath = public_path('img/products/' . $categorySlug);
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $image = $request->file('image');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();
            $image->move($destinationPath, $imageName);
            $validated['image'] = 'img/products/' . $categorySlug . '/' . $imageName;
        }

        // Gallery images
        $images = [];
        if ($request->hasFile('images')) {
            $category = Category::find($validated['category_id']);
            $categorySlug = $category ? Str::slug($category->name) : 'uncategorized';
            $destinationPath = public_path('img/products/' . $categorySlug . '/gallery');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            foreach ($request->file('images') as $imageFile) {
                $imageName = uniqid() . '_' . $imageFile->getClientOriginalName();
                $imageFile->move($destinationPath, $imageName);
                $images[] = 'img/products/' . $categorySlug . '/gallery/' . $imageName;
            }
        }
        $validated['images'] = $images;

        // Gallery JSON
        if ($request->filled('gallery')) {
            $galleryInput = $request->input('gallery');
            if (is_string($galleryInput)) {
                $decoded = json_decode($galleryInput, true);
                $validated['gallery'] = is_array($decoded) ? $decoded : [];
            } else {
                $validated['gallery'] = [];
            }
        } else {
            $validated['gallery'] = [];
        }

        // Specifications
        if ($request->filled('specifications')) {
            $specInput = $request->input('specifications');
            $specDecoded = json_decode($specInput, true);
            if (is_array($specDecoded)) {
                $validated['specifications'] = $specDecoded;
            } else {
                $lines = array_filter(array_map('trim', explode("\n", $specInput)));
                $specArr = [];
                foreach ($lines as $line) {
                    if (strpos($line, ':') !== false) {
                        [$key, $val] = explode(':', $line, 2);
                        $specArr[trim($key)] = trim($val);
                    }
                }
                $validated['specifications'] = $specArr;
            }
        } else {
            $validated['specifications'] = [];
        }

        // Slug & SKU
        $validated['slug'] = Product::generateUniqueSlug(
            $request->filled('slug') ? $request->slug : $validated['name']
        );
        $validated['sku'] = $request->filled('sku')
            ? Product::generateUniqueSku($request->sku)
            : Product::generateUniqueSku($validated['name']);

        $validated['user_id'] = auth()->id();
        $validated['page_views'] = 0;

        $product = Product::create($validated);

        // Notify users
        User::where('role', 'user')->chunk(200, function($users) use ($product) {
            foreach ($users as $user) {
                $user->notify(new NewProductNotification($product));
            }
        });

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'on_sale' => 'boolean',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery' => 'nullable',
            'specifications' => 'nullable',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['on_sale'] = $request->has('on_sale') ? 1 : 0;
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;

        $oldSalePrice = $product->sale_price;

        // Main image
        if ($request->hasFile('image')) {
            if ($product->image && str_starts_with($product->image, 'img/products/') && file_exists(public_path($product->image))) {
                @unlink(public_path($product->image));
            }
            $category = Category::find($validated['category_id']);
            $categorySlug = $category ? Str::slug($category->name) : 'uncategorized';
            $destinationPath = public_path('img/products/' . $categorySlug);
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $image = $request->file('image');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();
            $image->move($destinationPath, $imageName);
            $validated['image'] = 'img/products/' . $categorySlug . '/' . $imageName;
        }

        // Gallery additions
        $images = $product->images ?? [];
        if ($request->hasFile('images')) {
            $category = Category::find($validated['category_id']);
            $categorySlug = $category ? Str::slug($category->name) : 'uncategorized';
            $destinationPath = public_path('img/products/' . $categorySlug . '/gallery');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            foreach ($request->file('images') as $imageFile) {
                $imageName = uniqid() . '_' . $imageFile->getClientOriginalName();
                $imageFile->move($destinationPath, $imageName);
                $images[] = 'img/products/' . $categorySlug . '/gallery/' . $imageName;
            }
        }
        $validated['images'] = $images;

        // Gallery JSON
        if ($request->filled('gallery')) {
            $galleryInput = $request->input('gallery');
            if (is_string($galleryInput)) {
                $decoded = json_decode($galleryInput, true);
                $validated['gallery'] = is_array($decoded) ? $decoded : [];
            } else {
                $validated['gallery'] = [];
            }
        } else {
            $validated['gallery'] = [];
        }

        // Specifications
        if ($request->filled('specifications')) {
            $specInput = $request->input('specifications');
            $specDecoded = json_decode($specInput, true);
            if (is_array($specDecoded)) {
                $validated['specifications'] = $specDecoded;
            } else {
                $lines = array_filter(array_map('trim', explode("\n", $specInput)));
                $specArr = [];
                foreach ($lines as $line) {
                    if (strpos($line, ':') !== false) {
                        [$key,$val] = explode(':', $line, 2);
                        $specArr[trim($key)] = trim($val);
                    }
                }
                $validated['specifications'] = $specArr;
            }
        } else {
            $validated['specifications'] = [];
        }

        // Slug & SKU (unique ignoring current id)
        $validated['slug'] = Product::generateUniqueSlug(
            $request->filled('slug') ? $request->slug : $validated['name'],
            $product->id
        );
        $validated['sku'] = $request->filled('sku')
            ? Product::generateUniqueSku($request->sku, $product->id)
            : Product::generateUniqueSku($validated['name'], $product->id);

        $product->update($validated);

        if (!empty($validated['sale_price']) && $validated['sale_price'] != $oldSalePrice) {
            User::where('role','user')->chunk(200, function($users) use ($product) {
                foreach ($users as $user) {
                    $user->notify(new DiscountNotification($product));
                }
            });
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if ($product->image && str_starts_with($product->image, 'img/products/') && file_exists(public_path($product->image))) {
            @unlink(public_path($product->image));
        }
        // (Optional) delete gallery images here

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    public function showImportForm()
    {
        return view('admin.products.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'products_file' => 'required|mimes:csv,txt'
        ]);
        try {
            Excel::import(new ProductsImport, $request->file('products_file'));
            return back()->with('success', 'Products imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
