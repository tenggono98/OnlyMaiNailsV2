<?php
namespace App\Http\Controllers\Pdf;
use App\Models\SettingWeb;
use App\Models\TBooking;
use App\Models\TDBooking;
use Illuminate\View\View;
use App\Models\TDSchedule;
use App\Models\DocumentRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BookingComplete extends Controller
{
    public function show(): View
    {
        // For Testing
        $data = [
            $masterBooking = TBooking::find('1'),
            $detailBooking = TDBooking::with('service.category')->where('t_booking_id','=','1')->get(),
        ];


        return view('pdf.booking_complete', compact('data', 'info_general'));
    }
    // Generate PDF
    public static function createPDF($id)
    {
        // Get Booking Information
        $masterBooking = TBooking::find($id);
        $detailBooking = TDBooking::with('service.category')->where('t_booking_id','=',$id)->get();
        $scheduleTime = TDSchedule::find($masterBooking->t_d_schedule_id);
        // dd($detailBooking);
        // Define the directory path (writable storage path)
        $directoryPath = storage_path('app/public/PDF_Booking_Confirmation');
        // Check if the directory exists, if not, create it
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true); // 0755 is the permission, true indicates recursive
        }
        // Prepare Information
        $data = [
            'clientName' => $masterBooking->client->name,
            'booking_date' => \Carbon\Carbon::parse($masterBooking->scheduleDateBook->date_schedule)->format('l , d F Y'),
            'booking_time' => \Carbon\Carbon::parse($masterBooking->scheduleTimeBook->time)->format('h:i A'),
            'list_order' =>$detailBooking->toArray(),
            'reschedule_token' => $masterBooking->uuid,
            'qty_people' => $masterBooking->qty_people_booking,
            'deposit_price' => $masterBooking->deposit_price_booking,
            'tax' => $masterBooking->total_price_after_tax_booking ?? null,
            'email' => SettingWeb::where('name','=', 'PaymentEmail')->first()->value,
            'address' => SettingWeb::where('name','=', 'Address')->first()->value,
            'deposit' => SettingWeb::where('name','=', 'Deposit')->first()->value,
            'instagram' => SettingWeb::where('name','=', 'Instagram')->first()->value,
            'gmaps' => SettingWeb::where('name','=', 'Gmaps')->first()->value,
        ];
        // Record Document
        $rec_doc = new DocumentRecord();
        $rec_doc->reference_id = $masterBooking->uuid;
        $rec_doc->doc_from = 'Booking Detail';
        $rec_doc->doc_name = 'OMN_Appointment_Confirmation_' . $masterBooking->scheduleDateBook->date_schedule . '_' . $masterBooking->uuid . '';
        $rec_doc->created_by = Auth::id();
        $rec_doc->save();
        // Generate the "PDF"
        $pdf = Pdf::loadView('pdf.booking_complete',$data)->setOption(['dpi' => 150]);
        $date_booking = \Carbon\Carbon::parse($masterBooking->scheduleDateBook->date_schedule)->format('d-m-Y');
        $uuid = $masterBooking->uuid;
        // Save PDF to storage path
        return $pdf->save($directoryPath . '/OMN_Appointment_Confirmation_' . $date_booking . '_' . $uuid . '.pdf');
      }
}
