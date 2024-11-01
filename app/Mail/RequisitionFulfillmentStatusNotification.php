<?php

namespace App\Mail;

use App\Models\WorkOrder;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequisitionFulfillmentStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $workOrder;
    public $ticket;
    public $user;
    public $availabilityStatus;
    public $commentDetails;

    public function __construct(WorkOrder $workOrder, Ticket $ticket, User $user, string $availabilityStatus, string $commentDetails)
    {
        $this->workOrder = $workOrder;
        $this->ticket = $ticket;
        $this->user = $user;
        $this->availabilityStatus = $availabilityStatus;
        $this->commentDetails = $commentDetails;
    }

    public function build()
    {
        return $this->subject('Requisition Fulfillment Status Update')
            ->markdown('emails.workorders.requisition-fulfillment-status');
    }
}
