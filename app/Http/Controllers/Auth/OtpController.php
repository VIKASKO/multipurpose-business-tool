<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailVerificationOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function showVerifyForm()
    {
        if (! session('pending_verification_email')) {
            return redirect()->route('auth.login');
        }

        return view('auth.verify-otp', [
            'email' => session('pending_verification_email'),
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $email = session('pending_verification_email');

        if (! $email) {
            return redirect()->route('auth.login')->with('error', 'Session expired. Please log in again.');
        }

        $record = EmailVerificationOtp::where('email', $email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (! $record) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP. Please try again.']);
        }

        // Mark email as verified
        $user = User::where('email', $email)->firstOrFail();
        $user->update(['email_verified_at' => now()]);

        // Clean up OTP
        $record->delete();

        // Clear session key
        session()->forget('pending_verification_email');

        // Log the user in
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Email verified! Welcome to the Business ERP.');
    }

    public function resend(Request $request)
    {
        $email = session('pending_verification_email');

        if (! $email) {
            return redirect()->route('auth.login');
        }

        RegisterController::sendOtp($email);

        return back()->with('success', 'A new OTP has been sent to your email.');
    }
}
