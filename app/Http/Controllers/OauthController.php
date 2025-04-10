<?php
namespace App\Http\Controllers;

use App\Livewire\Admin\Setting;
use App\Mail\UserGoogleRegistration;
use App\Models\SettingWeb;
use Exception;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\ValidationException;
class OauthController extends Controller
{
     // Generate "Rand" password for user
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('gauth_id', $user->id)->first();
            if ($finduser) {
                // Check if user status is '0'
                if ($finduser->status == '0') {
                    return redirect()->route('user.login')->withErrors(['email' => 'Your account has been disabled by our admin. Please contact us for more information']);
                }
                Auth::login($finduser);
                return redirect('/');
            } else {
                $rand_pass = generateBookingCode(8);

                // Create new user
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => 'user',
                    'gauth_id' => $user->id,
                    'gauth_type' => 'google',
                    'password' => $rand_pass
                ]);
                // Send mail for registration
                $mailData = [
                    'clientName' => $user->name,
                    'password' => $rand_pass,
                    'mail' => getSettingWeb('PaymentEmail'),
                    'address' => getSettingWeb('Address'),

                ];
                Mail::to($user->email)->send(new UserGoogleRegistration($mailData));
                // Login user to system
                Auth::login($newUser);
                // Redirect user to "Home" page
                return redirect('/');
            }
        } catch (Exception $e) {
            // Handle the exception and return a user-friendly message
            return redirect()->route('user.login')->withErrors(['email' => 'Failed to authenticate with Google.']);
        }
    }
}
