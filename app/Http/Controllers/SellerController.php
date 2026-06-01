<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\User;
use App\Mail\SellerApplicationReceived;
use App\Notifications\NewSellerApplicationNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    /**
     * Show all stores with search and sorting.
     */
    public function index(Request $request)
    {
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
     */
    public function show(Seller $seller)
    {
        $seller->loadMissing(['user', 'followers']);
        $seller->loadCount(['followers', 'products']);

        $products = $seller->products()->latest()->paginate(12);
        $topProducts = $seller->products()->latest()->take(6)->get();
        $reviews = $seller->storeReviews()->latest()->take(3)->get();

        $isFollowing = auth()->check()
            ? auth()->user()->followedSellers()->where('seller_id', $seller->id)->exists()
            : false;

        return view('stores.show', compact('seller', 'products', 'topProducts', 'reviews', 'isFollowing'));
    }

    /**
     * Update Store Settings (Handles the Store Profile form)
     */
    public function updateSettings(Request $request)
    {
        $seller = Auth::user()->seller;

        $request->validate([
            'store_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'store_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'store_banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'business_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'returns_days' => 'nullable|integer|min:0',
        ]);

        $data = $request->only([
            'store_name', 'description', 'contact_email', 'phone', 
            'address', 'ships_worldwide', 'returns_days', 
            'response_time', 'shipping_summary'
        ]);

        // 1. Handle Store Logo
        if ($request->hasFile('store_logo')) {
            if ($seller->store_logo) {
                Storage::disk('public')->delete($seller->store_logo);
            }
            $data['store_logo'] = $request->file('store_logo')->store('store_logos', 'public');
        } elseif ($request->boolean('remove_logo')) {
            if ($seller->store_logo) {
                Storage::disk('public')->delete($seller->store_logo);
            }
            $data['store_logo'] = null;
        }

        // 2. Handle Store Banner
        if ($request->hasFile('store_banner')) {
            if ($seller->store_banner) {
                Storage::disk('public')->delete($seller->store_banner);
            }
            $data['store_banner'] = $request->file('store_banner')->store('store_banners', 'public');
        } elseif ($request->boolean('remove_banner')) {
            if ($seller->store_banner) {
                Storage::disk('public')->delete($seller->store_banner);
            }
            $data['store_banner'] = null;
        }

        // 3. Handle Business Document
        if ($request->hasFile('business_document')) {
            if ($seller->business_document) {
                Storage::disk('public')->delete($seller->business_document);
            }
            $data['business_document'] = $request->file('business_document')->store('business_docs', 'public');
        } elseif ($request->boolean('remove_document')) {
            if ($seller->business_document) {
                Storage::disk('public')->delete($seller->business_document);
            }
            $data['business_document'] = null;
        }

        $seller->update($data);

        return back()->with('status', 'Store profile updated successfully!');
    }

    /**
     * Show registration form
     */
    public function showRegistrationForm()
    {
        return view('seller.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $user = Auth::user();

        // Prevent duplicate or re-application
        $existing = Seller::where('user_id', $user->id)->first();
        if ($existing) {
            $messages = [
                'pending'  => 'Your application is already under review. We will email you with the result.',
                'approved' => 'Your store is already approved. Visit your seller dashboard.',
                'rejected' => 'Your previous application was rejected. Please contact support to reapply.',
            ];
            return redirect()->route('seller.register.form')
                ->with('info', $messages[$existing->status] ?? 'You already have a seller account.');
        }

        $request->validate([
            'store_name'        => 'required|string|max:255|unique:sellers,store_name',
            'description'       => 'nullable|string|max:1000',
            'contact_email'     => 'nullable|email|max:255',
            'business_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'store_logo'        => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'store_banner'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $documentPath = $request->hasFile('business_document')
            ? $request->file('business_document')->store('business_docs', 'public') : null;

        $logoPath = $request->hasFile('store_logo')
            ? $request->file('store_logo')->store('store_logos', 'public') : null;

        $bannerPath = $request->hasFile('store_banner')
            ? $request->file('store_banner')->store('store_banners', 'public') : null;

        $seller = Seller::create([
            'user_id'           => $user->id,
            'store_name'        => $request->store_name,
            'description'       => $request->description,
            'contact_email'     => $request->contact_email ?? $user->email,
            'business_document' => $documentPath,
            'store_logo'        => $logoPath,
            'store_banner'      => $bannerPath,
            'status'            => 'pending',
        ]);

        // Do NOT set role='seller' yet — only set it when admin approves

        $seller->load('user');

        // Send confirmation email to the applicant
        try {
            Mail::to($user->email)->send(new SellerApplicationReceived($seller));
        } catch (\Exception $e) {
            // Email failure should not block the flow
        }

        // Notify all admin users via database notification
        try {
            $seller->load('user');
            User::where('role', 'admin')->get()
                ->each(fn($admin) => $admin->notify(new NewSellerApplicationNotification($seller)));
        } catch (\Exception $e) {
            // Notification failure should not block the flow
        }

        return redirect()->route('seller.register.form')
            ->with('success', 'Your application has been submitted! Check your email for confirmation. We will review it within 1–3 business days.');
    }

    /**
     * Alternate Store method
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'store_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'business_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'store_logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'store_banner' => 'nullable|image|max:3072',
        ]);

        if ($request->hasFile('business_document')) {
            $data['business_document'] = $request->file('business_document')->store('seller_docs', 'public');
        }
        if ($request->hasFile('store_logo')) {
            $data['store_logo'] = $request->file('store_logo')->store('store_logos', 'public');
        }
        if ($request->hasFile('store_banner')) {
            $data['store_banner'] = $request->file('store_banner')->store('store_banners', 'public');
        }

        $request->user()->sellerApplication()->create($data);
        $request->user()->update(['role' => 'pending_seller']);

        return redirect()->route('dashboard')->with('success', 'Your application has been submitted.');
    }
}