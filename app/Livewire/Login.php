<?php
namespace App\Livewire;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;
    public function mount()
    {
        if (Auth::user()) {
            return redirect(route('home'));
        }
    }
    public function render()
    {
        return view('livewire.login');
    }
    public function login()
    {

        // Validate input
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // Rate limiting key
        $key = 'login-attempts:' . Str::lower($this->email);
        // Check if too many login attempts
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => __('auth.throttle', [
                    'seconds' => RateLimiter::availableIn($key),
                    'minutes' => ceil(RateLimiter::availableIn($key) / 60),
                ]),
            ]);
        }
        // Fetch the user by email
        $user = User::where('email', $this->email)->first();
        // Check if user exists and status is not '0'
        if (!$user || $user->status == '0') {
            // Increment rate limiting counter
            RateLimiter::hit($key);
            // If user is not found or status is '0', throw validation exception
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
        // Attempt login
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            // Regenerate session ID to prevent session fixation
            session()->regenerate();
            // Clear rate limiting counter on successful login
            RateLimiter::clear($key);
            // Redirect to intended page or dashboard
            return redirect()->intended();
        }
        // Increment rate limiting counter
        RateLimiter::hit($key);
        // If login attempt fails
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }
}
