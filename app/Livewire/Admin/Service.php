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
    public $searchName , $searchCategory;


    // Component Variable
    public $id_del , $is_edit = false , $id_edit;

    // Input Variable
    #[Validate('required')]
    public $serviceName,$serviceCategory,$servicePrice,$isMerge = false;


    // Listeners Component
    protected $listeners = [
        'deleteRow'
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

        $service = $service->get();


        return view('livewire.admin.service',compact('service','category'))->layout('components.layouts.app-admin');
    }


    public function save(){

        $this->validate();



        $service = new MService();
        $service->name_service = $this->serviceName;
        $service->m_service_category_id = $this->serviceCategory;
        $service->price_service = $this->servicePrice;
        $service->is_merge = ($this->isMerge == false)?'0':'1';
        $service->created_by = Auth::user()->id;
        $service->save();

        if($service){
        $this->alert('success', 'Data has been add!');
        $this->reset();
        }
       else
       $this->alert('warning', 'Data fails to be add!');



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




}
