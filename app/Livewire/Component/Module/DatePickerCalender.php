<?php

namespace App\Livewire\Component\Module;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\TSchedule;
use Livewire\Attributes\On;

class DatePickerCalender extends Component
{


    public function render()
    {


        $avilabelDates = TSchedule::where('status','=',1)
        ->whereDate('date_schedule','>=',Carbon::today())
        ->pluck('date_schedule')->toArray();




        if($avilabelDates)
            $this->dispatch('enabledDatesUpdated', $avilabelDates);


            return view('livewire.component.module.date-picker-calender');
    }


}
