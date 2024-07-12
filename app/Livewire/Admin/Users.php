<?php
namespace App\Livewire\Admin;
use App\Models\User;
use Livewire\Component;
class Users extends Component
{
    // Variable for what type user is selected
    public $userType , $users;
    // Variable General
    public $is_edit = false, $id_edit ;
    protected $queryString = [
        'type' => ['except' => '']
    ];
    public $exludeResetVariable = ['type'];
    public function mount($type = null){
        $this->userType = $type;
        if($this->userType !== null)
        $this->users = User::where('role','=',$this->userType)->get();
    }
    public function render()
    {
        return view('livewire.admin.users')->layout('components.layouts.app-admin');
    }
    public function edit(){
        if($this->userType == 'admin')
        {
        }
        elseif($this->userType == 'user')
        {
        }
    }
    public function resetForm()
    {
       $this->resetExcept($this->exludeResetVariable);
    }
}
