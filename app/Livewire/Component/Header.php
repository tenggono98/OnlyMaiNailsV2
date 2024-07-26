<?php

namespace App\Livewire\Component;


use App\Models\User;
use Livewire\Component;
use App\Models\Notification;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;



class Header extends Component
{
    use LivewireAlert;
    public $userId;

    // For Notification
    public $limitShowNotification = 5;
    public $showReadNotif = false;

    // For UI Mobile
    public $isOpen = false;


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

         // Get Notification
        // Show or Not readNotif
        if($this->showReadNotif == false)
            $notification = Notification::where('for_role_notification','=','user')->where('notif_for','=',Auth::id())->orderBy('id','DESC')->where('is_read','=','0')->limit($this->limitShowNotification)->get();
        else
            $notification = Notification::where('for_role_notification','=','user')->where('notif_for','=',Auth::id())->orderBy('id','DESC')->limit($this->limitShowNotification)->get();

        return view('livewire.component.header',compact('notification'));
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

    public function readAll(){
        // Get Notification
        $getNotification = Notification::where('notif_for','=',Auth::id())->get();
        // Update All Notification to "is_read" => true (1)
        foreach($getNotification as $item){
            $item->is_read = '1';
            $item->save();
        }
    }
    public function readNotif($notifId){
        $notif = Notification::find($notifId);
        $notif->is_read = '1';
        $notif->save();
    }

    public function showMoreNotification(){
        $this->limitShowNotification += 10;
        $this->showReadNotif = true;
    }


    public function toggleDrawer()
    {
        $this->isOpen = !$this->isOpen;
    }
}
