<?php

namespace App\Http\Controllers\Pdf;

use App\Models\TBooking;
use Illuminate\View\View;
use App\Models\TDSchedule;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\TDBooking;
use Illuminate\Support\Facades\File;

class BookingComplete extends Controller
{
    //


    public function show(): View
    {
        return view('pdf.booking_complete',compact('data'));
    }



    // Generate PDF
    public static function createPDF($id)
    {
        // Get Booking Information
        $masterBooking = TBooking::find($id);
        $detailBooking = TDBooking::with('service.category')->where('t_booking_id','=',$id)->get();
        $scheduleTime = TDSchedule::find($masterBooking->t_d_schedule_id);

        // dd($detailBooking);


        // Define the directory path
        $directoryPath = 'PDF_Booking_Confirmation';

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
            'tax' => $masterBooking->total_price_after_tax_booking ?? null
        ];


        $pdf = Pdf::loadView('pdf.booking_complete',$data)->setOption(['dpi' => 150]);
        $date_booking = \Carbon\Carbon::parse($masterBooking->scheduleDateBook->date_schedule)->format('d-m-Y');
        $uuid = $masterBooking->uuid;
        // download PDF file with download method
        return $pdf->save($directoryPath .'/OMN_Appointment_Confirmation_'.$date_booking.'_'.$uuid.'.pdf');
      }
}
