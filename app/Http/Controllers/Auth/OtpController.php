<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendOtpMail;
use App\Mail\WelcomeUserMail;

class OtpController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|digits:10|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => 'active',
            'referral_code' => 'GOS' . strtoupper(Str::random(6)),
        ]);

        // Assign customer role
        $customerRole = Role::where('slug', 'customer')->first();
        if ($customerRole) {
            $user->roles()->sync([$customerRole->id]);
        }

        // Create wallet
        $user->wallet()->create(['balance' => 0.00]);

        // Send Welcome Email
        try {
            Mail::to($user->email)->send(new WelcomeUserMail($user));
        } catch (\Exception $e) {
            Log::error("Failed to send welcome email to {$user->email}: " . $e->getMessage());
        }

        // Log the user in
        Auth::login($user, true);

        return redirect()->route('customer.dashboard')->with('success', 'Account created successfully! Welcome to GOS MOMO.');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;
        
        // Find or create user
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            // Create user with temp name
            $user = User::create([
                'name' => 'GOS Customer ' . Str::random(5),
                'email' => $email,
                'status' => 'active',
                'referral_code' => 'GOS' . strtoupper(Str::random(6)),
            ]);
            
            // Assign customer role
            $customerRole = Role::where('slug', 'customer')->first();
            if ($customerRole) {
                $user->roles()->sync([$customerRole->id]);
            }

            // Create wallet
            $user->wallet()->create(['balance' => 0.00]);

            // Send Welcome Email
            try {
                Mail::to($user->email)->send(new WelcomeUserMail($user));
            } catch (\Exception $e) {
                Log::error("Failed to send welcome email to {$user->email}: " . $e->getMessage());
            }
        }

        // Generate random 6-digit OTP
        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // Send OTP via email
        try {
            Mail::to($user->email)->send(new SendOtpMail($otp));
            Log::info("OTP for GOS MOMO login for email {$email} is: {$otp}");
        } catch (\Exception $e) {
            Log::error("Failed to send OTP email to {$email}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP email. Please try again later.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully! Check your email inbox.',
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->where('otp_expires_at', '>', now())
                    ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP. Please try again.',
            ], 422);
        }

        // Clear OTP
        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        // Log user in
        Auth::login($user, true);

        // Determine redirect route based on role
        $redirectUrl = route('customer.dashboard');
        if ($user->hasRole('super_admin') || $user->hasRole('admin')) {
            $redirectUrl = route('admin.dashboard');
        } elseif ($user->hasRole('store_manager')) {
            $redirectUrl = route('admin.dashboard'); // or manager dashboard
        } elseif ($user->hasRole('delivery_partner')) {
            $redirectUrl = route('delivery.dashboard');
        } elseif ($user->hasRole('franchise_partner')) {
            $redirectUrl = route('franchise.dashboard');
        }

        return response()->json([
            'success' => true,
            'message' => 'Logged in successfully!',
            'redirect' => $redirectUrl,
        ]);
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }
}
