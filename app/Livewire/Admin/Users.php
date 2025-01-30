<?php
namespace App\Livewire\Admin;
use App\Models\User;
use Livewire\Component;
use App\Models\UserWarningNotes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ActionDatabase;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Users extends Component
{
    use LivewireAlert;
    // Variable for what type user is selected
    public $userType, $users = [];
    // Variable General
    public $is_edit = false, $id_edit , $id_del;
    // Variable for Note Warning
    public $nameUserWarningNotes, $userNotesWarning,  $id_edit_note, $descriptionWarningNote;
    // Varable for Input
    public $fullnameUser, $phoneUser, $emailUser, $passwordUser, $igUser;
    protected $queryString = [
        'type' => ['except' => '']
    ];
    public $exludeResetVariable = ['type', 'userType'];
    protected $listeners = [
        'deleteRow'
    ];
    public function mount($type = null)
    {
        $this->userType = $type;
    }
    public function render()
    {
        if ($this->userType !== null)
            $this->users = User::where('role', '=', $this->userType)->get();
        return view('livewire.admin.users')->layout('components.layouts.app-admin');
    }
    public function save()
    {
        /* ------------------------------ If edit user ------------------------------ */
        if ($this->is_edit == true) {
            $user =  User::find($this->id_edit);
            if ($this->passwordUser !== null || $this->passwordUser !== '')
                $user->password = Hash::make($this->passwordUser);
        }
        /* ----------------------------------- End ---------------------------------- */
        /* ----------------------------- if created user ---------------------------- */
        else {
            $user = new User();
            $user->password = Hash::make($this->passwordUser);
        }
        /* ----------------------------------- End ---------------------------------- */
         /* ---------------------- Create new user (admin/user) ---------------------- */
        $user->name = $this->fullnameUser;
        $user->email = $this->emailUser;
        $user->phone = $this->phoneUser;
        $user->status = '1';
        // if Category "Admin"
        if ($this->userType == 'admin') {
            $user->role = 'admin';
        }
        // If Category "user"
        elseif ($this->userType == 'user') {
            $user->role = 'user';
            $user->ig_tag = $this->igUser;
        }
        $user->save();
        /* ----------------------------------- End ---------------------------------- */
        if ($user) {
            if ($this->is_edit == true)
                $this->alert('success', 'User has been updated !');
            else
                $this->alert('success', 'New user has been created !');
            $this->resetForm();
            $this->dispatch('closeModal', ['id' => 'add-modal']);
        } else {
            $this->alert('danger', 'New user fail to created!');
        }
    }
    public function edit($idUser)
    {
        // Reset Input & Assign Variable
        $this->resetForm();
        $this->is_edit = true;
        $this->id_edit = $idUser;
        /* -------------------------- Get User Information - Begin -------------------------- */
        $userEdit = User::find($this->id_edit);
        $this->fullnameUser = $userEdit->name;
        $this->emailUser = $userEdit->email;
        $this->phoneUser = $userEdit->phone ?? '';
        if ($this->userType == 'user') {
            $this->igUser = $userEdit->ig_tag ?? '';
        }
        /* ----------------------- Get User Information - End ----------------------- */
    }
    public function confirmDelete($name, $id)
    {
        // Confirm Modal
        $this->confirm('Are you sure do want to delete Users  <br> "<span class="font-bold"> ' . $name . ' " </span> ?', [
            'onConfirmed' => 'deleteRow',
        ]);
        // Get ID
        $this->id_del = $id;
    }
    public function deleteRow()
    {
        $action = ActionDatabase::deleteSingleModel('User', $this->id_del);
        if ($action)
            $this->alert('success', 'Data has been delete!');
        else
            $this->alert('warning', 'Status fails to delete!');
        // Reset ID
        $this->id_del = null;
    }
    public function viewWarningNotes($userId)
    {
        // Get User Info
        $user = User::find($userId);
        $this->nameUserWarningNotes = $user->name;
        $this->id_edit_note = $userId;
        // Get All Notes related to user
        $this->userNotesWarning = UserWarningNotes::where('note_for', '=', $userId)->orderBy('id', 'desc')->get();
    }
    public function saveNote()
    {
        $note = new UserWarningNotes();
        $note->note_for = $this->id_edit_note;
        $note->description_warning_note = $this->descriptionWarningNote;
        $note->created_by = Auth::id();
        $note->save();
        if ($note) {
            $this->alert('success', 'Note has been successfuly save');
            $this->descriptionWarningNote = null;
            $this->userNotesWarning = UserWarningNotes::where('note_for', '=', $this->id_edit_note)->orderBy('id', 'desc')->get();
        } else {
            $this->alert('danger', 'Note has been fail to save');
        }
    }
    public function resetForm()
    {
        $this->resetExcept($this->exludeResetVariable);
    }
    public function toggleStatus($id)
    {
        $action = ActionDatabase::toggleStatusSingleModel('User', $id);
        if ($action)
            $this->alert('success', 'Status has been change!');
        else
            $this->alert('warning', 'Status fails to change!');
    }
}
