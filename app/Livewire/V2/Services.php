<?php

namespace App\Livewire\V2;

use App\Models\MServiceCategory;
use Livewire\Component;

class Services extends Component
{
    public function render()
    {
        $services = MServiceCategory::with(['services' => function ($q){
            $q->where('status','=','1')->orderBy('order','ASC');
        }])->where('status','=','1')->get();

        return view('livewire.v2.services',compact('services'));
    }
}
