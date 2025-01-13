<?php
namespace App\Livewire\User;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\TBooking;
use App\Models\TDBooking;
use App\Models\SettingWeb;
use App\Models\TDSchedule;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class RescheduleorCancel extends Component
{
    use LivewireAlert;
    // Variable Data
    public $booking , $detailBooking , $deposit , $paymentEmail;
    // Variable For Timer
    public $timeRemaining;
    public $isExpired = false;
    // Variable for reschedule booking
    public $timeBook , $dateBook;
    protected $listeners = ['checkTimer' => 'checkTimeRemaining','selectedDate', 'selectedTime','rescheduleBooking' => '$refresh'];
    public function mount($uuid){
        if(Session::has('message_reschedule'))
            $this->alert('success',Session::get('message_reschedule'));
        $this->deposit = SettingWeb::where('name', '=', 'deposit')->first()->value;
        $this->paymentEmail = SettingWeb::where('name', '=', 'PaymentEmail')->first()->value;
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
        // Get data Avilabel Schedule booking

        

    }
    public function render()
    {
        return view('livewire.user.rescheduleor-cancel');
    }
    public function cancelBooking($uuid){
        // Get Booking ID by "UUID"
         $booking = TBooking::where('uuid','=',$this->booking->uuid)->first();
        // Reset Status Schedule and Detail Schedule
        $newScheduleTime = TDSchedule::find($booking->t_d_schedule_id);
        $newScheduleTime->is_book = '0';
        // Updated TBooking to Cancel By "Customer" (Look in Updated By)
        $booking->status = 'cancel';
        $booking->cancel_by_role = 'user';
        $booking->cancel_by = Auth::id();
        $booking->save();
        $this->alert('success','This booking is updated to cancel');
    }
    public function rescheduleBooking(){
        // Get Booking Info
        $booking = TBooking::with('detailService')->where('uuid','=',$this->booking->uuid)->first();
        if($booking->reschedule_flag_booking == '0'){
            // Create New Booking
            $newBooking = new TBooking();
            $newBooking->uuid =  generateUUID(10);
            $newBooking->code_booking =  generateBookingCode(4);
            $newBooking->created_by =  Auth::user()->id;
            $newBooking->t_schedule_id = $this->dateBook;
            $newBooking->t_d_schedule_id = $this->timeBook;
            $newBooking->user_id = Auth::user()->id;
            $newBooking->qty_people_booking = $booking->qty_people_booking;
            $newBooking->total_price_booking = $booking->total_price_booking;
            $newBooking->deposit_price_booking = $booking->deposit_price_booking;
            $newBooking->reschedule_flag_booking = '1';
            $newBooking->reschedule_booking_original_id = $booking->id;
            $newBooking->is_deposit_paid  = '1' ;
            $newBooking->confirm_payment  = '1' ;
             // Set Old Booking Flag Reschedule
             $booking->reschedule_flag_booking = '1';
             $booking->status = 'reschedule';
            // Old Time Schedule is_book
            $newScheduleTime = TDSchedule::find($booking->t_d_schedule_id);
            $newScheduleTime->is_book = '0';
            // New Time Schedule is_book
            $oldScheduleTime = TDSchedule::find($this->timeBook);
            $oldScheduleTime->is_book = '1';
            // Updated Booking date &  time
            $booking->save();
            $newBooking->save();
            $newScheduleTime->save();
            $oldScheduleTime->save();
            // Adding new schedule the services
            foreach($booking->detailService as $service){
                $tdService = new TDBooking();
                $tdService->t_booking_id = $newBooking->id;
                $tdService->m_service_id = $service->m_service_id;
                $tdService->name_service = $service->name_service;
                $tdService->price_service = $service->price_service;
                $tdService->save();
            }
            // Create Notif to Admin
            $admin = User::where('role','=','admin')->where('status','=',true)->get();
        foreach($admin as $item){
            $notif = new Notification;
            $notif->title_notification = 'Reschedule Booking';
            $notif->description_notification = 'Client has been reschedule booking code : ' . $this->booking->code_booking .'';
            $notif->referance_id = $this->booking->uuid;
            $notif->for_role_notification = 'admin';
            $notif->notif_for = $item->id;
            $notif->url = route('admin.booking',['searchBookingCode' => $this->booking->code_booking,'searchStartDate' => $this->booking->scheduleDateBook->date_schedule,'searchEndDate' => $this->booking->scheduleDateBook->date_schedule]);
            $notif->created_by = Auth::id();
            $notif->save();
            }
            if($booking && $newScheduleTime && $oldScheduleTime){
                $this->dispatch('closeModal', ['id' => 'reschedule-modal']);
                return redirect(route('user.reschedule_or_cancel',['uuid'=>$newBooking->uuid]))->with('message_reschedule','Your reschedule has been saved');
            }
        }else{
            $this->alert('danger','This booking is already reschedule once');
        }
    }
    public function selectedDate($selectedDate)
    {
        $this->dateBook = $selectedDate;
    }
    public function selectedTime($selectedTime)
    {
        $this->timeBook = $selectedTime;
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
        $this->alert('success', 'The content has been copy to clipboard');
    }
    public function initializeTimer()
    {
        $getLimitPayment = SettingWeb::where('name','=','LimitDepositPayment_h')->first()->value;
        $createdAt = Carbon::parse($this->booking->created_at);
        $deadline = $createdAt->addHours((int) $getLimitPayment);
        $now = Carbon::now();
        if ($now->greaterThanOrEqualTo($deadline)) {
            // If current time is past the deadline
            $this->timeRemaining = 0;
            $this->isExpired = true;
        } else {
            $this->timeRemaining = $deadline->diff($now)->format('%H:%I:%S');
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
