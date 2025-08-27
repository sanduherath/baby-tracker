<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Carbon\Carbon;

class BabyLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'dashboard']);
    }

    public function showLoginForm()
    {

        return view('baby.login');
    }

   public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => ['required', 'string', 'email', 'max:255'],
        'password' => ['required', 'string', 'min:6'],
    ], [
        'email.required' => 'Email is required.',
        'email.email' => 'Invalid email format.',
        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 6 characters.',
    ]);

    if ($validator->fails()) {
        Log::warning('Validation failed', ['errors' => $validator->errors()]);
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $email = trim(strtolower($request->email));
    $password = $request->password;

    Log::info('Login attempt', ['email' => $email]);

    // Check in babies table
    $baby = \App\Models\Baby::where('mother_email', $email)->first();

    if (!$baby) {
        Log::warning('No baby found for mother_email', ['email' => $email]);
        return redirect()->back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    // Check password (assuming it's hashed in the babies table)
    if (!\Illuminate\Support\Facades\Hash::check($password, $baby->password)) {
        Log::warning('Password mismatch for baby login', ['email' => $email]);
        return redirect()->back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    // Optionally, you can log the user in using session
    session(['baby_id' => $baby->id]);
    Log::info('Baby login successful', ['baby_id' => $baby->id, 'mother_email' => $email]);

    return redirect()->route('baby.dashboard');
}

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('baby.login.form');
    }

    public function showResetForm()
    {
        // return view('baby.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'mother_nic' => ['required', 'string', 'max:12'],
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'mother_nic.required' => 'Mother\'s NIC is required.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $email = trim(strtolower($request->email));
        $motherNic = strtoupper(trim($request->mother_nic));

        $user = User::where('email', $email)->where('role', 'parent')->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'No matching parent record found.'])->withInput();
        }

        $tempPassword = 'temp' . rand(1000, 9999);
        $user->password = Hash::make($tempPassword);
        $user->save();

        return redirect()->route('baby.login.form')->with('status', "Temporary password: {$tempPassword}. Change it after login.");
    }

    public function verifyCredentials(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid input.', 'errors' => $validator->errors()], 422);
        }

        $email = trim(strtolower($request->email));
        $user = User::where('email', $email)->where('role', 'parent')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials.'], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Credentials verified.',
            'user' => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email]
        ]);
    }

    public function getBabyInfo(Request $request)
    {
        $email = trim(strtolower($request->email));

        if (empty($email)) {
            return response()->json(['success' => false, 'message' => 'Email is required.'], 422);
        }

        $user = User::where('email', $email)->where('role', 'parent')->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Email not found.'], 404);
        }

        return response()->json([
            'success' => true,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    public function dashboard()
    {
        $user = Auth::guard('web')->user();
        if (!$user || $user->role !== 'parent') {
            return redirect()->route('baby.login.form')->withErrors(['email' => 'Unauthorized access.']);
        }
        return view('baby.dashboard'); // Adjust to your dashboard blade file
    }
}
