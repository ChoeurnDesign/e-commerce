<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerificationCodeMail;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    // Step 1: Redirect to provider
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // Step 2: Provider callback, show confirmation instead of auto login/send code
    public function callback($provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();

        session([
            'social_auth' => [
                'provider' => $provider,
                'email' => $socialUser->getEmail(),
                'name' => $socialUser->getName() ?: $socialUser->getNickname(),
                'avatar' => $socialUser->getAvatar(),
            ]
        ]);

        return redirect()->route('social.confirm');
    }

    // In SocialAuthController@confirm
    public function confirm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        $info = session('social_auth');
        if (!$info) {
            return redirect()->route('login')->withErrors(['msg' => 'Session expired. Please try again.']);
        }
        return view('auth.social-confirm', compact('info'));
    }

    // Step 4: Handle "Continue" (actually log in/send code)
    public function confirmProceed()
    {
        $info = session('social_auth');
        if (!$info) {
            return redirect()->route('login')->withErrors(['msg' => 'Session expired. Please try again.']);
        }

        $user = User::where('email', $info['email'])->first();
        $code = rand(100000, 999999);

        if (!$user) {
            $user = User::create([
                'name' => $info['name'],
                'email' => $info['email'],
                'password' => bcrypt(str()->random(16)),
                'email_verified_at' => null,
                'verification_code' => $code,
            ]);
        } elseif (!$user->email_verified_at) {
            $user->verification_code = $code;
            $user->save();
        }

        if (!$user->email_verified_at) {
            Mail::to($user->email)->send(new SendVerificationCodeMail($code));
            session(['verify_user_id' => $user->id]);
            session()->forget('social_auth');
            return redirect()->route('code.verify.form')->with('success', 'Verification code sent! Please check your email.');
        }

        Auth::login($user, true);
        session()->forget('social_auth');
        return redirect()->intended('/dashboard');
    }

    // Step 5: Handle "Cancel"
    public function confirmCancel(Request $request)
    {
        // Log out just in case, and clear social session
        Auth::logout();
        session()->forget('social_auth');
        session()->forget('verify_user_id');
        return redirect()->route('login')->with('info', 'Social login was cancelled. Please sign in again.');
    }
}
