<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OtpController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('auth.login');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:10',
        ]);

        $phone = $request->phone;
        
        // Find or create user
        $user = User::where('phone', $phone)->first();
        
        $isNewUser = false;
        if (!$user) {
            $isNewUser = true;
            // Create user with temp name, they can update in profile
            $user = User::create([
                'name' => 'GOS Customer ' . Str::random(5),
                'phone' => $phone,
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
        }

        // Generate 6-digit OTP (for testing, we use 123456, otherwise random)
        $otp = '123456'; 
        if (config('app.env') !== 'local') {
            $otp = rand(100000, 999999);
        }

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // In production, send SMS here. For local/development, we log it.
        Log::info("OTP for GOS MOMO login for phone {$phone} is: {$otp}");

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully! Use 123456 for testing.',
            'is_new_user' => $isNewUser,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:10',
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('phone', $request->phone)
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
