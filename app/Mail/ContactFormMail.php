<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $name;
    public string $email;
    public string $content;

    public function __construct(string $name, string $email, string $content)
    {
        $this->name = $name;
        $this->email = $email;
        $this->content = $content;
    }

    public function build()
    {
        return $this->subject('New Contact Inquiry from '.$this->name)
            ->replyTo($this->email, $this->name)
            ->view('mail.contact-form');
    }
}


