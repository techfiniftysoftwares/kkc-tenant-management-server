<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssetRelocationRequestedToFacilityManager extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $facilityManager;
    public $assetRelocationTicket;

    public function __construct(Ticket $ticket, User $facilityManager)
    {
        $this->ticket = $ticket;
        $this->facilityManager = $facilityManager;
        $this->assetRelocationTicket = $ticket->assetRelocationTicket;
    }

    public function build()
    {
        return $this->subject('New Asset Relocation Request')
            ->markdown('emails.assets.relocation-requested-to-facility-manager');
    }
}
