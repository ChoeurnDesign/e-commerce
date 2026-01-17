<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    /**
     * Show all stores with search and sorting.
     */
    public function index(Request $request)
    {
        // Eager-load user to avoid N+1 when showing basic seller info in list,
        // and load counts used in the view (products_count, followers_count).
        $query = Seller::query()
            ->with('user')
            ->withCount(['products', 'followers']);

        // Search logic
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('store_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Sorting logic
        switch ($request->get('sort', 'name')) {
            case 'products':
                $query->orderBy('products_count', 'desc');
                break;
            case 'rating':
                // Uncomment and adjust if you have average_rating column
                // $query->orderBy('average_rating', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            default:
                $query->orderBy('store_name');
        }

        $sellers = $query->paginate(16);

        return view('stores.index', compact('sellers'));
    }

    /**
     * Show a single seller/store page.
     *
     * Route-model-binding will resolve Seller by slug (Seller::getRouteKeyName = 'slug').
     * This method eager-loads relations and passes the extra variables the view/partial expects.
     */
    public function show(Seller $seller)
    {
        // Ensure user (fallback for contact email), followers and counts are loaded
        $seller->loadMissing(['user', 'followers']);
        $seller->loadCount(['followers', 'products']);

        // Products listing (paginated) used by the store page
        $products = $seller->products()->latest()->paginate(12);

        // Optional data used by the contact/info partial and other UI bits
        $topProducts = $seller->products()->latest()->take(6)->get();
        $reviews = $seller->storeReviews()->latest()->take(3)->get();

        $isFollowing = auth()->check()
            ? auth()->user()->followedSellers()->where('seller_id', $seller->id)->exists()
            : false;

        return view('stores.show', compact('seller', 'products', 'topProducts', 'reviews', 'isFollowing'));
    }

    /**
     * Show the registration form for a new seller.
     */
    public function showRegistrationForm()
    {
        return view('seller.register');
    }

    /**
     * Handle registration form submission for a new seller.
     */
    public function register(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'business_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'store_logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $user = Auth::user();

        // Handle file uploads
        $documentPath = $request->hasFile('business_document') 
            ? $request->file('business_document')->store('business_docs', 'public')
            : null;
        $logoPath = $request->hasFile('store_logo')
            ? $request->file('store_logo')->store('store_logos', 'public')
            : null;

        // Create seller record
        Seller::create([
            'user_id' => $user->id,
            'store_name' => $request->store_name,
            'description' => $request->description,
            'business_document' => $documentPath,
            'store_logo' => $logoPath,
            'status' => 'pending'
        ]);

        // Optionally update the user role
        $user->role = 'seller';
        $user->save();

        return redirect()->route('dashboard')
            ->with('success', 'Your seller application has been submitted and is under review.');
    }

    /**
     * Store a new seller application (alternate method).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'store_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'business_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'store_logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle file uploads
        if ($request->hasFile('business_document')) {
            $data['business_document'] = $request->file('business_document')->store('seller_docs', 'public');
        }
        if ($request->hasFile('store_logo')) {
            $data['store_logo'] = $request->file('store_logo')->store('store_logos', 'public');
        }

        // Create seller application (or update user's role/status)
        $request->user()->sellerApplication()->create($data);

        // Optionally update user role to 'pending_seller'
        $request->user()->update(['role' => 'pending_seller']);

        return redirect()->route('dashboard')
            ->with('success', 'Your application has been submitted for review.');
    }
}