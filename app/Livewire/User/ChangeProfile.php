<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

class ChangeProfile extends Component
{

    public $userId , $user;

    // Variable User
    public $fullNameClient, $phoneNumberClient, $igTagClient, $oldPassword , $password , $confirmPassword;

    public function mount($id){
         // Check if the authenticated user ID matches the ID in the route
         if (Auth::id() != $id) {
            abort(403, 'Unauthorized action.');
        }



        // Get Information
        $this->userId = $id;
        $this->user = \App\Models\User::findOrFail($this->userId);

        // Fills Data Inputs
        $this->fullNameClient = $this->user->name;
        $this->phoneNumberClient = $this->user->phone;
        $this->igTagClient = $this->user->ig_tag;
    }

    public function render()
    {

        return view('livewire.user.change-profile');
    }

    public function save(){
        

        // get User information
        $user = \App\Models\User::findOrFail($this->userId);

        $user->name = $this->fullNameClient;
        $user->phone = $this->phoneNumberClient;
        $user->ig_tag = $this->igTagClient;


        // Check if user changing they password
        if($this->oldPassword){

            // Check if Old Password is match with the user password now

            // If true change the password with the new one, if not throw error


        }



    }
}
