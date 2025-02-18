<?php

namespace App\Mail;

use App\Models\SettingWeb;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class MailBooking extends Mailable
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
        //
        $this->mailData = $mailData;

        // Information about company
        $this->company = [
            'name' => 'OnlyMaiNails',
            'address' => SettingWeb::where('name', '=','Address')->first()->value,
            'email' => SettingWeb::where('name', '=','PaymentEmail')->first()->value,
            ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'OnlyMaiNails Your Appointment is Confirmed!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.mail-booking'
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
             Attachment::fromPath($this->mailData['files'][0]),
             Attachment::fromPath($this->mailData['files'][1]),

        ];
    }
}
