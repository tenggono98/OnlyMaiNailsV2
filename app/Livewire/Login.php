<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Livewire\Forms\LoginForm;
use Livewire\Attributes\Validate;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;


class Login extends Component
{
    public $email;
    public $password;

    public $remember = false;

    public function render()
    {




        return view('livewire.login');
    }


    public function login()
    {
        // Validasi input
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Implementasi Rate Limiting (opsional)
        $key = 'login-attempts:' . Str::lower($this->email);
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => __('auth.throttle', [
                    'seconds' => RateLimiter::availableIn($key),
                    'minutes' => ceil(RateLimiter::availableIn($key) / 60),
                ]),
            ]);
        }

        // Attempt login
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            // Clear Rate Limiting after successful login
            RateLimiter::clear($key);

            // Redirect to the intended page or dashboard
            return redirect()->intended('/book');
        }

        // Increment Rate Limiting counter
        RateLimiter::hit($key);

        // Jika login gagal
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }


    //  /**
    //  * Ensure the authentication request is not rate limited.
    //  */
    // protected function ensureIsNotRateLimited(): void
    // {
    //     if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
    //         return;
    //     }

    //     event(new Lockout(request()));

    //     $seconds = RateLimiter::availableIn($this->throttleKey());

    //     // throw ValidationException::withMessages([
    //     //     'form.email' => trans('auth.throttle', [
    //     //         'seconds' => $seconds,
    //     //         'minutes' => ceil($seconds / 60),
    //     //     ]),
    //     // ]);
    // }

    // /**
    //  * Get the authentication rate limiting throttle key.
    //  */
    // protected function throttleKey(): string
    // {
    //     return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    // }
}
