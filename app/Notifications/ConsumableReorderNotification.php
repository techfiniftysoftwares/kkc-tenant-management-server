<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ConsumableReorderNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $consumableName;
    public $reorderLevel;
    public $quantityInStock;

    public function __construct($consumableName, $reorderLevel, $quantityInStock)
    {
        $this->consumableName = $consumableName;
        $this->reorderLevel = $reorderLevel;
        $this->quantityInStock = $quantityInStock;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'consumable_name' => $this->consumableName,
            'reorder_level' => $this->reorderLevel,
            'quantity_in_stock' => $this->quantityInStock,
        ];
    }

    public function broadcastOn()
    {
        return ['consumable-reorder'];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'consumable_name' => $this->consumableName,
            'reorder_level' => $this->reorderLevel,
            'quantity_in_stock' => $this->quantityInStock,
        ];
    }
}