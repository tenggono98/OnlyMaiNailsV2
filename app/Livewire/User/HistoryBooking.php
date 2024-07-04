<?php
namespace App\Livewire\User;
use Livewire\Component;
use App\Models\TBooking;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class HistoryBooking extends Component
{
    use LivewireAlert;
    protected $queryString = [
        'dateSearch' => ['except' => ''],
        'codeSearch' => ['except' => ''],
        'statusSearch' => ['except' => ''],
    ];
    // Variable Search
    public $dateSearch  , $codeSearch, $statusSearch;
    public $exludeResetVariable = ['dateSearch','codeSearch','statusSearch'];
    // Variable for Booking Table
    public $bookingData;
    public function mount(){
        // Get Booking Data for User
        $bookingData = TBooking::where('user_id','=',Auth::id());
        // Filter Date
        if ($this->dateSearch) {
            $bookingData->whereHas('scheduleDateBook', function ($query) {
                $query->where('date_schedule', 'LIKE', '%' . $this->dateSearch . '%');
            });
        }
        // Filter Code
        if ($this->codeSearch) {
            $bookingData->where('code_booking','LIKE','%'.$this->codeSearch.'%');
        }
        // Filter Status
        if($this->statusSearch){
            switch ($this->statusSearch) {
                case 'completed':
                    # code...
                    $bookingData->where('status','=','completed');
                    break;
                case 'cancel':
                    # code...
                    $bookingData->where('status','=','cancel');
                    break;
                case '1':
                    # code...
                    $bookingData->where('status','=','1')->where('is_deposit_paid','=','1');
                    break;
                case 'reschedule':
                    # code...
                    $bookingData->where('status','=','reschedule');
                    break;
                case '1&0':
                    # code...
                    $bookingData->where('status','=','1')->where('confirm_payment','=','0');
                    break;
                case '1&1':
                    # code...
                    $bookingData->where('status','=','1')->where('confirm_payment','=','1');
                    break;
            }
        }
        // Get Data
        $this->bookingData = $bookingData->orderBy('id','DESC')->get();
    }
    public function render()
    {
        return view('livewire.user.history-booking');
    }

    public function clearSearch(){
        $this->dateSearch = null;
        $this->codeSearch = null;
        $this->statusSearch = null;

        return redirect(route('user.history_booking'));
    }
}
