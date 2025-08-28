<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSellerProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->seller;
    }

    public function rules(): array
    {
        return [
            'store_name'         => 'required|string|max:255',
            'description'        => 'nullable|string',
            'business_document'  => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:4096',
            'remove_document'    => 'nullable|boolean',
            'store_logo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'remove_logo'        => 'nullable|boolean',
        ];
    }
}