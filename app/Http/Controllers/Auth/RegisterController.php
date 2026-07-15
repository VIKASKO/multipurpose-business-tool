<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\EmailVerificationOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        // Create the user (unverified)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'staff',
            'is_active' => true,
        ]);

        // Generate and send OTP (don't fail registration if OTP sending errors)
        try {
            $this->sendOtp($user->email);
        } catch (\Throwable $e) {
            Log::error('Failed to send registration OTP: '.$e->getMessage());
            // proceed — user created but OTP may not be sent
            return redirect()->route('auth.otp.show')
                ->with('warning', 'Account created but we could not send an OTP. Contact support.');
        }

        // Store email in session for the verify step
        session(['pending_verification_email' => $user->email]);

        return redirect()->route('auth.otp.show')
            ->with('success', 'Account created! Please check your email for a 6-digit OTP to verify your account.');
    }

    public static function sendOtp(string $email): void
    {
        // Delete any existing OTPs for this email
        EmailVerificationOtp::where('email', $email)->delete();

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        EmailVerificationOtp::create([
            'email'      => $email,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($email)->send(new OtpMail($otp));
    }
}
