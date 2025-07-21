<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('adminLogin'); // adjust this to your actual blade file path
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect based on user role
            if ($user->role === 'midwife') {
                return redirect()->route('midwife.dashboard');
            } elseif ($user->role === 'moh') {
                return redirect()->route('moh.dashboard');
            }

            Auth::logout();
            return back()->withErrors(['email' => 'Unauthorized role for admin access.']);
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('admin.login.form');
    }
}
