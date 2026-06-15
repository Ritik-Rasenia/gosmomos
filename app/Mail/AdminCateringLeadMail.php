<?php

namespace App\Mail;

use App\Models\EventLead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminCateringLeadMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;
    public $isAdmin;

    public function __construct(EventLead $lead, bool $isAdmin = true)
    {
        $this->lead = $lead;
        $this->isAdmin = $isAdmin;
    }

    public function build()
    {
        $subject = $this->isAdmin 
            ? "New Catering Inquiry — {$this->lead->event_type}" 
            : "Catering Inquiry Received — GOS MOMO";
            
        return $this->subject($subject)
                    ->view('emails.admin_catering_lead');
    }
}
