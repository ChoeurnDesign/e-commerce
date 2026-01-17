<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
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
        $query = Product::with('category')->where('user_id', $user->id);

        if ($search = $request->q) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($cid = $request->category_id) {
            $query->where('category_id', $cid);
        }
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

        $allowedSorts = ['id','price','created_at','stock_quantity'];
        $sortInput = $request->query('sort');
        $dirInput  = $request->query('dir');
        $sort = in_array($sortInput, $allowedSorts, true) ? $sortInput : 'id';
        $dir  = in_array(strtolower((string)$dirInput), ['asc','desc'], true) ? strtolower($dirInput) : 'desc';
        $query->orderBy($sort, $dir);

        $products = $query->paginate(15)->appends($request->query());
        $categories = Category::orderBy('name')->get(['id','name']);

        $filterFields = [
            // ... your filter fields ...
        ];

        return view('seller.products.index', compact('products','filterFields'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);
        $data = $this->extractBaseData($validated);
        $data['user_id'] = Auth::id();

        $data['slug'] = Product::generateUniqueSlug(
            $request->filled('slug') ? $request->slug : $data['name']
        );
        $data['sku'] = $request->filled('sku')
            ? Product::generateUniqueSku($request->sku)
            : Product::generateUniqueSku($data['name']);

        $this->applyFlags($request, $data);

        // Main image upload for seller folder
        if ($request->hasFile('image')) {
            $data['image'] = $this->handleMainImageUpload($request);
        }

        // Gallery upload for seller folder
        if ($request->hasFile('gallery')) {
            $data['gallery'] = $this->handleGalleryUpload($request);
        } else {
            $data['gallery'] = $this->parseGallery($request->input('gallery'));
        }

        $data['specifications'] = $this->parseSpecifications($request->input('specifications'));

        Product::create($data);

        return redirect()->route('seller.products.index')->with('success', 'Product added!');
    }

    public function showImportForm()
    {
        return view('seller.products.import');
    }

   public function import(Request $request)
    {
        $request->validate([
            'products_file' => 'required|file|mimes:csv,txt|max:10240',
            'dry_run'       => 'nullable|boolean',
        ]);

        $dryRun = (bool) $request->input('dry_run', false);

        // Pass only Auth::id() to the ProductsImport constructor
        $import = new \App\Imports\ProductsImport(Auth::id());

        try {
            \Maatwebsite\Excel\Facades\Excel::import($import, $request->file('products_file'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Import failed: '.$e->getMessage());
        }

        $errors  = method_exists($import, 'getErrors') ? $import->getErrors() : [];
        $summary = method_exists($import, 'getSummary') ? $import->getSummary() : [];

        if ($errors || (isset($summary['skipped']) && $summary['skipped'])) {
            return back()
                ->with('success', ($dryRun ? 'Dry run completed with issues.' : 'Import completed with some skipped rows.'))
                ->with('import_errors', $errors)
                ->with('import_partial', true)
                ->with('import_summary', $summary);
        }

        return back()
            ->with('success', $dryRun ? 'Dry run OK. No data saved.' : 'All products imported successfully!')
            ->with('import_summary', $summary);
    }

    public function downloadTemplate()
    {
        $path = public_path('sample-template-seller.csv');
        if (file_exists($path)) {
            return response()->download(
                $path,
                'sample-template-seller.csv',
                ['Content-Type' => 'text/csv; charset=utf-8']
            );
        }
        abort(404, 'Sample template not found.');
    }

    public function edit(Product $product)
    {
        $this->ensureOwnership($product);
        $categories = Category::all();
        return view('seller.products.edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->ensureOwnership($product);

        $validated = $this->validateProduct($request);
        $data = $this->extractBaseData($validated);

        $data['slug'] = Product::generateUniqueSlug(
            $request->filled('slug') ? $request->slug : $data['name'],
            $product->id
        );
        $data['sku'] = $request->filled('sku')
            ? Product::generateUniqueSku($request->sku, $product->id)
            : Product::generateUniqueSku($data['name'], $product->id);

        $this->applyFlags($request, $data);

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                @unlink(public_path($product->image));
            }
            $data['image'] = $this->handleMainImageUpload($request);
        } else {
            $data['image'] = $product->image;
        }

        if ($request->hasFile('gallery')) {
            $this->deleteGallery($product);
            $data['gallery'] = $this->handleGalleryUpload($request);
        } else {
            $data['gallery'] = $this->parseGallery($request->input('gallery')) ?: $product->gallery;
        }

        $data['specifications'] = $this->parseSpecifications($request->input('specifications'));

        $product->update($data);

        return redirect()->route('seller.products.index')->with('success', 'Product updated!');
    }

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

    public function show(Product $product)
    {
        $this->ensureOwnership($product);
        return view('seller.products.show', compact('product'));
    }
    

    /* ================= Helper Methods ================= */

    protected function validateProduct(Request $request): array
    {
        return $request->validate([
            'name'              => 'required|string|max:255',
            'slug'              => 'nullable|alpha_dash',
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'sale_price'        => [
                'nullable','numeric','min:0','lt:price',
                Rule::requiredIf($request->boolean('on_sale'))
            ],
            'compare_price'     => 'nullable|numeric|min:0|gt:price',
            'sku'               => 'nullable|string|max:100',
            'stock_quantity'    => 'nullable|integer|min:0',
            'category_id'       => 'required|exists:categories,id',
            'image'             => 'nullable|image|max:2048',
            'gallery'           => 'nullable',
            'on_sale'           => 'nullable|boolean',
            'is_featured'       => 'nullable|boolean',
            'is_active'         => 'nullable|boolean',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:255',
        ]);
    }

    protected function extractBaseData(array $validated): array
    {
        return collect($validated)->only([
            'name','slug','description','short_description',
            'price','sale_price','compare_price','sku',
            'stock_quantity','category_id',
            'meta_title','meta_description',
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
        $path = $request->file('image')->store('products/seller/main', 'public');
        return 'storage/' . $path;
    }

    protected function handleGalleryUpload(Request $request): array
    {
        if (!$request->hasFile('gallery')) return [];
        $saved = [];
        foreach ($request->file('gallery') as $img) {
            $path = $img->store('products/seller/gallery', 'public');
            $saved[] = 'storage/' . $path;
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
                $imgPath = public_path($img);
                if (str_starts_with($img, 'storage/') && file_exists($imgPath)) {
                    @unlink($imgPath);
                } elseif (file_exists(public_path($img))) {
                    @unlink(public_path($img));
                }
            }
        }
    }

    protected function parseGallery($raw): array
    {
        if (!$raw) return [];
        if (is_array($raw)) return $raw;
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) return $decoded;
        if (is_string($raw) && str_contains($raw, '|')) {
            return array_map('trim', explode('|', $raw));
        }
        return [$raw];
    }

    protected function parseSpecifications($raw): array
    {
        if (!$raw) return [];
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) return $decoded;
        $lines = array_filter(array_map('trim', preg_split('/\r\n|\n|\r/',$raw)));
        $out = [];
        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                [$k,$v] = explode(':', $line, 2);
                $out[trim($k)] = trim($v);
            }
        }
        return $out;
    }

    protected function ensureOwnership(Product $product): void
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'You do not have permission for this product.');
        }
    }
}