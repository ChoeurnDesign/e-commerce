<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\HomepageBanner; // <-- Add this line
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $banners = HomepageBanner::orderBy('order')->get(); // Fetch banners for admin
        return view('admin.settings.index', compact('settings', 'banners'));
    }

    // Show the edit form (GET)
    public function showEditBanner(HomepageBanner $banner)
    {
        return view('admin.settings.partials.edit-banner', compact('banner'));
    }

    // Update the banner (PUT)
    public function updateBanner(Request $request, HomepageBanner $banner)
    {
        $data = $request->validate([
            'image' => 'nullable|image|max:2048',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }
            $data['image_path'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('admin.settings.index')->with('success', 'Banner updated!');
    }

    public function saveGeneral(Request $request)
    {
        $data = $request->validate([
            'store_name'       => 'required|string|max:255',
            'store_email'      => 'required|email|max:255',
            'store_phone'      => 'required|string|max:20',
            'support_email'    => 'nullable|email|max:255',
            'support_phone'    => 'nullable|string|max:20',
            'store_address'    => 'nullable|string|max:500',
            'welcome_message'  => 'nullable|string|max:500',
            'storefront_title' => 'nullable|string|max:255',
            'store_logo'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        foreach ($data as $key => $value) {
            if ($key !== 'store_logo') {
                if (is_string($value) && trim($value) === '') {
                    $value = null;
                }
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        $settings = Setting::pluck('value', 'key')->toArray();

        if ($request->input('remove_logo')) {
            if (!empty($settings['store_logo']) && file_exists(public_path($settings['store_logo']))) {
                @unlink(public_path($settings['store_logo']));
            }
            Setting::updateOrCreate(['key' => 'store_logo'], ['value' => null]);
        }

        if ($request->hasFile('store_logo')) {
            $logo = $request->file('store_logo');
            $filename = uniqid('logo_') . '.' . $logo->getClientOriginalExtension();
            $destination = public_path('img/logo');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $logo->move($destination, $filename);
            $logoPath = 'img/logo/' . $filename;
            Setting::updateOrCreate(['key' => 'store_logo'], ['value' => $logoPath]);
        }

        return redirect()->route('admin.settings.index')->with('success', 'General settings updated!');
    }

    public function saveStorefront(Request $request)
    {
        $data = $request->validate([
            'storefront_title' => 'required|string|max:255',
            'welcome_message' => 'nullable|string|max:500',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Storefront settings updated!');
    }

    public function savePayment(Request $request)
    {
        $data = $request->validate([
            'payment_gateway' => ['required', Rule::in(['none', 'stripe', 'paypal', 'aba_payway', 'wing', 'truemoney'])],
            'api_key' => 'nullable|string|max:255',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Payment settings updated!');
    }

    public function saveShipping(Request $request)
    {
        $data = $request->validate([
            'shipping_threshold' => 'nullable|numeric|min:0',
            'shipping_policy' => 'nullable|string|max:1000',
        ]);
        $data['free_shipping'] = $request->has('free_shipping') ? 1 : 0;

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Shipping settings updated!');
    }

    public function savePolicies(Request $request)
    {
        $data = $request->validate([
            'return_policy'    => 'nullable|string|max:2000',
            'privacy_policy'   => 'nullable|string|max:2000',
            'terms_of_service' => 'nullable|string|max:2000',
            'shipping_policy'  => 'nullable|string|max:2000',
            'support_info'     => 'nullable|string|max:2000',
        ]);
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        return back()->with('success', 'Policies updated!');
    }

    // --- BANNER MANAGEMENT ---

    public function addBanner(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image|max:2048',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $data['image_path'] = $request->file('image')->store('banners', 'public');
        HomepageBanner::create($data);

        return redirect()->back()->with('success', 'Banner added!');
    }

    public function deleteBanner(HomepageBanner $banner)
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }
        $banner->delete();
        return redirect()->back()->with('success', 'Banner deleted.');
    }

    public function editBanner(Request $request, HomepageBanner $banner)
    {
        $data = $request->validate([
            'image' => 'nullable|image|max:2048',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }
            $data['image_path'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->back()->with('success', 'Banner updated!');
    }
}
