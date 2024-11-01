<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IncidentReportedToFacilityManager extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $facilityManager;
    public $incidentType;

    public function __construct(Ticket $ticket, User $facilityManager)
    {
        $this->ticket = $ticket;
        $this->facilityManager = $facilityManager;
        $this->incidentType = $ticket->incidentTicket->incidentType;
    }

    public function build()
    {
        return $this->subject('New Incident Reported: ' . $this->incidentType->name)
            ->markdown('emails.incidents.reported-to-facility-manager');
    }
}
