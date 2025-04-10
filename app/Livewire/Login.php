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
    public $fullName;

    #[Validate('required|min:3|email|unique:users,email', as: 'Email')]
    public $regEmail;

    #[Validate('required|min:3|unique:users,phone', as: 'Phone Number')]
    public $phoneNumber;

    public $igTag;

    #[Validate('required|min:6|required_with:confirmPassword|same:confirmPassword', as: 'Password')]
    public $regPassword;

    #[Validate('required|min:6|required_with:regPassword|same:regPassword', as: 'Confirm Password')]
    public $confirmPassword;

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
            'email' => [trans('auth.throttle', ['seconds' => $seconds])],
        ]);
    }

    protected function limiter()
    {
        return app('Illuminate\Cache\RateLimiter');
    }

    protected function throttleKey()
    {
        return strtolower($this->regEmail ?? $this->email) . '|' . request()->ip();
    }

    public function login()
    {
        $this->validate();

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
        if (!$user) {
            // Increment rate limiting counter
            RateLimiter::hit($key);
            // If user is not found, throw validation exception
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Check if user is disabled (status = 0)
        if ($user && $user->status == '0') {
            // Increment rate limiting counter
            RateLimiter::hit($key);
            // If user status is '0', throw validation exception with specific message
            throw ValidationException::withMessages([
                'email' => 'Your account has been disabled by our admin. Please contact us for more information.',
            ]);
        }

        // Attempt login
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            // Regenerate session ID to prevent session fixation
            session()->regenerate();
            // Clear rate limiting counter on successful login
            RateLimiter::clear($key);

            // Check if user has 'user' role and redirect appropriately
            if (Auth::user()->role === 'user') {
                return redirect()->route('user.login');
            }

            // For other roles, redirect to intended page or dashboard
            return redirect()->intended();
        }

        // Increment rate limiting counter
        RateLimiter::hit($key);
        // If login attempt fails
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function register()
    {
        // Throttling checks
        if ($this->hasTooManyRegistrationAttempts()) {
            return $this->sendLockoutResponse();
        }

        // Validate registration inputs
        $this->validate([
            'fullName' => 'required|min:3',
            'regEmail' => 'required|email|unique:users,email',
            'phoneNumber' => 'required|min:3|unique:users,phone',
            'regPassword' => 'required|min:6|same:confirmPassword',
            'confirmPassword' => 'required|min:6|same:regPassword',
        ]);

        try {
            // Create new user
            $user = new User();
            $user->name = $this->fullName;
            $user->email = $this->regEmail;
            $user->phone = $this->phoneNumber;
            $user->password = Hash::make($this->regPassword);
            $user->role = 'user';

            if ($this->igTag) {
                $user->ig_tag = $this->igTag;
            }

            $user->save();

            // Send email verification notification
            $user->sendEmailVerificationNotification();

            // Login the new user
            Auth::login($user);

            $this->alert('success', 'Account created successfully! Please check your email to verify your address.');

            // Reset the form
            $this->reset(['fullName', 'regEmail', 'phoneNumber', 'igTag', 'regPassword', 'confirmPassword']);

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
