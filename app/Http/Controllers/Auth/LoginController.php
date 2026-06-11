<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->hasRole('super_admin') || $user->hasRole('admin')) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
            } elseif ($user->hasRole('store_manager')) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Manager!');
            } elseif ($user->hasRole('delivery_partner')) {
                return redirect()->route('delivery.dashboard')->with('success', 'Welcome back!');
            } elseif ($user->hasRole('franchise_partner')) {
                return redirect()->route('franchise.dashboard')->with('success', 'Welcome back!');
            }

            return redirect()->route('customer.dashboard')->with('success', 'Logged in successfully.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
