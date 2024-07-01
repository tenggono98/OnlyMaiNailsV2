<?php

namespace App\Livewire\Component\Module;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TitleUpdater extends Component
{


    public $notificationCount = 0;

    public function mount()
    {
        $this->updateNotificationCount();
    }

    public function updateNotificationCount()
    {
        // Fetch the count of unread notifications
         $this->notificationCount = Notification::where('for_role_notification','=','admin')->where('notif_for','=',Auth::id())->where('is_read','=','0')->count();
    }


    public function render()
    {

        $title = $this->notificationCount > 0
        ? "{$this->notificationCount} Notif | Only Mai Nails"
        : "Admin | Only Mai Nails";

    $this->dispatch('title-update', ['title' => $title]);
        return view('livewire.component.module.title-updater');
    }
}
