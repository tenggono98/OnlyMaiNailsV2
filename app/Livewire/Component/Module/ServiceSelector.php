<?php

namespace App\Livewire\Component\Module;

use stdClass;
use Livewire\Component;
use App\Models\MService;
use App\Models\MServiceCategory;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Modelable;

class ServiceSelector extends Component
{
    public $searchTerm = '';

    public $selectedServices = [];
    public $services = [];

    public $servicesCategory , $servicesCategorySelected ;
    #[Modelable]
    public $servicsBook;


    public function mount(){
          // Get Services Category
          $this->servicesCategory = MServiceCategory::where('status','=','1')->get();
          $this->servicsBook = new stdClass();
    }


    public function updatedSearchTerm()
    {
        if($this->servicesCategorySelected){
            $this->services = MService::where('m_service_category_id','=',$this->servicesCategorySelected)->where('name_service', 'like', '%' . $this->searchTerm . '%')
            ->get();
        }
    }

    public function selectService($servicesId)
    {

        $this->servicsBook[] = MService::with('category')->find($servicesId)->toArray();
        // dd($this->servicsBook);
        $this->searchTerm = null;
        $this->services = [];

    }

    public function clearSelection()
    {
        $this->servicesCategorySelected = null;
        $this->servicsBook = [];
        $this->searchTerm = '';
        $this->services = [];
    }
    public function render()
    {





        return view('livewire.component.module.service-selector');
    }
}
