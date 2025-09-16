<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use App\Models\Baby;

class LoginController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('baby.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Debug info: check if a baby exists for the provided email and whether the hash matches
        try {
            $email = $request->input('email');
            $baby = Baby::where('mother_email', $email)->first();
            if ($baby) {
                $pwMatches = \Illuminate\Support\Facades\Hash::check($request->input('password'), $baby->password);
                Log::info('Login attempt for baby email', ['email' => $email, 'baby_id' => $baby->id, 'password_matches' => $pwMatches, 'updated_at' => $baby->updated_at]);
            } else {
                Log::info('Login attempt - baby not found for email', ['email' => $email]);
            }
        } catch (\Throwable $e) {
            Log::error('Error during login debug check', ['error' => $e->getMessage()]);
        }

        // Check if the user has too many login attempts
        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $this->clearLoginAttempts($request);
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        // Use the 'baby' guard so authentication checks the babies provider/model
        return Auth::guard('baby')->attempt(
            $this->babyCredentials($request),
            $request->filled('remember')
        );
    }

    /**
     * Get the login credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    /**
     * Credentials mapped for baby authentication.
     * Babies use 'mother_email' as the identifier in the babies table.
     */
    protected function babyCredentials(Request $request)
    {
        return [
            'mother_email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        // If logged in as a baby (via baby guard) redirect to baby dashboard.
        if (Auth::guard('baby')->check()) {
            // Log guard state for debugging: confirm guard persisted after session regeneration
            try {
                $babyUser = Auth::guard('baby')->user();
                Log::info('Login successful - baby guard check', ['guard_check' => true, 'baby_id' => $babyUser ? $babyUser->id : null]);
            } catch (\Throwable $e) {
                Log::error('Login successful - baby guard check failed', ['error' => $e->getMessage()]);
            }

            return redirect()->intended(route('baby.dashboard'))
                ->with('status', 'You have been successfully logged in!');
        }

        // Also log default guard case for completeness
        try {
            $user = Auth::user();
            Log::info('Login successful - default guard', ['user_id' => $user ? $user->id : null]);
        } catch (\Throwable $e) {
            Log::error('Login successful - default guard check failed', ['error' => $e->getMessage()]);
        }

        return redirect()->intended(route('dashboard'))
            ->with('status', 'You have been successfully logged in!');
    }

    /**
     * Send the failed login response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }

    /**
     * Check if the user has too many login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return RateLimiter::tooManyAttempts(
            $this->throttleKey($request),
            5 // Max attempts
        );
    }

    /**
     * Increment the login attempts for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function incrementLoginAttempts(Request $request)
    {
        RateLimiter::hit(
            $this->throttleKey($request),
            60 // Decay time in seconds (1 minute)
        );
    }

    /**
     * Clear the login attempts for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function clearLoginAttempts(Request $request)
    {
        RateLimiter::clear($this->throttleKey($request));
    }

    /**
     * Send the lockout response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email' => [trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ])],
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Logout from baby guard if authenticated as baby, otherwise default
        if (Auth::guard('baby')->check()) {
            Auth::guard('baby')->logout();
        } else {
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('status', 'You have been logged out!');
    }
}
