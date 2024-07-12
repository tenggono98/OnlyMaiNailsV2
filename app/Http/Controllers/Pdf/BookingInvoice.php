<?php

namespace App\Http\Controllers\Pdf;

use App\Models\TBooking;
use App\Models\TDBooking;
use Illuminate\View\View;
use App\Models\TDSchedule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingInvoice extends Controller
{

    public function show(): View
    {

            $masterBooking = TBooking::find('2');
            $detailBooking = TDBooking::with('service.category')->where('t_booking_id','=','2')->get();


         // Prepare Information
            $clientName = $masterBooking->client->name;
            $booking_date = \Carbon\Carbon::parse($masterBooking->scheduleDateBook->date_schedule)->format('l ; d F Y');
            $booking_time = \Carbon\Carbon::parse($masterBooking->scheduleTimeBook->time)->format('h:i A');
            $list_order =$detailBooking->toArray();
            $deposit_price = $masterBooking->deposit_price_booking;
            $tax = $masterBooking->total_price_after_tax_booking ?? null;
            $qty_people =  $masterBooking->qty_people_booking;
            $invoice_number = 'XXXXX';




        return view('pdf.booking_invoice',compact('clientName','booking_date','booking_time','list_order','deposit_price','tax','qty_people','invoice_number'));
    }

    public static function createPDF($id)
    {
        // Get Booking Information
        $masterBooking = TBooking::find($id);
        $detailBooking = TDBooking::with('service.category')->where('t_booking_id','=',$id)->get();

        // Define the directory path
        $directoryPath = 'PDF_Booking_Invoice';

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
            'deposit_price' => $masterBooking->deposit_price_booking,
            'tax' => $masterBooking->total_price_after_tax_booking ?? null
        ];


        $pdf = Pdf::loadView('pdf.booking_invoice',$data)->setOption(['dpi' => 150]);
        $date_booking = \Carbon\Carbon::parse($masterBooking->scheduleDateBook->date_schedule)->format('d-m-Y');
        $uuid = $masterBooking->uuid;
        // download PDF file with download method
        return $pdf->save($directoryPath .'/OMN_Invoice_'.$date_booking.'_'.$uuid.'.pdf');
      }
}
