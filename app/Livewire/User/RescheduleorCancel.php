<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use App\Models\TBooking;
use App\Models\TDBooking;
use App\Models\SettingWeb;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RescheduleorCancel extends Component
{

    use LivewireAlert;

    // Variable Data
    public $booking , $detailBooking , $deposit;

    public function mount($uuid){

        $this->deposit = SettingWeb::where('name', '=', 'deposit')->first()->value;

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


    public function confirmDeposit(){

        // Get All admin
        $admin = User::where('role','=','admin')->where('status','=',true)->get();

        foreach($admin as $item){

            // Check if notif is already send
            $bookingUuidForNotification = Notification::where('referance_id','=',$this->booking->uuid)->where('is_read','=','0')->count();

            if($bookingUuidForNotification <= 0){
            // Create Notif for Admin
            $notif = new Notification;
            $notif->title_notification = 'Deposit Payment';
            $notif->description_notification = 'Please confirm deposit payment for booking code : ' . $this->booking->code_booking .'';
            $notif->referance_id = $this->booking->uuid;
            $notif->for_role_notification = 'admin';
            $notif->notif_for = $item->id;
            $notif->url = route('admin.booking',['searchBookingCode' => $this->booking->code_booking,'searchStartDate' => $this->booking->scheduleDateBook->date_schedule,'searchEndDate' => $this->booking->scheduleDateBook->date_schedule]);
            $notif->created_by = Auth::id();
            $notif->save();

            if($notif)
                $this->alert('success', 'Your schedule is being confirmed by our admin. Please wait a moment.');

            }
            else
                $this->alert('info','Your notification has been sent. Please await confirmation');




        }



    }



    public function notifCopy()
    {
        $this->alert('success', 'The code has been copy');
    }
}
