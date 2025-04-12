<?php
namespace App\Livewire;

use App\Livewire\Component\VerifyYourEmail;
use App\Models\User;
use App\Models\HomepageImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Livewire\Features\SupportValidation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;

class Login extends Component
{
    use LivewireAlert;

    // Login properties
    #[Validate('required|email', as: 'Email')]
    public $email;

    #[Validate('required', as: 'Password')]
    public $password;

    public $remember = false;

    // Login images
    public $loginImages;
    public $currentImageIndex = 0;

    // Registration properties
    #[Validate('required|min:3', as: 'Full Name')]
    public $register_fullName;

    #[Validate('required|min:3|email|unique:users,email', as: 'Register_email')]
    public $register_email;

    #[Validate('required|min:3|unique:users,phone', as: 'Phone Number')]
    public $register_phoneNumber;

    public $register_igTag;

    #[Validate('required|min:6|required_with:register_confirmPassword|same:register_confirmPassword', as: 'Password')]
    public $register_password;

    #[Validate('required|min:6|required_with:register_password|same:register_password', as: 'Confirm Password')]
    public $register_confirmPassword;

    public function mount()
    {
        if (Auth::user()) {
            return redirect(route('home'));
        }

        // Load login images
        $this->loadLoginImages();
    }

    protected function loadLoginImages()
    {
        // Get active login section images
        $this->loginImages = HomepageImage::where('section', 'login')
            ->where('status', '1')
            ->orderBy('display_order')
            ->get();
    }

    public function nextImage()
    {
        if (count($this->loginImages) > 0) {
            $this->currentImageIndex = ($this->currentImageIndex + 1) % count($this->loginImages);
        }
    }

    public function prevImage()
    {
        if (count($this->loginImages) > 0) {
            $this->currentImageIndex = ($this->currentImageIndex - 1 + count($this->loginImages)) % count($this->loginImages);
        }
    }

    public function setImage($index)
    {
        if ($index >= 0 && $index < count($this->loginImages)) {
            $this->currentImageIndex = $index;
        }
    }

    public function render()
    {
        return view('livewire.login');
    }

    protected function hasTooManyRegistrationAttempts()
    {
        $maxAttempts = 5;
        $decayMinutes = 1;
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey(),
            $maxAttempts,
            $decayMinutes
        );
    }

    protected function sendLockoutResponse()
    {
        $seconds = $this->limiter()->availableIn($this->throttleKey());
        throw ValidationException::withMessages([
            'register_email' => [trans('auth.throttle', ['seconds' => $seconds])],
        ]);
    }

    protected function limiter()
    {
        return app('Illuminate\Cache\RateLimiter');
    }

    protected function throttleKey()
    {
        return strtolower($this->register_email ?? $this->email) . '|' . request()->ip();
    }

    public function login()
    {
        // Debug statement to see if method is being called
        $this->alert('info', 'Processing login...');

        // Use manual validation instead of $this->validate()
        $validated = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Rate limiting key
        $key = 'login-attempts:' . Str::lower($this->email);

        // Check if too many login attempts
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('email', __('auth.throttle', [
                'seconds' => RateLimiter::availableIn($key),
                'minutes' => ceil(RateLimiter::availableIn($key) / 60),
            ]));
            $this->alert('error', 'Too many login attempts. Please try again later.');
            return;
        }

        // Fetch the user by email
        $user = User::where('email', $this->email)->first();

        // Check if user exists and status is not '0'
        if (!$user) {
            // Increment rate limiting counter
            RateLimiter::hit($key);
            // If user is not found, add specific error message
            $this->addError('email', 'We couldn\'t find an account with that email address.');
            $this->alert('error', 'We couldn\'t find an account with that email address.');
            return;
        }

        // Check if user is disabled (status = 0)
        if ($user && $user->status == '0') {
            // Increment rate limiting counter
            RateLimiter::hit($key);
            // If user status is '0', add validation error with specific message
            $this->addError('email', 'Your account has been disabled by our admin. Please contact us for more information.');
            $this->alert('error', 'Your account has been disabled.');
            return;
        }

        // Attempt login
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            // Regenerate session ID to prevent session fixation
            session()->regenerate();
            // Clear rate limiting counter on successful login
            RateLimiter::clear($key);

            // Add success message
            $this->alert('success', 'Login successful!');

            // Dispatch an event for UI refresh
            $this->dispatch('refreshHeader');
            $this->dispatch('user-authenticated');

            // Check if user has 'user' role and redirect appropriately
            if (Auth::user()->role === 'user') {
                // Redirect to user dashboard or home page
                // Make sure we're using the correct route name
                try {
                    return redirect()->route('homepage');
                } catch (\Exception $e) {
                    return redirect()->route('home');
                }
            }

            // For other roles, redirect to intended page or dashboard
            return redirect()->intended();
        }

        // Increment rate limiting counter
        RateLimiter::hit($key);

        // If login attempt fails, add specific error message for password
        $this->addError('password', 'The provided password is incorrect.');
        $this->alert('error', 'The provided password is incorrect.');
        return;
    }

    public function register()
    {
        // Throttling checks
        if ($this->hasTooManyRegistrationAttempts()) {
            return $this->sendLockoutResponse();
        }

        // Validate registration inputs
        $this->validate([
            'register_fullName' => 'required|min:3',
            'register_email' => 'required|email|unique:users,email',
            'register_phoneNumber' => 'required|min:3|unique:users,phone',
            'register_password' => 'required|min:6|same:register_confirmPassword',
            'register_confirmPassword' => 'required|min:6|same:register_password',
        ]);

        try {
            // Create new user
            $user = new User();
            $user->name = $this->register_fullName;
            $user->email = $this->register_email;
            $user->phone = $this->register_phoneNumber;
            $user->password = Hash::make($this->register_password);
            $user->role = 'user';

            if ($this->register_igTag) {
                $user->ig_tag = $this->register_igTag;
            }

            $user->save();

            // Send email verification notification
            $user->sendEmailVerificationNotification();

            // Login the new user
            Auth::login($user);

            $this->alert('success', 'Account created successfully! Please check your email to verify your address.');

            // Reset the form
            $this->reset(['register_fullName', 'register_email', 'register_phoneNumber', 'register_igTag', 'register_password', 'register_confirmPassword']);

            // Close modal using Alpine.js
            $this->dispatch('close-modal');
            $this->dispatch('refreshHeader');

            // Redirect to homepage
            return redirect()->route('homepage');

        } catch (\Exception $e) {
            $this->alert('error', 'Registration failed: ' . $e->getMessage());
        }
    }
}
