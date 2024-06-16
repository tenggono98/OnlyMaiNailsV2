<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\MService;
use App\Models\TSchedule;
use App\Models\SettingWeb;
use App\Models\TDSchedule;
use App\Models\MServiceCategory;
use App\Livewire\Actions\Logout;

class Book extends Component
{

    // Variable Input
    public $selectedServices = [] , $selectedDate , $indexDate , $timeBooking , $dataBookingDate;

    // Variable Input (Client Information)
    public $fullNameClient, $emailClient, $phoneNumberClient , $igClient , $passwordClient , $confrimPasswordClient;

    public $total_price ;

    public $number_of_people = 1;

    public $deposit ;

    public $flagService = false, $flagPickDateAndTime = false, $flagInformationClient = true, $flagSummary = false;

    protected $listeners = ['selectedDate'];




    public function render()
    {
        // Get Master Service for table
        $serviceCategory = MServiceCategory::with(['services' => function($q){
            $q->where('status','=',true);
        }])
        ->where('status',true)
        ->get();

        // Get Price for Deposit
        $this->deposit = SettingWeb::where('name','=','deposit')->first();



        $this->dataBookingDate = TSchedule::with(['times' => function ($query) {
            // Get current date and time
            $currentDate = Carbon::today();
            $currentTime = Carbon::now()->format('H:i');


            // Join with TSchedule to get date_schedule
            $query->where(function($subQuery) use ($currentDate, $currentTime) {

                $subQuery->where(function($q) use ($currentDate, $currentTime) {
                    // For today's schedules, filter times greater than or equal to the current time
                    $q->whereRelation('date','date_schedule','=', $currentDate)
                    ->where('time', '>=', $currentTime);
                })
                ->orWhere(function($q) use ($currentDate) {
                    // For future schedules, load all times
                    $q->whereRelation('date','date_schedule','>', $currentDate);
                });

            });
        }])
        ->whereDate('date_schedule', '>=', Carbon::today())
        ->where('status', '=', 1)
        ->get();

        // dd( Carbon::now()->format('H:i'));
        // dd($this->dataBookingDate[0]->times);



        return view('livewire.book',compact('serviceCategory'));
    }



    public function selectedDate($date){
        // Set Selected Date
        $this->selectedDate = $date;
        $filteredBooks = array_filter($this->dataBookingDate->toArray(), function($schedule) use ($date) {
            return $schedule["date_schedule"] === $date;
        });

        // dd($filteredBooks);
        $this->indexDate = array_keys($filteredBooks)[0];
    }


    // Service Section
    public function toggleService($idService,$type_input)
    {
         // Find the service with its category
         $service = MService::with('category')->where('status','=',true)->find($idService);

        if($type_input == 'checkbox'){

            // Check if the service is already selected
            $index = collect($this->selectedServices)->search(function($selectedService) use ($idService) {
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
        }elseif($type_input == 'radio'){
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
        $this->resetFlags();
        //  $flagService = false, $flagPickDateAndTime = false, $flagInformationClient = true, $flagSummary = false;
        switch ($currentStep) {
            case 'informationClient':
                $this->flagPickDateAndTime= true;
                break;
            case 'pickDateAndTime':
                $this->flagService = true;
                break;
            case 'service':
                $this->flagSummary = true;
                break;
            case 'summary':
                // Process the final step
                break;
        }
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
