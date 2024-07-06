<?php
namespace App\Livewire;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\MService;
use App\Models\TBooking;
use App\Models\TDBooking;
use App\Models\TSchedule;
use App\Models\SettingWeb;
use App\Livewire\Actions\Logout;
use App\Models\MServiceCategory;
use App\Models\TDSchedule;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Validation\ValidationException;
class Book extends Component
{
    use LivewireAlert;
    // Variable Input
    public   $indexDate,  $dataBookingDate , $deposit;
    // Variable Input (Policies)
    public $agree_checkbox;
    // Variable Input (Client Information)
    #[Validate('required|min:3', as: 'Full Name')]
    public $fullNameClient;
    #[Validate('required|min:3|email|unique:users,email', as: 'Email')]
    public $emailClient;
    #[Validate('required|min:3|unique:users,phone', as: 'Phone Number')]
    public $phoneNumberClient;
    public $igClient;
    #[Validate('required|min:6|required_with:confrimPasswordClient|same:confrimPasswordClient', as: 'Password')]
    public $passwordClient;
    #[Validate('required|min:6|required_with:passwordClient|same:passwordClient', as: 'Confrim Password')]
    public $confrimPasswordClient;
    // ---------------------------------
    // Variable Input (Date & Time)
    public $timeBooking, $dateBooking ,  $number_of_people = 1 , $selectedDate , $selectedTime;
    // ----------------------------------
    // Variable Input (Services)
    public $totalPriceBook ,$selectedServices = [] , $total_price;
    // ---------------------------------
    // Variable Views Section
    public $flagPolicies = true, $flagInformationClient = false, $flagPickDateAndTime = false, $flagService = false,  $flagSummary = false;
     // ---------------------------------
    protected $listeners = ['selectedDate'];
    public function render()
    {
        // Set Time Booking
        if($this->timeBooking)
            $this->selectedTime = TDSchedule::find($this->timeBooking)->time;
        // Set Price for Deposit
        $this->deposit = SettingWeb::where('name', '=', 'deposit')->first()->value;
        // Get Master Service for table
        $serviceCategory = MServiceCategory::with(['services' => function ($q) {
            $q->where('status', '=', true);
        }])
            ->where('status', true)
            ->get();
        $this->dataBookingDate = TSchedule::with(['times' => function ($query) {
            // Get current date and time
            $currentDate = Carbon::today();
            $currentTime = Carbon::now()->format('H:i');
            // Join with TSchedule to get date_schedule
            $query->where(function ($subQuery) use ($currentDate, $currentTime) {
                $subQuery->where(function ($q) use ($currentDate, $currentTime) {
                    // For today's schedules, filter times greater than or equal to the current time
                    $q->whereRelation('date', 'date_schedule', '=', $currentDate)
                        ->where('time', '>=', $currentTime);
                })
                    ->orWhere(function ($q) use ($currentDate) {
                        // For future schedules, load all times
                        $q->whereRelation('date', 'date_schedule', '>', $currentDate);
                    });
            });
        }])
            ->whereDate('date_schedule', '>=', Carbon::today())
            ->where('status', '=', 1)
            ->get();
        // Calculate Booking Price
         if ($this->selectedServices) {
            $this->totalPriceBook = 0;
            foreach ($this->selectedServices as $service) {
                $this->totalPriceBook += $this->number_of_people * $service['price'];
            }
            // if ($this->tax) {
            //     $getTax = SettingWeb::where('name', '=', 'tax')->first()->value;
            //     $this->totalPriceBook = $this->totalPriceBook + ((int)$this->totalPriceBook * ((int)$getTax / 100));
            // }
        } else
            $this->totalPriceBook = 0;
        return view('livewire.book', compact('serviceCategory'));
    }
    public function selectedDate($date)
    {
        // Set Selected Date (Dates)
        $this->selectedDate = $date;
        // Set Selected Date (ID)
        $this->dateBooking = TSchedule::where('date_schedule', '=', $date)->first()->id;
        $filteredBooks = array_filter($this->dataBookingDate->toArray(), function ($schedule) use ($date) {
            return $schedule["date_schedule"] === $date;
        });
        // dd($filteredBooks);
        $this->indexDate = array_keys($filteredBooks)[0];
    }
    public function save()
    {
        $booking = new TBooking();
        $booking->uuid = generateUUID(10);
        $booking->code_booking = generateBookingCode(4);
        $booking->created_by = Auth::user()->id;
        $booking->t_schedule_id = $this->dateBooking;
        $booking->t_d_schedule_id = $this->timeBooking;
        $booking->user_id = Auth::user()->id;
        $booking->qty_people_booking = $this->number_of_people;
        $booking->total_price_booking = $this->totalPriceBook;
        $booking->deposit_price_booking = $this->deposit;
        $booking->save();
        // Get ID for FK
        $bookingId = $booking->id;
        foreach ($this->selectedServices as $item) {
            $detailBooking = new TDBooking();
            // Set FK
            $detailBooking->t_booking_id = $bookingId;
            $detailBooking->m_service_id = $item['id'];
            $detailBooking->price_service = $item['price'];
            $detailBooking->name_service = $item['name'];
            $detailBooking->save();
        }
        $uuidBooking = $booking->uuid;
        return redirect(route('user.reschedule_or_cancel',['uuid' => $uuidBooking]));
    }
    // Service Section
    public function toggleService($idService, $type_input)
    {
        // Find the service with its category
        $service = MService::with('category')->where('status', '=', true)->find($idService);
        if ($type_input == 'checkbox') {
            // Check if the service is already selected
            $index = collect($this->selectedServices)->search(function ($selectedService) use ($idService) {
                return $selectedService['id'] === $idService;
            });
            // If the service is already selected, remove it
            if ($index !== false) {
                unset($this->selectedServices[$index]);
                // Reindex the array
                $this->selectedServices = array_values($this->selectedServices);
            } else {
                // If the service is not selected, add it
                $this->selectedServices[] = [
                    'id' => $idService,
                    'category' => $service->category->name_service_categori,
                    'name' => $service->name_service,
                    'price' =>  $service->price_service,
                    'qty' => "1"
                ];
            }
        } elseif ($type_input == 'radio') {
            // Check if any service from the same category is already selected
            $selectedCategory = collect($this->selectedServices)->firstWhere('category', $service->category->name_service_categori);
            if ($selectedCategory) {
                // If a service from the same category is selected, replace it with the new one
                $this->selectedServices = array_filter($this->selectedServices, function ($selectedService) use ($service) {
                    return $selectedService['category'] !== $service->category->name_service_categori;
                });
            }
            // Add the new service
            $this->selectedServices[] = [
                'id' => $idService,
                'category' => $service->category->name_service_categori,
                'name' => $service->name_service,
                'price' =>  $service->price_service,
                'qty' => "1"
            ];
        }
    }
    // ------------------------
    // Page Section
    public function next($currentStep)
    {
        //  $flagService = false, $flagPickDateAndTime = false, $flagInformationClient = true, $flagSummary = false;
        switch ($currentStep) {
            case ('flagPolicies'):
                if ($this->agree_checkbox == false) {
                    $this->alert('info', 'Please agree to all policies to continue');
                    return false;
                } else {
                    $this->resetFlags();
                    $this->flagInformationClient = true;
                }
                break;
            case 'informationClient':
                if (Auth::user() == null) {
                    // Throttling checks (throws an exception if limit is exceeded)
                    if ($this->hasTooManyRegistrationAttempts()) {
                        return $this->sendLockoutResponse();
                    }
                    $this->alert('info', 'Please create your account to get started');
                    $this->validate();
                    // Register New User
                    $user = new User();
                    $user->name = $this->fullNameClient;
                    $user->email = $this->emailClient;
                    $user->phone = $this->emailClient;
                    $user->password = Hash::make($this->passwordClient);
                    $user->role = 'user';
                    if ($this->igClient)
                        $user->ig_tag = $this->igClient;
                    $user->save();
                    $user->sendEmailVerificationNotification();
                    $this->alert('success', 'Please check your email and verify your address');
                    Auth::login($user);
                    $this->resetFlags();
                    $this->flagPickDateAndTime = true;
                    $this->dispatch('refreshHeader');
                } else {
                    if (Auth::user()->phone == null || Auth::user()->ig_tag) {
                        $user = User::find(Auth::user()->id);
                        if (Auth::user()->phone == null && $this->phoneNumberClient !== null) {
                            $validated = Validator::make(
                                ['phoneNumberClient' => $this->phoneNumberClient],
                                ['phoneNumberClient' => 'required']
                            )->validate();
                            $user->phone = $this->phoneNumberClient;
                            $user->save();
                            $this->alert('success', 'Your Data has been updated');
                        }
                        if (Auth::user()->ig_tag == null && $this->igClient !== null) {
                            $user->ig_tag = $this->igClient;
                            $user->save();
                            $this->alert('success', 'Your Data has been updated');
                        }
                    }
                    $this->resetFlags();
                    $this->flagPickDateAndTime = true;
                }
                break;
            case 'pickDateAndTime':
                if ($this->selectedDate == null || $this->selectedTime == null) {
                    $this->alert('info', 'Please pick a date and time that suits you ');
                    return false;
                } else {
                    $this->resetFlags();
                    $this->flagService = true;
                }
                break;
            case 'service':
                if (empty($this->selectedServices)) {
                    $this->alert('info', "Please choose the services you'd like");
                    return false;
                } else {
                    $this->resetFlags();
                    $this->flagSummary = true;
                }
                break;
            case 'summary':
                // Process the final step
                break;
        }
    }
    protected function hasTooManyRegistrationAttempts()
    {
        $maxAttempts = 5;
        $decayMinutes = 1;
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey(),
            $maxAttempts,
            $decayMinutes
        );
    }
    protected function sendLockoutResponse()
    {
        $seconds = $this->limiter()->availableIn($this->throttleKey());
        throw ValidationException::withMessages([
            'email' => [trans('auth.throttle', ['seconds' => $seconds])],
        ]);
    }
    protected function limiter()
    {
        return app('Illuminate\Cache\RateLimiter');
    }
    protected function throttleKey()
    {
        return strtolower($this->emailClient) . '|' . request()->ip();
    }
    public function back($currentStep)
    {
        $this->resetFlags();
        //  $flagService = false, $flagPickDateAndTime = false, $flagInformationClient = true, $flagSummary = false;
        switch ($currentStep) {
            case 'pickDateAndTime':
                $this->flagInformationClient = true;
                break;
            case 'service':
                $this->flagPickDateAndTime = true;
                break;
            case 'summary':
                $this->flagService = true;
                break;
        }
    }
    private function resetFlags()
    {
        $this->flagPolicies = false;
        $this->flagService = false;
        $this->flagPickDateAndTime = false;
        $this->flagInformationClient = false;
        $this->flagSummary = false;
    }
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
    // ------------------------
}
