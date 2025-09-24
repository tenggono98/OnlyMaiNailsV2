<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\User;

class SignUp extends Component
{
    use LivewireAlert;

    #[Validate('required|min:3', as: 'Full Name')]
    public $fullNameClient;
    #[Validate('required|min:3|email|unique:users,email', as: 'Email')]
    public $emailClient;
    #[Validate('required|integer|min:3|unique:users,phone', as: 'Phone Number')]
    public $phoneNumberClient;
    public $igClient;
    #[Validate('required|min:6|required_with:confrimPasswordClient|same:confrimPasswordClient', as: 'Password')]
    public $passwordClient;
    #[Validate('required|min:6|required_with:passwordClient|same:passwordClient', as: 'Confrim Password')]
    public $confrimPasswordClient;



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
        return strtolower($this->emailClient) . '|' . request()->ip();
    }

    public function store()
    {
        // Validate and create the user
        // Throttling checks (throws an exception if limit is exceeded)
        if ($this->hasTooManyRegistrationAttempts()) {
            return $this->sendLockoutResponse();
        }
        $this->validate();
        // Register New User
        $user = new User();
        $user->name = $this->fullNameClient;
        $user->email = $this->emailClient;
        $user->phone = $this->emailClient;
        $user->password = Hash::make($this->passwordClient);
        $user->role = 'user';
        if ($this->igClient)
            $user->ig_tag = $this->igClient;
        $user->save();
        try {
            $user->sendEmailVerificationNotification();
        } catch (\Throwable $exception) {
            Log::warning('Failed to send verification email during signup', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $exception->getMessage(),
            ]);
            // Bypass email failure: continue the flow without interrupting the user
        }
        $this->alert('success', 'Please check your email and verify your address');
        Auth::login($user);
        $this->dispatch('refreshHeader');
    }

    public function render()
    {
        return view('livewire.sign-up');
    }
}
