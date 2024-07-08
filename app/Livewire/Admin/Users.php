<?php
namespace App\Livewire\Admin;
use Livewire\Component;
class Users extends Component
{
    // Variable for what type user is selected
    public $userType;
    public function mount($type = null){
        $this->userType = $type;
    }
    public function render()
    {
        return view('livewire.admin.users')->layout('components.layouts.app-admin');
    }
}
