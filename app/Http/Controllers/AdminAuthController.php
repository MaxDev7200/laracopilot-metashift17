<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        // If already logged in, redirect to dashboard
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Try to find user by email
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Authentication successful
            session([
                'admin_logged_in' => true,
                'admin_user_id' => $user->id,
                'admin_user' => $user->name,
                'admin_email' => $user->email
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
        }

        // Authentication failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ])->withInput($request->only('email'));
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_user_id', 'admin_user', 'admin_email']);
        session()->flush();

        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
    }
}