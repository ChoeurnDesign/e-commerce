<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName() ?? $googleUser->getNickname(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(str()->random(32)), // just a random password
                    'email_verified_at' => now(),           // guarantees verified
                ]);
            } else {
                // Optional: update name, mark email as verified
                $user->name = $googleUser->getName() ?? $googleUser->getNickname();
                if (!$user->email_verified_at) {
                    $user->email_verified_at = now();      
                }
                $user->save();
            }

            Auth::login($user, true);

            return redirect()->intended('/dashboard')->with('success', 'Logged in with Google!');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['msg' => 'Google login failed. Please try again.']);
        }
    }
}