<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $subject;
    public $message;

    public $successMessage = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'subject' => 'required|min:5',
        'message' => 'required|min:10',
    ];

    public function submit()
    {
        $this->validate();

        // Send email
        Mail::raw("Message from: {$this->name} ({$this->email})\n\nSubject: {$this->subject}\n\n{$this->message}", function ($message) {
            $message->to('contact@ircp-madagascar.org')
                    ->subject("Contact Form: {$this->subject}");
        });

        // Reset form fields
        $this->reset(['name', 'email', 'subject', 'message']);

        // Show success message
        $this->successMessage = 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.';
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
