<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\MService;
use App\Models\MServiceCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ActionDatabase;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use Livewire\Attributes\Validate;

class Service extends Component
{
    use LivewireAlert;


    // Search Variable
    public $searchName , $searchCategory , $searchStatus;

    // Component Variable
    public $id_del , $is_edit = false , $id_edit;

    // Input Variable
    #[Validate('required')]
    public $serviceName,$serviceCategory,$isMerge = false;

    #[Validate('required|numeric')]
    public $servicePrice;


    // Listeners Component
    protected $listeners = [
        'deleteRow'
    ];

    protected $queryString = [
        'searchName' => ['except' => ''],
        'searchCategory' => ['except' => ''],
        'searchStatus' => ['except' => ''],
    ];


    public function render()
    {
        // Get All Service for Table
        $service = MService::orderBy('m_service_category_id');

        // Get All Category for Select
        $category = MServiceCategory::orderBy('name_service_categori')->where('status','=',true)->get();

        // Search Name
        if($this->searchName)
            $service->where('name_service','LIKE','%'.$this->searchName.'%');

        // Search Category
        if($this->searchCategory)
            $service->where('m_service_category_id','=', $this->searchCategory);


        // Search Status
        if($this->searchStatus)
            $service->where('status','=', ($this->searchStatus == 'active')? '1':'0');


        $service = $service->get();


        return view('livewire.admin.service',compact('service','category'))->layout('components.layouts.app-admin');
    }

    public function search()
    {
        // This method is intentionally left blank to allow form submission to trigger reactivity
    }


    public function save(){

        // Validate Input
        $this->validate();


        // Check if Edit Or Create
        if($this->is_edit){
            $service = MService::find($this->id_edit);
        }else{
         $service = new MService();
        }

        // Input Data
        $service->name_service = $this->serviceName;
        $service->m_service_category_id = $this->serviceCategory;
        $service->price_service = $this->servicePrice;
        $service->is_merge = ($this->isMerge == false)?'0':'1';
        $service->created_by = Auth::user()->id;
        $service->save();

        // Alert if Success
        if($service){
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
        $getService = MService::find($id);

        $this->id_edit = $id;
        $this->is_edit = true;

        // serviceName,$serviceCategory,$servicePrice,$isMerge = false;

        $this->serviceName = $getService->name_service;
        $this->serviceCategory = $getService->m_service_category_id;
        $this->servicePrice = $getService->price_service;
        $this->isMerge =  ($getService->is_merge == false)?false:true;

    }


    public function toggleStatus($id){
       $action = ActionDatabase::toggleStatusSingleModel('MService',$id);
       if($action)
        $this->alert('success', 'Status has been change!');
       else
       $this->alert('warning', 'Status fails to change!');

    }

    public function confirmDelete($name , $id){
        // Confirm Modal
        $this->confirm('Are you sure do want to delete <br> "<span class="font-bold"> '. $name .' " </span> ?', [
            'onConfirmed' => 'deleteRow',
        ]);
        // Get ID
        $this->id_del = $id;
    }

    public function deleteRow(){
        $action = ActionDatabase::deleteSingleModel('MService',$this->id_del);

        if($action)
            $this->alert('success', 'Data has been delete!');
        else
            $this->alert('warning', 'Status fails to delete!');
        // Reset ID
        $this->id_del = null;


    }

    public function resetForm(){
        $this->reset();
    }




}
