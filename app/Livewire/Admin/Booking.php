<?php
namespace App\Livewire\Admin;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\MService;
use App\Models\TBooking;
use App\Mail\MailBooking;
use App\Models\TDBooking;
use App\Models\TSchedule;
use App\Models\SettingWeb;
use App\Models\TDSchedule;
use App\Models\Notification;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Modelable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ActionDatabase;
use App\Http\Controllers\Pdf\BookingInvoice;
use App\Http\Controllers\Pdf\BookingComplete;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Layout('components.layouts.app-admin')]
class Booking extends Component
{
    use LivewireAlert;
    // Variable General
    public $googleCalendarLink, $is_edit = false, $id_edit, $tax = false, $deposit, $indexDate;
    // Variable Table
    public $booking;
    // Variable Input
    public    $totalPriceBook = 0, $qtyBook = 1;
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
    protected $listeners = ['servicesSelected', 'selectedCustomer', 'selectedDate', 'selectedTime', 'googleRedirect'];
    //  For Search
    protected $queryString = [
        'searchStartDate' => ['except' => ''],
        'searchEndDate' => ['except' => ''],
        'searchStatus' => ['except' => ''],
        'searchBookingCode' => ['except' => ''],
        'searchDepositStatus' => ['except' => ''],
    ];
    // Component Search
    public $searchStartDate, $searchEndDate, $searchStatus , $searchBookingCode , $searchDepositStatus;
    public $exludeResetVariable = ['searchStartDate','searchEndDate','searchStatus','searchBookingCode','searchDepositStatus'];
    public function render()
    {
        // Get Booking Data for Table
        $booking = TBooking::with('detailService')
            ->orderBy('id');
        // Search Dates
        if ($this->searchStartDate && $this->searchEndDate) {
            $booking->whereRelation('scheduleDateBook', function ($query) {
                $query->whereBetween('date_schedule', [$this->searchStartDate, $this->searchEndDate]);
            });
        }else{
            $booking->whereRelation('scheduleDateBook', function ($query) {
                $query->where('date_schedule', Carbon::today());
            });
        }
        // Search Status
        if ($this->searchStatus)
            $booking->where('status', '=', ($this->searchStatus == 'active') ? '1' : '0');
        // Search Code
        if ($this->searchBookingCode)
            $booking->where('code_booking','LIKE', '%'. $this->searchBookingCode . '%');
        // Search Deposit Status
        if ($this->searchDepositStatus)
            $booking->where('is_deposit_paid', '=', ($this->searchDepositStatus == 'paid') ? '1' : '0');
        $this->booking = $booking->get();
        // Calculate Price
        if ($this->servicsBook) {
            $this->totalPriceBook = 0;
            foreach ($this->servicsBook as $service) {
                $this->totalPriceBook += $this->qtyBook * $service['price_service'];
            }
            if ($this->tax) {
                $getTax = SettingWeb::where('name', '=', 'tax')->first()->value;
                if($getTax > 0){
                $this->totalPriceBook = $this->totalPriceBook + ((int)$this->totalPriceBook * ((int)$getTax / 100));
                }
            }
        } else
            $this->totalPriceBook = 0;
        return view('livewire.admin.booking');
    }
    public function search()
    {
    }
    public function notifCopy()
    {
        $this->alert('success', 'The code has been copy');
    }
    public function save()
    {
        $this->validate();
        // Check if Edit Or Create
        if ($this->is_edit) {
            $booking = TBooking::find($this->id_edit);
            $booking->updated_by = Auth::user()->id;
            // Get old Schedule set it to NOT BOOKING and Set booking to new selected schedule
            if($booking->scheduleTimeBook->id !==  $this->timeBook){
                $booking->scheduleTimeBook->is_book = '0';
                $booking->scheduleTimeBook->save();
            }
            // Delete old Detail Booking
            TDBooking::where('t_booking_id', '=', $this->id_edit)->delete();
        } else {
            $booking = new TBooking();
            $booking->uuid = generateUUID(10);
            $booking->code_booking = generateBookingCode(4);
            $booking->created_by = Auth::user()->id;
        }
        // Check if Tax is On or Off
        if ($this->tax == true) {
            $booking->total_price_after_tax_booking = $this->totalPriceTaxBook;
        }
        $booking->t_schedule_id = $this->dateBook;
        $booking->t_d_schedule_id = $this->timeBook;
        $booking->user_id = $this->clientBook['id'];
        $booking->qty_people_booking = $this->qtyBook;
        $booking->total_price_booking = $this->totalPriceBook;
        $booking->deposit_price_booking = SettingWeb::where('name', '=', 'Deposit')->first()->value;
        $booking->save();
        // Get ID for FK
        $bookingId = $booking->id;
        foreach ($this->servicsBook as $item) {
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
        // Set Time Booking
        $scheduleTime = TDSchedule::find($this->timeBook);
        $scheduleTime->is_book = '1';
        $scheduleTime->save();
        if ($booking) {
            if ($this->is_edit)
                $this->alert('success', 'Data has been updated!');
            else
                $this->alert('success', 'Data has been add!');
           $this->resetExcept($this->exludeResetVariable);
            $this->dispatch('closeModal', ['id' => 'add-modal']);
        } else
            $this->alert('warning', 'Data fails to be add!');
    }
    public function edit($id)
    {
       $this->resetExcept($this->exludeResetVariable);
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
        $dBooking = TDBooking::where('t_booking_id', '=', $booking->id)->get();
        foreach ($dBooking as $service) {
            $service = MService::find($service->m_service_id);
            $this->servicsBook[] = $service;
        }
    }
    public function confirmDepositPayment($id)
    {
        // Get Booking Information
        $booking = TBooking::find($id);
        // Get Booking Services Information
        $detailBooking = TDBooking::with('service.category')->where('t_booking_id','=',$id)->get();
        // Update Booking Schedule time
        $scheduleTime = TDSchedule::find($booking->t_d_schedule_id);
        if ($booking->is_deposit_paid == false) {
            // Update Deposit Status to "True"
            $booking->is_deposit_paid = '1';
            // Update Schedule booking Status to "True"
            $scheduleTime->is_book = '1';
            // Generate PDF
            BookingComplete::createPDF($id);
            BookingInvoice::createPDF($id);
            // Send Email to Client
                // Get File Information
                $date_booking = \Carbon\Carbon::parse($booking->scheduleDateBook->date_schedule)->format('d-m-Y');
                $uuid = $booking->uuid;
                // download PDF file with download method
                $fileName = storage_path('app/public/PDF_Booking_Confirmation/OMN_Appointment_Confirmation_'.$date_booking.'_'.$uuid.'.pdf');
                $fileNameInvoice = storage_path('app/public/PDF_Booking_Invoice/OMN_Invoice_'.$date_booking.'_'.$uuid.'.pdf');

            $mailData = [
                'clientName' => $booking->client->name,
                'booking_date' => \Carbon\Carbon::parse($booking->scheduleDateBook->date_schedule)->format('l , d F Y'),
                'booking_time' => \Carbon\Carbon::parse($booking->scheduleTimeBook->time)->format('h:i A'),
                'uuid' =>$uuid,
                'services' => $detailBooking->toArray(),
                'files' =>
                [
                    $fileName,
                    $fileNameInvoice
                ]
            ];
            // Send Email to Client
            Mail::to($booking->client->email)->send(new MailBooking($mailData));
            // Send Notification
            $notif = new Notification;
            $notif->title_notification = 'Deposit Payment Confirm';
            $notif->description_notification = 'Your deposit payment for booking code : ' . $booking->code_booking .'. Has been confirm';
            $notif->referance_id = $booking->uuid;
            $notif->for_role_notification = 'user';
            $notif->notif_for = $booking->client->id;
            $notif->url = route('user.reschedule_or_cancel',[$booking->uuid]);
            $notif->created_by = Auth::id();
            $notif->save();
            $this->alert('success','Mail Has Been Send');
        } else {
            // Update Deposit Status to "False"
            $booking->is_deposit_paid = '0';
            // Update Schedule booking Status to "False"
            $scheduleTime->is_book = '0';
              // Send Notification
              $notif = new Notification;
              $notif->title_notification = 'Deposit Payment Cancel';
              $notif->description_notification = 'Your deposit payment for booking code : ' . $booking->code_booking .'. Has been cancel';
              $notif->referance_id = $booking->uuid;
              $notif->for_role_notification = 'user';
              $notif->notif_for = $booking->client->id;
              $notif->url = route('user.reschedule_or_cancel',[$booking->uuid]);
              $notif->created_by = Auth::id();
              $notif->save();
        }
        $booking->save();
        $scheduleTime->save();
        if ($booking) {
            $this->alert('success', 'Deposit has been updated!');
            $this->resetExcept($this->exludeResetVariable);
        } else
            $this->alert('warning', 'Deposit fails to be updated!');
    }
    public function cancelBooking()
    {
    }
    public function rescheduleBooking()
    {
    }
    public function completeBooking($uuid){
        $booking = TBooking::find($uuid);

        if($booking->status !== 'completed'){
         $booking->status = 'completed';
         $notif = new Notification;
         $notif->title_notification = 'Booking Complete';
         $notif->description_notification = 'Your booking for booking code : ' . $booking->code_booking .'. Has been complete';
         $notif->referance_id = $booking->uuid;
         $notif->for_role_notification = 'user';
         $notif->notif_for = $booking->client->id;
         $notif->url = route('user.reschedule_or_cancel',[$booking->uuid]);
         $notif->created_by = Auth::id();
         $notif->save();

        }
        else
        $booking->status = '1';

        $booking->save();

        if($booking)
            $this->alert('success','The booking has been completed');
        else
            $this->alert('danger','Oops, something when wrong please try again');

    }
    public function resetForm()
    {
       $this->resetExcept($this->exludeResetVariable);
        $this->servicsBook = [];
    }
    public function toggleStatus($id)
    {
        $action = ActionDatabase::toggleStatusSingleModel('TBooking', $id);
        if ($action)
            $this->alert('success', 'Status has been change!');
        else
            $this->alert('warning', 'Status fails to change!');
    }
    public function selectedDate($selectedDate)
    {
        $this->dateBook = $selectedDate;
    }
    public function selectedTime($selectedTime)
    {
        $this->timeBook = $selectedTime;
    }
    public function bookmarkGoogleCalendar($user, $booking)
    {
        // Get User Info
        $user = User::find($user);
        // Get Booking Info
        $booking = TBooking::with('detailService', 'scheduleDateBook', 'scheduleTimeBook')->find($booking);
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
        // $this->googleCalendarLink .= "&ctz=America/Vancover"; // Adjust timezone as needed
        $this->googleCalendarLink .= "&ctz=" . env("APP_TIMEZONE", ""); // Adjust timezone as needed
        $this->googleCalendarLink .= "&add=" . urlencode("$clientEmail"); // Customer Email
        $this->dispatch('googleRedirect', ['link' => $this->googleCalendarLink]);
    }
    public function sendEmailToClient(){
        $mailData = [
            'title' => 'This is Test Mail',
            // 'files' => [
            //     public_path('attachments/test_image.jpeg'),
            //     public_path('attachments/test_pdf.pdf'),
            // ];
        ];
        Mail::to('tenggono98@gmail.com')->send(new MailBooking($mailData));
        $this->alert('success','Mail Has Been Send');
    }
}
