<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminContactLeadMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;
    public $isAdmin;

    public function __construct(array $lead, bool $isAdmin = true)
    {
        $this->lead = $lead;
        $this->isAdmin = $isAdmin;
    }

    public function build()
    {
        $subject = $this->isAdmin 
            ? "New Contact Form Message" 
            : "Message Received — GOS MOMO";
            
        return $this->subject($subject)
                    ->view('emails.admin_contact_lead');
    }
}
