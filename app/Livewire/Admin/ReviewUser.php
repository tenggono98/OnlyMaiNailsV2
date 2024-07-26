<?php
namespace App\Livewire\Admin;
use Livewire\Component;
use App\Http\Controllers\ActionDatabase;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\ReviewUser as ModelsReviewUser;

class ReviewUser extends Component
{
    use LivewireAlert;

    // Variable General
    public $id_del;
    protected $listeners = [
        'deleteRow'
    ];
    public function render()
    {
        // Get all data review from user
        $review = ModelsReviewUser::all();
        return view('livewire.admin.review-user',compact('review'))->layout('components.layouts.app-admin');
    }
    public function toggleShow($id)
    {
        $review = \App\Models\ReviewUser::find($id);
        if($review->is_show_review == false)
            $review->is_show_review = '1';
        else
            $review->is_show_review = '0';
        $review->save();
        if($review)
            $this->alert('success','The comment display has been updated!');
        else
            $this->alert('danger','Oops, something when wrong please try again.');
    }
    public function toggleStatus($id){
        $action = ActionDatabase::toggleStatusSingleModel('ReviewUser',$id);
        if($action)
         $this->alert('success', 'Status has been change!');
        else
        $this->alert('warning', 'Status fails to change!');
     }
     public function confirmDelete($name, $id)
    {
        // Confirm Modal
        $this->confirm('Are you sure do want to delete comment from <br> "<span class="font-bold"> ' . $name . ' " </span> ?', [
            'onConfirmed' => 'deleteRow',
        ]);
        // Get ID
        $this->id_del = $id;
    }
    public function deleteRow()
    {

        $action = ActionDatabase::deleteSingleModel('ReviewUser', $this->id_del);
        if ($action)
            $this->alert('success', 'Data has been delete!');
        else
            $this->alert('warning', 'Status fails to delete!');
        // Reset ID
        $this->id_del = null;
    }



}
