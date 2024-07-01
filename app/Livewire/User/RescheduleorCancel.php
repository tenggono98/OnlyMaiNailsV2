<?php
namespace App\Livewire\User;
use App\Models\User;
use Livewire\Component;
use App\Models\TBooking;
use App\Models\TDBooking;
use App\Models\SettingWeb;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class RescheduleorCancel extends Component
{
    use LivewireAlert;
    // Variable Data
    public $booking , $detailBooking , $deposit;

    // Variable For Timer
    public $timeRemaining;
    public $isExpired = false;

    protected $listeners = ['checkTimer' => 'checkTimeRemaining'];

    public function mount($uuid){
        $this->deposit = SettingWeb::where('name', '=', 'deposit')->first()->value;
        try{
        $this->booking = TBooking::with('client')->where('uuid','=',$uuid)->first();
        $this->detailBooking = TDBooking::with('service.category')->where('t_booking_id','=',$this->booking->id)->get();
        }catch(\Exception $e){
            abort(403, 'Data Not Found!');
        }
        // Check if the user is the owner of the schedule
        if (Auth::id() != $this->booking->client->id) {
            abort(403, 'Unauthorized action.');
        }
        // Timer if deposit is not paid
        if (!$this->booking->is_deposit_paid) {
            $this->initializeTimer();
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

    public function initializeTimer()
    {
        $createdAt = Carbon::parse($this->booking->created_at);
        $deadline = $createdAt->addHours(2);
        $now = Carbon::now();

        if ($now->greaterThanOrEqualTo($deadline)) {
            // If current time is past the deadline
            $this->timeRemaining = 0;
            $this->isExpired = true;
        } else {
            $this->timeRemaining = $deadline->diffInSeconds($now);
        }

        // Debugging statements to check values
        // Uncomment these lines to see values in logs or UI
        // dd($createdAt, $deadline, $now, $this->timeRemaining);
        // echo "Created At: $createdAt, Deadline: $deadline, Now: $now, Time Remaining: $this->timeRemaining";
    }

    public function checkTimeRemaining()
    {
        $this->initializeTimer();

        if ($this->timeRemaining <= 0) {
            $this->isExpired = true;
            // Optionally, you could handle the booking cancellation here.
        }
    }
}
