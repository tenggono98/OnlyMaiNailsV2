<?php

namespace App\Livewire;

use App\Models\MService;
use App\Models\MServiceCategory;
use App\Models\SettingWeb;
use Livewire\Component;

class Book extends Component
{

    public $selectedServices = [] , $selectedDate , $indexDate;
    public $total_price ;

    public $number_of_people = 1;

    public $deposit ;

    public $flagService = false, $flagPickDateAndTime = true, $flagInformationClient = false, $flagSummary = false;

    protected $listeners = ['selectedDate'];


    // public $startTime = '10:00 AM';
    // public $endTime = '03:00 PM'; // Changed to 12-hour format
    // public $interval = 30;
    // public $timeSlots = [];


    public $exampleDataBookigDate ;

    public function mount()
    {

        $this->exampleDataBookigDate = collect([
            [
                'id' => 0,
                'date' => '2024-06-03',
                'time' => collect([
                    ['value' => '9:30', 'status' => true],
                    ['value' => '12:30', 'status' => false],
                    ['value' => '15:30', 'status' => false],
                    ['value' => '18:30', 'status' => false],
                ])
            ],
            [
                'id' => 1,
                'date' => '2024-06-04',
                'time' => collect([
                    ['value' => '9:30', 'status' => false],
                    ['value' => '12:30', 'status' => false],
                ])
            ],
            [
                'id' => 2,
                'date' => '2024-06-05',
                'time' => collect([
                    ['value' => '9:30', 'status' => false],
                    ['value' => '12:30', 'status' => false],
                    ['value' => '15:30', 'status' => false],
                    ['value' => '18:30', 'status' => false],
                ])
            ]
        ]);

    }

    // public function generateTimeSlots()
    // {
    //     $this->timeSlots = [];
    //     $start = strtotime($this->startTime);
    //     $end = strtotime($this->endTime);

    //     while ($start < $end) {
    //         $this->timeSlots[] = date('h:i A', $start);
    //         $start = strtotime("+{$this->interval} minutes", $start);
    //     }
    // }





    public function render()
    {
        $serviceCategory = MServiceCategory::with('services')->where('status',true)->get();
        $this->deposit = SettingWeb::where('name','=','deposit')->first();



        return view('livewire.book',compact('serviceCategory'));
    }



    public function selectedDate($date){
        $this->selectedDate = $date;

        // Search Date Based on "exampleDataBookigDate"
        $result = $this->exampleDataBookigDate->where('date','=',$date);
        $this->indexDate = $result->keys()->first();




    }


    // Service Section
    public function toggleService($idService,$type_input)
    {
         // Find the service with its category
         $service = MService::with('category')->find($idService);

        if($type_input == 'checkbox'){

            // Check if the service is already selected
            $index = collect($this->selectedServices)->search(function($selectedService) use ($idService) {
                return $selectedService['id'] === $idService;
            });

            // dd($index);

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





        // dd($this->selectedServices);
    }

    // ------------------------


    // Page Section

    public function next($currentStep)
    {
        $this->resetFlags();
        switch ($currentStep) {
            case 'pickDateAndTime':
                $this->flagService= true;
                break;
            case 'service':
                $this->flagInformationClient = true;
                break;
            case 'informationClient':
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
        switch ($currentStep) {
            case 'service':
                $this->flagPickDateAndTime = true;
                break;
            case 'informationClient':
                $this->flagService = true;
                break;
            case 'summary':
                $this->flagInformationClient = true;
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

    // ------------------------
}
