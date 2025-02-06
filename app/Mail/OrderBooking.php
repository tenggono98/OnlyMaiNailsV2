<?php

namespace App\Mail;

use App\Models\SettingWeb;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderBooking extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    // Information about company
    public $company;


    /**
     * Create a new message instance.
     */
    public function __construct($mailData)
    {
         $this->mailData = $mailData;

         // Information about company
         $this->company = [
             'name' => 'OnlyMaiNails',
             'address' => SettingWeb::where('key', '=','Address')->first()->value,
             'email' => SettingWeb::where('key', '=','PaymentEmail')->first()->value,
             ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You have a new order!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
