<?php

namespace App\Mail;

use App\Models\WorkOrder;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WorkorderAssignedToTechnicianNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $workOrder;
    public $technician;
    public $formattedWorkOrder;

    public function __construct(WorkOrder $workOrder, User $technician)
    {
        $this->workOrder = $workOrder;
        $this->technician = $technician;
        $this->formattedWorkOrder = $this->formatWorkOrderDetails($workOrder);
    }

    public function build()
    {
        return $this->subject('New Workorder Assigned to You: ' . $this->workOrder->work_order_number)
            ->markdown('emails.workorders.assigned-to-technician');
    }

    private function formatWorkOrderDetails($workOrder)
    {
        // This method will format the work order details similar to your formatIncidentWorkOrderDetails method
        // Adjust as needed based on the actual structure of your WorkOrder and related models
        return [
            'id' => $workOrder->id,
            'work_order_number' => $workOrder->work_order_number,
            'description' => $workOrder->description,
            'status' => $workOrder->status,
            'priority_level' => $workOrder->priority_level,
            'scheduled_start_time' => $workOrder->scheduled_start_time,
            'scheduled_end_time' => $workOrder->scheduled_end_time,
            'ticket' => $workOrder->ticket ? [
                'id' => $workOrder->ticket->id,
                'ticket_number' => $workOrder->ticket->ticket_number,
                'description' => $workOrder->ticket->description,
                'status' => $workOrder->ticket->status,
                'incident_type' => $workOrder->ticket->incidentTicket && $workOrder->ticket->incidentTicket->incidentType ? [
                    'id' => $workOrder->ticket->incidentTicket->incidentType->id,
                    'name' => $workOrder->ticket->incidentTicket->incidentType->name,
                ] : null,
                'date_time_of_incident' => $workOrder->ticket->incidentTicket ? $workOrder->ticket->incidentTicket->date_time_of_incident : null,
            ] : null,
            'location' => $this->formatLocation($workOrder),
            'asset' => $workOrder->asset ? [
                'id' => $workOrder->asset->id,
                'name' => $workOrder->asset->name,
            ] : null,
            'incident_work_order' => $workOrder->incidentWorkOrder ? [
                'id' => $workOrder->incidentWorkOrder->id,
                'incident_type_id' => $workOrder->incidentWorkOrder->incident_type_id,
                'date_time_of_incident' => $workOrder->incidentWorkOrder->date_time_of_incident,
                'description' => $workOrder->incidentWorkOrder->description,
                'priority_level' => $workOrder->incidentWorkOrder->priority_level,
                'status' => $workOrder->incidentWorkOrder->status,
            ] : null,
            'checklists' => $this->formatChecklists($workOrder),
            'spare_parts' => $this->formatSpareParts($workOrder),
        ];
    }

    private function formatLocation($workOrder)
    {
        $location = [];
        if ($workOrder->building) $location[] = $workOrder->building->name;
        if ($workOrder->floor) $location[] = $workOrder->floor->name;
        if ($workOrder->room) $location[] = $workOrder->room->name;
        if ($workOrder->corridor) $location[] = $workOrder->corridor->name;
        if ($workOrder->commonArea) $location[] = $workOrder->commonArea->name;
        if ($workOrder->stairs) $location[] = $workOrder->stairs->name;
        return implode(', ', $location);
    }

    private function formatChecklists($workOrder)
    {
        return $workOrder->checklists->map(function ($checklist) {
            return [
                'id' => $checklist->id,
                'status' => $checklist->status,
                'template' => $checklist->template ? [
                    'id' => $checklist->template->id,
                    'name' => $checklist->template->name,
                    'sections' => $checklist->template->sections->map(function ($section) {
                        return [
                            'id' => $section->id,
                            'name' => $section->name,
                            'items_count' => $section->items->count(),
                        ];
                    }),
                ] : null,
            ];
        });
    }

    private function formatSpareParts($workOrder)
    {
        return $workOrder->spareParts->map(function ($sparePart) {
            return [
                'id' => $sparePart->id,
                'spare_part' => $sparePart->sparePart ? [
                    'id' => $sparePart->sparePart->id,
                    'name' => $sparePart->sparePart->part_name,
                ] : null,
                'quantity_requested' => $sparePart->quantity_requested,
                'status' => $sparePart->status,
            ];
        });
    }
}
