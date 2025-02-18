<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class OauthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleProviderCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('gauth_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                return redirect('/');

            }else{
                $password = Str::random(10);
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' =>'user',
                    'gauth_id'=> $user->id,
                    'gauth_type'=> 'google',
                    'password' => bcrypt($password)
                ]);

                Auth::login($newUser);

                return redirect('/');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
