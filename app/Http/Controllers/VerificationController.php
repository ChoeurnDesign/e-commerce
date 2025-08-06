<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerificationCodeMail;
use App\Models\User;

class VerificationController extends Controller
{
    public function showForm()
    {
        // Optionally check session, redirect if missing
        if (!session('verify_user_id')) {
            return redirect()->route('login')->withErrors(['msg' => 'Session expired. Please login again.']);
        }
        return view('verification');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $userId = session('verify_user_id');
        $user = User::find($userId);

        if (!$user) {
            session()->forget('verify_user_id');
            return redirect()->route('login')->withErrors(['msg' => 'Session expired. Please login again.']);
        }

        if ($user->verification_code === $request->code) {
            $user->email_verified_at = now();
            $user->verification_code = null;
            $user->save();

            Auth::login($user, true);
            session()->forget('verify_user_id');
            return redirect()->route('dashboard')->with('success', 'Email verified!');
        } else {
            return back()->withErrors(['code' => 'Invalid verification code.']);
        }
    }

    public function sendVerificationCode(Request $request)
    {
        $userId = session('verify_user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login')->withErrors(['msg' => 'Session expired. Please login again.']);
        }

        // Optional: rate limit sending codes, e.g. using cache or Laravel's built-in throttling

        // Generate a new 6-digit code
        $code = mt_rand(100000, 999999);

        // Save code to the user
        $user->verification_code = $code;
        $user->save();

        // Send email to the user
        Mail::to($user->email)->send(new SendVerificationCodeMail($code));

        return back()->with('success', 'Verification code sent to your email!');
    }
}
