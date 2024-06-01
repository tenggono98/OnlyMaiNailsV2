<?php

namespace App\Livewire\Component\Module;

use Livewire\Component;
use Livewire\Attributes\On;

class DatePickerCalender extends Component
{

    public $enabledDates = ["2024-06-30", "2024-06-21", "2024-06-08"];

    // #[On('enabledDatesUpdated')]

    public $exampleDataBookigDate  ;

    public function  mount(){
        $this->exampleDataBookigDate = collect([
            [
                'date' => '2024-06-03',
                'time' => collect([
                    ['value' => '9:30', 'status' => false],
                    ['value' => '12:30', 'status' => false],
                    ['value' => '15:30', 'status' => false],
                    ['value' => '18:30', 'status' => false],
                ])
            ],
            [
                'date' => '2024-06-04',
                'time' => collect([
                    ['value' => '9:30', 'status' => false],
                    ['value' => '12:30', 'status' => false],
                ])
            ],
            [
                'date' => '2024-06-05',
                'time' => collect([
                    ['value' => '9:30', 'status' => false],
                    ['value' => '12:30', 'status' => false],
                ])
            ]
        ]);
    }

    public function render()
    {

        $avilabelDates = $this->exampleDataBookigDate->pluck('date');



        if($avilabelDates)
            $this->dispatch('enabledDatesUpdated', $avilabelDates);


            return view('livewire.component.module.date-picker-calender');
    }


}
