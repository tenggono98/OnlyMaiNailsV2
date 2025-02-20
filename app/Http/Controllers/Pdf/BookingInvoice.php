<?php
namespace App\Http\Controllers\Pdf;
use App\Models\TBooking;
use App\Models\TDBooking;
use Illuminate\View\View;
use App\Models\SettingWeb;
use App\Models\TDSchedule;
use Illuminate\Support\Str;
use App\Models\DocumentRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
class BookingInvoice extends Controller
{
    public function show(): View
    {
        // For Testing
        $masterBooking = TBooking::find('2');
        $detailBooking = TDBooking::with('service.category')->where('t_booking_id', '=', '2')->get();
        // Prepare Information
        $clientName = $masterBooking->client->name;
        $booking_date = \Carbon\Carbon::parse($masterBooking->scheduleDateBook->date_schedule)->format('l ; d F Y');
        $booking_time = \Carbon\Carbon::parse($masterBooking->scheduleTimeBook->time)->format('h:i A');
        $list_order = $detailBooking->toArray();
        $deposit_price = $masterBooking->deposit_price_booking;
        $tax = $masterBooking->total_price_after_tax_booking ?? null;
        $qty_people =  $masterBooking->qty_people_booking;
        $invoice_number = 'XXXXX';
        return view('pdf.booking_invoice', compact('clientName', 'booking_date', 'booking_time', 'list_order', 'deposit_price', 'tax', 'qty_people', 'invoice_number'));
    }
    public static function createPDF($id)
    {
        // Get Booking Information
        $masterBooking = TBooking::find($id);
        $detailBooking = TDBooking::with('service.category')->where('t_booking_id', '=', $id)->get();
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
            'list_order' => $detailBooking->toArray(),
            'deposit_price' => $masterBooking->deposit_price_booking,
            'tax' => $masterBooking->total_price_after_tax_booking ?? null,
            'qty_people' =>  $masterBooking->qty_people_booking,
            'invoice_number' =>  Str::upper(generateUUID(5)),
            'email_payment' => SettingWeb::where('name', '=', 'paymentEmail')->first()->value,
            'account_payment' => SettingWeb::where('name', '=', 'PaymentAccount')->first()->value,
            'email' => SettingWeb::where('name','=', 'PaymentEmail')->first()->value,
            'address' => SettingWeb::where('name','=', 'Address')->first()->value,
            'deposit' => SettingWeb::where('name','=', 'Deposit')->first()->value,
            'instagram' => SettingWeb::where('name','=', 'Instagram')->first()->value,
            'gmaps' => SettingWeb::where('name','=', 'Gmaps')->first()->value,
        ];
        // Record Document
        $rec_doc = new DocumentRecord();
        $rec_doc->reference_id = $masterBooking->uuid;
        $rec_doc->doc_from = 'Booking Invoice';
        $rec_doc->doc_name = 'OMN_Invoice_' . $masterBooking->scheduleDateBook->date_schedule . '_' . $masterBooking->uuid . '';
        $rec_doc->created_by = Auth::id();
        $rec_doc->save();
        // Generate the "PDF"
        $pdf = Pdf::loadView('pdf.booking_invoice', $data)->setOption(['dpi' => 150]);
        $date_booking = \Carbon\Carbon::parse($masterBooking->scheduleDateBook->date_schedule)->format('d-m-Y');
        $uuid = $masterBooking->uuid;
        // download PDF file with download method
        return $pdf->save($directoryPath . '/OMN_Invoice_' . $date_booking . '_' . $uuid . '.pdf');
    }
}
