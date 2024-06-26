<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\TBooking;
use Illuminate\Support\Facades\Auth;

class RescheduleorCancel extends Component
{

    public $masterBooking ;

    public function mount($uuid){



        $booking = TBooking::with('client')->where('uuid','=',$uuid)->first();

        // dd($booking);

        // Check if the user is the owner of the schedule
        if (Auth::id() != $booking->client->id) {
            abort(403, 'Unauthorized action.');
        }

        $this->masterBooking = $booking;
    }

    public function render()
    {
        return view('livewire.user.rescheduleor-cancel');
    }
}
