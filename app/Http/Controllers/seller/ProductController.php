<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Seller products listing with admin-like filters.
     */
    public function index(Request $request)
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

        $user = Auth::user();

        $query = Product::with('category')
            ->where('user_id', $user->id);

        // Text search
        if ($search = $request->q) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('slug','like', "%{$search}%")
                  ->orWhere('description','like', "%{$search}%");
            });
        }

        // Category
        if ($cid = $request->category_id) {
            $query->where('category_id', $cid);
        }

        // Boolean flags (accept 0 or 1 explicitly)
        foreach (['is_active','on_sale','is_featured'] as $flag) {
            if ($request->has($flag) && $request->$flag !== '') {
                $query->where($flag, (int)$request->$flag);
            }
        }

        // Numeric ranges
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }
        if ($request->filled('stock_min')) {
            $query->where('stock_quantity', '>=', $request->stock_min);
        }
        if ($request->filled('stock_max')) {
            $query->where('stock_quantity', '<=', $request->stock_max);
        }

        // Date ranges
        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', $request->created_from);
        }
        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', $request->created_to);
        }

        // Sorting (sanitize)
        $allowedSorts = ['id','price','created_at','stock_quantity'];
        $sortInput = $request->query('sort');
        $dirInput  = $request->query('dir');

        $sort = in_array($sortInput, $allowedSorts, true) ? $sortInput : 'id';
        $dir  = in_array(strtolower((string)$dirInput), ['asc','desc'], true) ? strtolower($dirInput) : 'desc';

        $query->orderBy($sort, $dir);

        $products = $query->paginate(15)->appends($request->query());

        $categories = Category::orderBy('name')->get(['id','name']);

        // Mirror admin filter schema so the same partial/component works.
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

        return view('seller.products.index', compact('products','filterFields'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    /**
     * Store new product.
     */
    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);

        $data = $this->extractBaseData($validated);
        $data['user_id'] = Auth::id();

        $data['slug'] = Product::generateUniqueSlug(
            $request->filled('slug') ? $request->slug : $request->name
        );
        $data['sku'] = $request->filled('sku')
            ? Product::generateUniqueSku($request->sku)
            : Product::generateUniqueSku($request->name);

        $this->applyFlags($request, $data);

        $data['image'] = $this->handleMainImageUpload($request);
        $galleryImages = $this->handleGalleryUpload($request);
        $data['images'] = $galleryImages;
        $data['gallery'] = $galleryImages;
        $data['specifications'] = $this->parseSpecifications($request->input('specifications'));

        Product::create($data);

        return redirect()->route('seller.products.index')->with('success', 'Product added!');
    }

    /**
     * Edit form.
     */
    public function edit(Product $product)
    {
        $this->ensureOwnership($product);
        $categories = Category::all();
        return view('seller.products.edit', compact('product','categories'));
    }

    /**
     * Update product.
     */
    public function update(Request $request, Product $product)
    {
        $this->ensureOwnership($product);

        $validated = $this->validateProduct($request);
        $data = $this->extractBaseData($validated);

        $data['slug'] = Product::generateUniqueSlug(
            $request->filled('slug') ? $request->slug : $request->name,
            $product->id
        );
        $data['sku'] = $request->filled('sku')
            ? Product::generateUniqueSku($request->sku, $product->id)
            : Product::generateUniqueSku($request->name, $product->id);

        $this->applyFlags($request, $data);

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                @unlink(public_path($product->image));
            }
            $data['image'] = $this->handleMainImageUpload($request);
        }

        if ($request->hasFile('images')) {
            $this->deleteGallery($product);
            $galleryImages = $this->handleGalleryUpload($request);
            $data['images'] = $galleryImages;
            $data['gallery'] = $galleryImages;
        } else {
            $data['images'] = $product->images;
            $data['gallery'] = $product->gallery;
        }

        $data['specifications'] = $this->parseSpecifications($request->input('specifications'));

        $product->update($data);

        return redirect()->route('seller.products.index')->with('success', 'Product updated!');
    }

    /**
     * Show product.
     */
    public function show(Product $product)
    {
        $this->ensureOwnership($product);
        return view('seller.products.show', compact('product'));
    }

    /**
     * Import form.
     */
    public function showImportForm()
    {
        return view('seller.products.import');
    }

    /**
     * Destroy product.
     */
    public function destroy(Product $product)
    {
        $this->ensureOwnership($product);

        if ($product->image && file_exists(public_path($product->image))) {
            @unlink(public_path($product->image));
        }
        $this->deleteGallery($product);

        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Product deleted!');
    }

    /* =========================
       Validation / Helpers
    ========================== */

    protected function validateProduct(Request $request): array
    {
        return $request->validate([
            'name'              => 'required|string|max:255',
            'slug'              => 'nullable|alpha_dash',
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'sale_price'        => 'nullable|numeric|min:0',
            'compare_price'     => 'nullable|numeric|min:0',
            'sku'               => 'nullable|string|max:100',
            'stock_quantity'    => 'nullable|integer|min:0',
            'category_id'       => 'required|exists:categories,id',
            'image'             => 'nullable|image|max:2048',
            'images'            => 'nullable|array',
            'images.*'          => 'nullable|image|max:2048',
            'specifications'    => 'nullable|string',
            'gallery'           => 'nullable|string',
            'on_sale'           => 'nullable|boolean',
            'is_featured'       => 'nullable|boolean',
            'is_active'         => 'nullable|boolean',
        ]);
    }

    protected function extractBaseData(array $validated): array
    {
        return collect($validated)->only([
            'name',
            'slug',
            'description',
            'short_description',
            'price',
            'sale_price',
            'compare_price',
            'sku',
            'stock_quantity',
            'category_id',
        ])->toArray();
    }

    protected function applyFlags(Request $request, array &$data): void
    {
        $data['is_active']   = $request->boolean('is_active');
        $data['on_sale']     = $request->boolean('on_sale');
        $data['is_featured'] = $request->boolean('is_featured');
    }

    protected function handleMainImageUpload(Request $request): ?string
    {
        if (!$request->hasFile('image')) return null;

        $image = $request->file('image');
        $imageName = uniqid() . '_' . preg_replace('#[^\w.\-]+#', '_', $image->getClientOriginalName());
        $path = public_path('img/products/seller');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $image->move($path, $imageName);
        return 'img/products/seller/' . $imageName;
    }

    protected function handleGalleryUpload(Request $request): array
    {
        if (!$request->hasFile('images')) return [];
        $galleryPath = public_path('img/products/seller/gallery');
        if (!File::exists($galleryPath)) {
            File::makeDirectory($galleryPath, 0755, true);
        }
        $saved = [];
        foreach ($request->file('images') as $img) {
            $name = uniqid() . '_' . preg_replace('#[^\w.\-]+#', '_', $img->getClientOriginalName());
            $img->move($galleryPath, $name);
            $saved[] = 'img/products/seller/gallery/' . $name;
        }
        return $saved;
    }

    protected function deleteGallery(Product $product): void
    {
        $gallery = $product->gallery;
        if (is_string($gallery)) {
            $decoded = json_decode($gallery, true);
            if (is_array($decoded)) $gallery = $decoded;
        }
        if (is_array($gallery)) {
            foreach ($gallery as $img) {
                if ($img && file_exists(public_path($img))) {
                    @unlink(public_path($img));
                }
            }
        }
    }

    protected function parseSpecifications(?string $raw): ?array
    {
        if (!$raw) return null;
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) return $decoded;

        $lines = array_filter(array_map('trim', preg_split('/\r\n|\n|\r/', $raw)));
        $out = [];
        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                [$k,$v] = explode(':', $line, 2);
                $out[trim($k)] = trim($v);
            }
        }
        return $out ?: null;
    }

    protected function ensureOwnership(Product $product): void
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'You do not have permission for this product.');
        }
    }
}