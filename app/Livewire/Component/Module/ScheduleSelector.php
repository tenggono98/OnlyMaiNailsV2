<?php

namespace App\Livewire\Component\Module;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\TSchedule;

class ScheduleSelector extends Component
{
    // Variable General
    public $dataBookingDate , $timeSelected , $selectedDate , $dateId , $indexDate;

    // Variable Get
    public $getSelectedDate , $getSelectedTime ,$getIndexDate;

    public function mount($getSelectedDate = null , $getSelectedTime = null , $getIndexDate = null){
        $this->selectedDate = $getSelectedDate;
        $this->timeSelected = $getSelectedTime;
        $this->indexDate = $getIndexDate;

    }


    public function updatedSelectedDate($value,$key)
    {

        // if ($value) {
        //     list($index, $id) = explode('-', $value);
        //     $this->indexDate = $index;
        //     $this->dateId = $value;

        // } else {
        //     $this->indexDate = null;
        //     $this->dateId = null;
        // }
    }

    public function render()
    {

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






        $this->dispatch('selectedDate', $this->selectedDate  );
        $this->dispatch('selectedTime', $this->timeSelected);


        return view('livewire.component.module.schedule-selector');
    }



}
