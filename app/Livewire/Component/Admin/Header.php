<?php
namespace App\Livewire\Component\Admin;
use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
class Header extends Component
{
    public $limitShowNotification = 5;

    public $showReadNotif = false;
    public function render()
    {
        // Get Notification
        // Show or Not readNotif
        if($this->showReadNotif == false)
            $notification = Notification::where('for_role_notification','=','admin')->where('notif_for','=',Auth::id())->orderBy('id','DESC')->where('is_read','=','0')->limit($this->limitShowNotification)->get();
        else
            $notification = Notification::where('for_role_notification','=','admin')->where('notif_for','=',Auth::id())->orderBy('id','DESC')->limit($this->limitShowNotification)->get();

            return view('livewire.component.admin.header',compact('notification'));
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
}
