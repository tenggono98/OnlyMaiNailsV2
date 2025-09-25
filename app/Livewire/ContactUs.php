<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use function getSettingWeb;

class ContactUs extends Component
{
    public string $name = '';
    public string $email = '';
    public string $message = '';

    protected $rules = [
        'name' => 'required|string|min:2|max:100',
        'email' => 'required|email',
        'message' => 'required|string|min:10|max:2000',
    ];

    public function submit(): void
    {
        $this->validate();

        $to = getSettingWeb('ContactInboxEmail') ?? config('mail.from.address');

        Mail::to($to)->send(new ContactFormMail(
            name: $this->name,
            email: $this->email,
            content: $this->message,
        ));

        $this->reset(['name','email','message']);
        $this->dispatch('contactSent');
    }

    public function render()
    {
        return view('livewire.contact-us');
    }
}
