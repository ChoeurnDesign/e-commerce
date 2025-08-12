<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomepageBanner;
use Illuminate\Support\Facades\Storage;

class HomepageBannerController extends Controller
{
    public function index()
    {
        $banners = HomepageBanner::orderBy('order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image|max:2048',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $data['image_path'] = $request->file('image')->store('banners', 'public');

        // Default order to the next available if not provided
        $data['order'] = $data['order'] ?? (HomepageBanner::max('order') + 1);

        HomepageBanner::create($data);

        return redirect()->back()->with('success', 'Banner added!');
    }

    public function destroy(HomepageBanner $banner)
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }
        $banner->delete();
        return redirect()->back()->with('success', 'Banner deleted.');
    }

}
