<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\TSchedule;
use App\Models\TDSchedule;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ActionDatabase;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Schedule extends Component
{
    use LivewireAlert , WithPagination;


    // Component Search
    public $searchStartDate , $searchEndDate , $searchStatus;

    // Component Variable
    public $id_del , $is_edit = false , $id_edit , $timeCount = 1;
    // Component Input
    #[Validate('required')]
    public $timeArray = [] , $scheduleDate ;


    protected $queryString = [
        'searchStartDate' => ['except' => ''],
        'searchEndDate' => ['except' => ''],
        'searchStatus' => ['except' => '']
    ];



    public function render()
    {
        // Get All Schedule for Table
        $TScheduleData = TSchedule::with('times')->orderBy('id','desc');

        // Search Start & End Date
        if($this->searchStartDate && $this->searchEndDate)
            $TScheduleData->whereBetween('date_schedule',[$this->searchStartDate,$this->searchEndDate]);

        if($this->searchStatus)
            $TScheduleData->where('status','=', ($this->searchStatus == 'active')? '1':'0');

        $TScheduleData = $TScheduleData->paginate(10);



        return view('livewire.admin.schedule',compact('TScheduleData'))->layout('components.layouts.app-admin');
    }


    public function search()
    {
        // This method is intentionally left blank to allow form submission to trigger reactivity
    }



    public function save(){

        $this->validate();

        // Check If Date already avilable
        $checkDateSchedule = TSchedule::where('date_schedule','=',$this->scheduleDate);
        if ($this->is_edit) {
            $checkDateSchedule->where('id', '!=', $this->id_edit);
        }

        if ($checkDateSchedule->exists()) {
            $this->alert('warning', 'The date has already been registered');
            return false;
        }

        // Check if Edit Or Create |  Create The Schedule Master (Date)
        if($this->is_edit){
            $TSchedule = TSchedule::find($this->id_edit);
            // Delete Old Time
            TDSchedule::where('t_schedule_id','=',$this->id_edit)->delete();
            $TSchedule->updated_by = Auth::user()->id;

        }else{
            $TSchedule = new TSchedule();
            $TSchedule->created_by = Auth::user()->id;
        }

        // Input Data
        $TSchedule->date_schedule = $this->scheduleDate;
        $TSchedule->save();

        // Get latest ID The Schedule Master
        $TScheduleId = $TSchedule->id;

        // Create The Detail Schedule (Time)
        foreach($this->timeArray as $time){

            $TDSchedule = new TDSchedule();
            $TDSchedule->created_by = Auth::user()->id;
            $TDSchedule->time = $time;
            $TDSchedule->t_schedule_id = $TScheduleId;
            $TDSchedule->save();
        }

         // Alert if Success
         if($TSchedule){
            if($this->is_edit)
            $this->alert('success', 'Data has been updated!');
            else
            $this->alert('success', 'Data has been add!');

        $this->reset();
        }
       else
       $this->alert('warning', 'Data fails to be add!');

    }

    public function edit($id){

        $this->reset();
        $this->id_edit = $id;
        $this->is_edit = true;

        $TSchedule = TSchedule::with('times')->where('id', $id)->first();
        $this->timeCount = count($TSchedule->times);


        $this->scheduleDate = $TSchedule->date_schedule;

        foreach($TSchedule->times as $t){
            $this->timeArray[] = $t->time;
        }
    }

    public function addTimeModal(){
        $this->timeCount += 1;
    }
    public function deleteTimeModal($index){
        $this->timeCount -= 1;
        // Delete Key in timeArray and rearrage the array | Remove the specific element from timeArray
        unset($this->timeArray[$index]);
        // Re-index the array
        $this->timeArray = array_values($this->timeArray);
    }

    public function toggleStatus($id){
        $action = ActionDatabase::toggleStatusSingleModel('TSchedule',$id);

        if($action)
         $this->alert('success', 'Status has been change!');
        else
        $this->alert('warning', 'Status fails to change!');

     }

    public function resetForm(){
        $this->reset();
    }

}
