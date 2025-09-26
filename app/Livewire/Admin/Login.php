<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;



class Login extends Component
{

    public $email , $password;

    public function render()
    {
        return view('livewire.admin.login');
    }


    public function login(){


        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials)) {
            dd('loggg');
            // Session::regenerate();
            // Authentication passed
            // if(Auth::user() && Auth::user()->role != 'user'){
            //     $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
            //    } else {
            //        Auth::guard('web')->logout();
            //         redirect()->route('login')->with('status', 'You are not authorized to access this page.');
            //    }
        }



    }
}
