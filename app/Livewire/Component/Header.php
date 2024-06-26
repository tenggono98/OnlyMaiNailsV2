<?php

namespace App\Livewire\Component;


use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;



class Header extends Component
{
    use LivewireAlert;
    public $userId;

    protected $listeners = ['refreshHeader' => 'refreshUserId'];

    public function mount()
    {
        $this->userId = auth()->user() ? auth()->user()->id : null;
    }

    public function refreshUserId()
    {
        $this->userId = auth()->user() ? auth()->user()->id : null;
    }


    public function render()
    {
        return view('livewire.component.header');
    }

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

    public function resendverified(){


        $user = User::find(Auth::user()->id);

        if($user->sendEmailVerificationNotification()){

            $this->alert('error', "Oops, we couldn't send the email. Please give it another try later.");
        }else{
            $this->alert('success', "Don't forget to verify your email! Just check your inbox.");
        }
    }
}
