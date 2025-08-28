<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:users,email,'.auth()->id(),
            'avatar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_avatar' => 'nullable|boolean',
        ];
    }
}