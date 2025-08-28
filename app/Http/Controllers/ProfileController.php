<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        // Always pass a fresh user instance!
        return view('profile.edit', ['user' => $request->user()->fresh()]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        // Handle cropped image from Cropper.js (base64 string)
        if ($request->filled('cropped_profile_image')) {
            // Remove old profile image if exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            // Decode base64 and store
            $data = $request->input('cropped_profile_image');
            $data = preg_replace('/^data:image\/\w+;base64,/', '', $data);
            $data = base64_decode($data);
            $filename = 'profile-images/' . uniqid() . '.png';
            Storage::disk('public')->put($filename, $data);
            $user->profile_image = $filename;
        }
        // Fallback to regular file upload
        elseif ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $user->profile_image = $request->file('profile_image')->store('profile-images', 'public');
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();

        // Redirect to edit so the next request gets a fresh user
        return Redirect::route('profile.edit')->with('success', 'Profile updated successfully!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', ['password' => ['required', 'current_password']]);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }
}
