<?php

namespace App\Console\Commands;

use App\Mail\ReorderLevelNotification;
use Illuminate\Console\Command;
use App\Models\SparePart;
use App\Models\Consumable;
use Illuminate\Support\Facades\Mail;

class CheckReorderLevel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-reorder-level';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check reorder levels for consumables and spare parts';

    public function handle()
    {
        $consumables = Consumable::where('quantity_in_stock', '<', 'reorder_level')->get();
        foreach ($consumables as $consumable) {
            $this->sendNotification('consumable', $consumable->id, $consumable->name, $consumable->reorder_level);
        }

        $spareParts = SparePart::where('quantity_in_stock', '<', 'reorder_level')->get();
        foreach ($spareParts as $sparePart) {
            $this->sendNotification('spare_part', $sparePart->id, $sparePart->name, $sparePart->reorder_level);
        }

        $this->info('Reorder level check completed.');
    }

    private function sendNotification($itemType, $itemId, $itemName, $reorderLevel)
    {
        $subject = "Reorder Level Notification: {$itemType} - {$itemName}";
        $message = "The {$itemType} '{$itemName}' (ID: {$itemId}) has reached its reorder level of {$reorderLevel}. Please take necessary actions to restock the item.";

        Mail::to('inventory@example.com')->send(new ReorderLevelNotification($subject, $message));

        $this->info("Reorder level notification sent for {$itemType} '{$itemName}' (ID: {$itemId}).");
    }
}
