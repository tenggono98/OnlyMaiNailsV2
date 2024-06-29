<?php

namespace App\Livewire\User;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\TBooking;
use App\Models\TDBooking;
use Illuminate\Support\Facades\Auth;

class RescheduleorCancel extends Component
{

    use LivewireAlert;

    // Variable Data
    public $booking , $detailBooking ;

    public function mount($uuid){


        try{
        $this->booking = TBooking::with('client')->where('uuid','=',$uuid)->first();
        $this->detailBooking = TDBooking::with('service.category')->where('t_booking_id','=',$this->booking->id)->get();
        }catch(\Exception $e){
            abort(403, 'Data Not Found!');
        }

        // dd($booking);

        // Check if the user is the owner of the schedule
        if (Auth::id() != $this->booking->client->id) {
            abort(403, 'Unauthorized action.');
        }

    }

    public function render()
    {
        return view('livewire.user.rescheduleor-cancel');
    }


    public function cancelBooking($uuid){

        // Get Booking ID by "UUID"

        // Reset Status Schedule and Detail Schedule

        // Updated TBooking to Cancel By "Customer" (Look in Updated By)




    }

    public function notifCopy()
    {
        $this->alert('success', 'The code has been copy');
    }
}
