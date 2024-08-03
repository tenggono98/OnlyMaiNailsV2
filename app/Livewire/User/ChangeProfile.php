<?php
namespace App\Livewire\User;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class ChangeProfile extends Component
{
    use LivewireAlert;
    public $userId, $user;
    // Variable User
    public $fullNameClient, $phoneNumberClient, $igTagClient, $oldPassword, $password, $confirmPassword;
    public function mount()
    {
        // // Check if the authenticated user ID matches the ID in the route
        //  if (Auth::id() != $id) {
        //     abort(403, 'Unauthorized action.');
        // }
        $this->user = Auth::user();
        // Fills Data Inputs
        $this->fullNameClient = $this->user->name;
        $this->phoneNumberClient = $this->user->phone;
        $this->igTagClient = $this->user->ig_tag;
    }
    public function render()
    {
        return view('livewire.user.change-profile');
    }
    public function save()
    {
        Validator::make(
            ['phoneNumberClient' => $this->phoneNumberClient],
            ['phoneNumberClient' => 'required|numeric']
        )->validate();

        $this->user->name = $this->fullNameClient;
        $this->user->phone = $this->phoneNumberClient;
        $this->user->ig_tag = $this->igTagClient;
        // Check if old password is provided
        if ($this->oldPassword !== null) {
           Validator::make(
                // Data to validate...
                ['oldPassword' => $this->oldPassword,
                'password' => $this->password ,
                'confirmPassword' => $this->confirmPassword],
                // Validation rules to apply...
                ['oldPassword' => 'required',
                'password' => 'required|required_with:confirmPassword|same:confirmPassword',
                'confirmPassword' => 'required|required_with:password|same:password'],
             )->validate();
            // Check if old password matches the current password
            if (Hash::check($this->oldPassword, $this->user->password)) {
                // If old password is correct, change to new password
                $this->user->password = Hash::make($this->password);
            } else {
                // If old password does not match, throw an error
                $this->alert('warning', 'The old password is incorrect.');
               return $this->reset('oldPassword','password','confirmPassword');
            }
        }
        $this->user->save();
        if ($this->user) {
            $this->alert('success', 'Your Data has been updated!');
            $this->reset('oldPassword','password','confirmPassword');

            // redirect(route('user.change_profile'));
        } else {
            $this->alert('warning', 'Oops,wrong please try again later.');
        }
    }
}
