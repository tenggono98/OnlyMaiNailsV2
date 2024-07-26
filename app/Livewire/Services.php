<?php

namespace App\Livewire;

use App\Models\MService;
use App\Models\MServiceCategory;
use Livewire\Component;

class Services extends Component
{

    public $services = [];

    public function render()
    {

        $this->services = MServiceCategory::with(['services' => function ($q){
            $q->where('status','=','1')->orderBy('order','ASC');
        }])->where('status','=','1')->get();


        return view('livewire.services');
    }
}
