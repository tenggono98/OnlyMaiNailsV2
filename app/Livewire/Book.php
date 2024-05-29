<?php

namespace App\Livewire;

use App\Models\MService;
use App\Models\MServiceCategory;
use App\Models\SettingWeb;
use Livewire\Component;

class Book extends Component
{

    public $selectedServices = [];
    public $total_price ;

    public $number_of_people = 1;

    public $deposit ;

    public $flagService = true, $flagPickDateAndTime = false, $flagInformationClient = false, $flagSummary = false;


    public function render()
    {
        $serviceCategory = MServiceCategory::with('services')->where('status',true)->get();

        $this->deposit = SettingWeb::where('name','=','deposit')->first();



        return view('livewire.book',compact('serviceCategory'));
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
            case 'service':
                $this->flagPickDateAndTime = true;
                break;
            case 'pickDateAndTime':
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
            case 'pickDateAndTime':
                $this->flagService = true;
                break;
            case 'informationClient':
                $this->flagPickDateAndTime = true;
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
