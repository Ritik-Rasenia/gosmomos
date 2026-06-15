<?php

namespace App\Mail;

use App\Models\FranchiseLead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminFranchiseLeadMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;
    public $isAdmin;

    public function __construct(FranchiseLead $lead, bool $isAdmin = true)
    {
        $this->lead = $lead;
        $this->isAdmin = $isAdmin;
    }

    public function build()
    {
        $subject = $this->isAdmin 
            ? "New Franchise Application — {$this->lead->city}" 
            : "Franchise Application Received — GOS MOMO";
            
        return $this->subject($subject)
                    ->view('emails.admin_franchise_lead');
    }
}
