<?php

namespace App\Livewire\DraftUI;

use Exception;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;


class BookingMail extends Component
{

    public function index(){
        return view('pdf.booking_complete')->render();
    }

    public function savePdf(){

        app('debugbar')->info('Trigger!');
        $pdf = Pdf::loadView('pdf.booking_complete');
        return $pdf->download('pdf_file.pdf');

    }
    public function render()
    {
        // dd($this->data);
        return view('livewire.draft-u-i.booking-mail');
    }



}
