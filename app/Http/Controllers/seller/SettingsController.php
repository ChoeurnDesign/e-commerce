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

        if (!$seller) {
            return redirect()
                ->route('seller.register.form')
                ->with('info', 'Create your seller profile first.');
        }

        return view('seller.settings.edit', compact('seller'));
    }

    public function update(Request $request)
    {
        $seller = $request->user()->seller;

        if (!$seller) {
            return redirect()
                ->route('seller.register.form')
                ->with('info', 'Create your seller profile first.');
        }

        $data = $request->validate([
            'store_name'        => ['required', 'string', 'max:255'],
            'description'       => ['nullable', 'string', 'max:2000'],
            'store_logo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'business_document' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:4096'],
            'remove_logo'       => ['nullable', 'boolean'],
            'remove_document'   => ['nullable', 'boolean'],
        ]);

        // Remove logo
        if ($request->boolean('remove_logo') && $seller->store_logo) {
            Storage::disk('public')->delete($seller->store_logo);
            $seller->store_logo = null;
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
            $seller->store_logo = $request->file('store_logo')->store('store_logos', 'public');
        }

        // New business document
        if ($request->hasFile('business_document')) {
            if ($seller->business_document) {
                Storage::disk('public')->delete($seller->business_document);
            }
            $seller->business_document = $request->file('business_document')->store('business_docs', 'public');
        }

        $seller->store_name  = $data['store_name'];
        $seller->description = $data['description'] ?? null;
        $seller->save();

        return back()->with('status', 'Store profile updated successfully.');
    }
}   