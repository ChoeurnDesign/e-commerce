<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    protected function getSellerFolder()
    {
        // Store seller-specific folders inside products/seller
        return 'products/seller/seller_' . Auth::id();
    }

    public function index()
    {
        $mainImages = Image::where('user_id', Auth::id())
            ->where('type', 'main')
            ->whereNull('product_id')
            ->latest()->get();

        $galleryImages = Image::where('user_id', Auth::id())
            ->where('type', 'gallery')
            ->whereNull('product_id')
            ->latest()->get();

        $folder = $this->getSellerFolder();
        return view('seller.images.index', compact('mainImages', 'galleryImages', 'folder'));
    }

    public function uploadMain(Request $request)
    {
        $request->validate([
            'main_images' => 'required|array|max:20',
            'main_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);
        $folder = $this->getSellerFolder(); // Use the updated seller folder path
        $saved = [];
        foreach ($request->file('main_images', []) as $file) {
            $filename = uniqid() . '_' . preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $file->getClientOriginalName());
            $path = $file->storeAs("{$folder}/main", $filename, 'public'); // Store in products/seller/seller_{id}/main
            $image = Image::create([
                'path' => 'storage/' . $path,
                'user_id' => Auth::id(),
                'type' => 'main',
                'alt' => null,
                'product_id' => null,
                'original_filename' => $file->getClientOriginalName(),
            ]);
            $saved[] = $image;
        }

        return redirect()->back()->with('success', 'Main images uploaded!')->with('uploaded', $saved);
    }

    public function uploadGallery(Request $request)
    {
        $request->validate([
            'gallery_images' => 'required|array|max:20',
            'gallery_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);
        $folder = $this->getSellerFolder(); // Use the updated seller folder path
        $saved = [];
        foreach ($request->file('gallery_images', []) as $file) {
            $filename = uniqid() . '_' . preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $file->getClientOriginalName());
            $path = $file->storeAs("{$folder}/gallery", $filename, 'public'); // Store in products/seller/seller_{id}/gallery
            $image = Image::create([
                'path' => 'storage/' . $path,
                'user_id' => Auth::id(),
                'type' => 'gallery',
                'alt' => null,
                'product_id' => null,
                'original_filename' => $file->getClientOriginalName(),
            ]);
            $saved[] = $image;
        }

        return redirect()->back()->with('success', 'Gallery images uploaded!')->with('uploaded', $saved);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'image_id' => 'required|exists:images,id',
        ]);
        $image = Image::where('id', $request->image_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $relativePath = str_replace('storage/', '', $image->path);
        Storage::disk('public')->delete($relativePath); // Delete from storage
        $image->delete(); // Remove database entry

        return redirect()->back()->with('success', 'Image deleted.');
    }
}