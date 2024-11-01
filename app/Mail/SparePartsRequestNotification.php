<?php

namespace App\Mail;

use App\Models\WorkOrder;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SparePartsRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $workorder;
    public $manager;

    public function __construct(Workorder $workorder, User $manager)
    {
        $this->workorder = $workorder;
        $this->manager = $manager;
    }

    public function build()
    {
        return $this->subject('Spare Parts Request for Workorder')
            ->markdown('emails.workorders.spare-parts-request');
    }
}
