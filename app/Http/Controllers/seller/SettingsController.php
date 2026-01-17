<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function edit(Request $request)
    {
        $seller = $request->user()->seller;

        if (! $seller) {
            return redirect()
                ->route('seller.register.form')
                ->with('info', 'Create your seller profile first.');
        }

        return view('seller.settings.edit', compact('seller'));
    }

    public function update(Request $request)
    {
        $seller = $request->user()->seller;

        if (! $seller) {
            return redirect()
                ->route('seller.register.form')
                ->with('info', 'Create your seller profile first.');
        }

        $data = $request->validate([
            'store_name'        => ['required', 'string', 'max:255'],
            'description'       => ['nullable', 'string', 'max:2000'],
            'contact_email'     => ['nullable', 'email', 'max:255'],
            'address'           => ['nullable', 'string', 'max:1000'],
            'phone'             => ['nullable', 'string', 'max:50'],
            'website'           => ['nullable', 'url', 'max:255'],
            'facebook'          => ['nullable', 'url', 'max:255'],
            'instagram'         => ['nullable', 'url', 'max:255'],
            'tiktok'            => ['nullable', 'url', 'max:255'],
            'ships_worldwide'   => ['nullable', 'boolean'],
            'returns_days'      => ['nullable', 'integer', 'min:0'],
            'shipping_summary'  => ['nullable', 'string', 'max:2000'],
            'response_time'     => ['nullable', 'string', 'max:255'],
            'store_logo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'store_banner'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'business_document' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:4096'],
            'remove_logo'       => ['nullable', 'boolean'],
            'remove_banner'     => ['nullable', 'boolean'],
            'remove_document'   => ['nullable', 'boolean'],
        ]);

        // Remove logo
        if ($request->boolean('remove_logo') && $seller->store_logo) {
            Storage::disk('public')->delete($seller->store_logo);
            $seller->store_logo = null;
        }

        // Remove banner
        if ($request->boolean('remove_banner') && $seller->store_banner) {
            Storage::disk('public')->delete($seller->store_banner);
            $seller->store_banner = null;
        }

        // Remove document
        if ($request->boolean('remove_document') && $seller->business_document) {
            Storage::disk('public')->delete($seller->business_document);
            $seller->business_document = null;
        }

        // New logo
        if ($request->hasFile('store_logo')) {
            if ($seller->store_logo) {
                Storage::disk('public')->delete($seller->store_logo);
            }
            $seller->store_logo = $request->file('store_logo')->store("store_logos/{$seller->id}", 'public');
        }

        // New banner
        if ($request->hasFile('store_banner')) {
            if ($seller->store_banner) {
                Storage::disk('public')->delete($seller->store_banner);
            }

            $file = $request->file('store_banner');

            if (class_exists('Intervention\Image\ImageManagerStatic')) {
                $path = "store_banners/{$seller->id}/banner.jpg";

                $img = call_user_func(['Intervention\Image\ImageManagerStatic', 'make'], $file)
                    ->fit(1500, 500)
                    ->encode('jpg', 85);

                Storage::disk('public')->put($path, (string) $img);
                $seller->store_banner = $path;
            } else {
                $seller->store_banner = $file->store("store_banners/{$seller->id}", 'public');
            }
        }

        // New business document
        if ($request->hasFile('business_document')) {
            if ($seller->business_document) {
                Storage::disk('public')->delete($seller->business_document);
            }
            $seller->business_document = $request->file('business_document')->store("business_docs/{$seller->id}", 'public');
        }

        // assign basic fields including social/shipping fields
        $seller->store_name       = $data['store_name'];
        $seller->description      = $data['description'] ?? null;
        $seller->contact_email    = $data['contact_email'] ?? null;
        $seller->address          = $data['address'] ?? null;
        $seller->phone            = $data['phone'] ?? null;
        $seller->website          = $data['website'] ?? null;
        $seller->facebook         = $data['facebook'] ?? null;
        $seller->instagram        = $data['instagram'] ?? null;
        $seller->tiktok           = $data['tiktok'] ?? null;
        $seller->ships_worldwide  = $request->boolean('ships_worldwide');
        $seller->returns_days     = $data['returns_days'] ?? null;
        $seller->shipping_summary = $data['shipping_summary'] ?? null;
        $seller->response_time    = $data['response_time'] ?? null;

        $seller->save();

        return back()->with('status', 'Store profile updated successfully.');
    }
}