<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Models\MService;
use App\Models\TBooking;
use App\Models\TDBooking;
use App\Models\TSchedule;
use App\Models\SettingWeb;
use App\Models\TDSchedule;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Modelable;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ActionDatabase;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Booking extends Component
{

    use LivewireAlert;

    // Variable General
    public $googleCalendarLink , $is_edit = false , $id_edit , $tax = false , $deposit , $indexDate  ;

    // Variable Table
    public $booking;

    // Variable Input
    public    $totalPriceBook = 0 , $qtyBook = 1  ;

    #[Validate('required', as: 'Cusomer')]
    public $clientBook;

    #[Validate('required', as: 'Date of Booking')]
    public $dateBook;
    #[Validate('required', as: 'Time of Booking')]
    public $timeBook;
    #[Validate('required', as: 'Services')]
    #[Modelable]
    public $servicsBook = [];

    public $totalPriceTaxBook;

     // Event listener to capture selected services
     protected $listeners = ['servicesSelected','selectedCustomer','selectedDate','selectedTime','googleRedirect'];

    //  For Search
    protected $queryString = [
        'searchStartDate' => ['except' => ''],
        'searchEndDate' => ['except' => ''],
        'searchStatus' => ['except' => '']
    ];

     // Component Search
     public $searchStartDate , $searchEndDate , $searchStatus;




    public function selectedDate($selectedDate)
    {
        $this->dateBook = $selectedDate;
    }

    public function selectedTime($selectedTime)
    {
        $this->timeBook = $selectedTime;
    }

    public function bookmarkGoogleCalendar($user,$booking)
    {
        // Get User Info
        $user = User::find($user);
        // Get Booking Info
        $booking = TBooking::with('detailService','scheduleDateBook','scheduleTimeBook')->find($booking);

        // $clientName = 'John Doe';
        // $bookingDate = '2024-06-15';
        // $bookingTime = '14:00';
        // $notes = 'Client requested a deep tissue massage.';
        // $services = ['Deep Tissue Massage', 'Hot Stone Therapy'];

        $clientName = $user->name;
        $clientEmail = $user->email;
        $bookingDate = $booking->scheduleDateBook->date_schedule;
        $bookingTime = $booking->scheduleTimeBook->time;
        // $notes = 'Client requested a deep tissue massage.';
        $services = $booking->detailService->pluck('name_service')->toArray();

        // Convert booking date and time to datetime format
        $startDateTime = date('Ymd\THis\Z', strtotime("{$bookingDate} {$bookingTime}"));
        $endDateTime = date('Ymd\THis\Z', strtotime("{$bookingDate} {$bookingTime} +1 hour")); // Assuming a 1-hour booking

        // Create the details string
        // $details = urlencode("Notes: {$notes}\nServices: " . implode(', ', $services));
        $details = urlencode("Services: " . implode(', ', $services));

        // Create the Google Calendar link
        $this->googleCalendarLink = "https://calendar.google.com/calendar/render?action=TEMPLATE";
        $this->googleCalendarLink .= "&text=" . urlencode("Booking for $clientName");
        $this->googleCalendarLink .= "&dates={$startDateTime}/{$endDateTime}";
        $this->googleCalendarLink .= "&details={$details}";
        // $this->googleCalendarLink .= "&location=" . urlencode("Your Business Location");
        $this->googleCalendarLink .= "&ctz=America/Vancover"; // Adjust timezone as needed
        $this->googleCalendarLink .= "&add=" . urlencode("$clientEmail"); // Customer Email

        $this->dispatch('googleRedirect', ['link' => $this->googleCalendarLink]);

    }



    public function render()
    {

        // Get Booking Data for Table
        $booking = TBooking::with('detailService')
        ->orderBy('id');


        if($this->searchStartDate && $this->searchEndDate){
            $booking->whereRelation('scheduleDateBook', function ($query) {
                $query->whereBetween('date_schedule', [$this->searchStartDate, $this->searchEndDate]);
            });
        }

        if($this->searchStatus)
            $booking->where('status','=', ($this->searchStatus == 'active')? '1':'0');

        $this->booking = $booking->get();

        // Calculate Price
        if($this->servicsBook){
            $this->totalPriceBook = 0;
            foreach($this->servicsBook as $service){
                $this->totalPriceBook += $this->qtyBook * $service['price_service'];
            }
            if($this->tax){
                $getTax = SettingWeb::where('name','=','tax')->first()->value;
                $this->totalPriceBook = $this->totalPriceBook + ((int)$this->totalPriceBook * ((int)$getTax / 100));
            }
        }else
            $this->totalPriceBook = 0;



        return view('livewire.admin.booking')->layout('components.layouts.app-admin');
    }

    public function search(){

    }

    public function notifCopy()
    {
        $this->alert('success','The code has been copy');
    }
    public function save(){


        $this->validate();

        // Check if Edit Or Create
        if($this->is_edit){
            $booking = TBooking::find($this->id_edit);
            $booking->updated_by = Auth::user()->id;
            TDBooking::where('t_booking_id','=',$this->id_edit)->delete();
        }else{
            $booking = new TBooking();
            $booking->uuid = generateUUID(10);
            $booking->code_booking = generateBookingCode(4);
            $booking->created_by = Auth::user()->id;
        }

        // Check if Tax is On or Off
        if($this->tax == true){
            $booking->total_price_after_tax_booking = $this->totalPriceTaxBook;
        }
        $booking->t_schedule_id = $this->dateBook;
        $booking->t_d_schedule_id = $this->timeBook;
        $booking->user_id = $this->clientBook['id'];
        $booking->qty_people_booking = $this->qtyBook;
        $booking->total_price_booking = $this->totalPriceBook;
        $booking->deposit_price_booking = SettingWeb::where('name','=','Deposit')->first()->value;




        $booking->save();

        // Get ID for FK
        $bookingId = $booking->id;

        foreach($this->servicsBook as $item){
            $detailBooking = new TDBooking();
            // Set FK
            $detailBooking->t_booking_id = $bookingId;

            // Search service Name & Price
            // $service = MService::find($item['id']);
            $detailBooking->m_service_id = $item['id'];
            $detailBooking->price_service = $item['price_service'];
            $detailBooking->name_service = $item['name_service'];
            $detailBooking->save();


        }

        if($booking){
            if($this->is_edit)
            $this->alert('success', 'Data has been updated!');
            else
            $this->alert('success', 'Data has been add!');



        $this->reset();
        $this->dispatch('closeModal',['id'=>'add-modal']);


        }
       else
       $this->alert('warning', 'Data fails to be add!');

    }


    public function edit($id){
        $this->reset();
        $this->is_edit = true;
        $this->id_edit = $id;

        // Get Booking Info
        $booking = TBooking::find($this->id_edit);

        $this->dateBook = $booking->t_schedule_id;
        $this->timeBook = $booking->t_d_schedule_id;
        $this->clientBook = User::find($booking->user_id);
        $this->qtyBook = $booking->qty_people_booking;
        $this->totalPriceBook = $booking->total_price_booking;

        // Get Booking Services
        $dBooking = TDBooking::where('t_booking_id','=',$booking->id)->get();

        foreach($dBooking as $service){
            $service = MService::find($service->m_service_id);
            $this->servicsBook[] = $service;

        }






    }

    public function confirmDepositPayment(){

    }


    public function cancelBooking(){

    }


    public function rescheduleBooking(){

    }

    public function resetForm(){
        $this->reset();
        $this->servicsBook = [];
    }

    public function toggleStatus($id){
        $action = ActionDatabase::toggleStatusSingleModel('TBooking',$id);

        if($action)
         $this->alert('success', 'Status has been change!');
        else
        $this->alert('warning', 'Status fails to change!');

     }







}
