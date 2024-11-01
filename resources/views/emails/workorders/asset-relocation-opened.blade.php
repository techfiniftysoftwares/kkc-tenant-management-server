@component('mail::message')
# Asset Relocation Workorder Opened

Dear {{ $user->firstname }} {{ $user->lastname }},

An asset relocation workorder has been opened for your ticket. Here are the details:

@component('mail::table')
| Field | Value |
|-------|-------|
| Ticket Number | {{ $ticket->ticket_number }} |
| Workorder Number | {{ $workOrder->work_order_number }} |
| Asset | {{ $workOrder->assetRelocationWorkOrder->asset->name }} (ID: {{ $workOrder->assetRelocationWorkOrder->asset->id }}) |
| Current Location | {{ $workOrder->assetRelocationWorkOrder->current_location }} |
| New Location | {{ $workOrder->assetRelocationWorkOrder->newBuilding->name }}
@if($workOrder->assetRelocationWorkOrder->new_floor_id)
, {{ $workOrder->assetRelocationWorkOrder->newFloor->name }}
@endif
@if($workOrder->assetRelocationWorkOrder->new_room_id)
, {{ $workOrder->assetRelocationWorkOrder->newRoom->name }}
@endif
@if($workOrder->assetRelocationWorkOrder->new_corridor_id)
, {{ $workOrder->assetRelocationWorkOrder->newCorridor->name }}
@endif
@if($workOrder->assetRelocationWorkOrder->new_stairs_id)
, {{ $workOrder->assetRelocationWorkOrder->newStairs->name }}
@endif
@if($workOrder->assetRelocationWorkOrder->new_common_area_id)
, {{ $workOrder->assetRelocationWorkOrder->newCommonArea->name }}
@endif
|
| Relocation Date | {{ $workOrder->assetRelocationWorkOrder->relocation_date }} |
| Status | {{ $workOrder->status }} |
| Priority | {{ $workOrder->priority_level }} |
@endcomponent

@if($workOrder->assetRelocationWorkOrder->special_instructions)
**Special Instructions:**
{{ $workOrder->assetRelocationWorkOrder->special_instructions }}
@endif

We will process your asset relocation request and keep you updated on its progress.

Thank you for your patience.

Regards,<br>
{{ config('app.name') }} Support Team
@endcomponent
