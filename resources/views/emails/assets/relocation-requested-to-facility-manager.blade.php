@component('mail::message')
# New Asset Relocation Request

Dear {{ $facilityManager->firstname }} {{ $facilityManager->lastname }},

A new asset relocation request has been submitted. Here are the details:

@component('mail::table')
| Field | Value |
|-------|-------|
| Ticket Number | {{ $ticket->ticket_number }} |
| Asset | {{ $assetRelocationTicket->asset->name }} (ID: {{ $assetRelocationTicket->asset->id }}) |
| Current Location | {{ $assetRelocationTicket->current_location }} |
| New Location | {{ $assetRelocationTicket->newBuilding->name }}
@if($assetRelocationTicket->newFloor)
, {{ $assetRelocationTicket->newFloor->name }}
@endif
@if($assetRelocationTicket->newRoom)
, {{ $assetRelocationTicket->newRoom->name }}
@endif
@if($assetRelocationTicket->newCorridor)
, {{ $assetRelocationTicket->newCorridor->name }}
@endif
@if($assetRelocationTicket->newStairs)
, {{ $assetRelocationTicket->newStairs->name }}
@endif
@if($assetRelocationTicket->newCommonArea)
, {{ $assetRelocationTicket->newCommonArea->name }}
@endif
|
| Relocation Date | {{ $assetRelocationTicket->relocation_date }} |
| Status | {{ $ticket->status }} |
| Priority | {{ $ticket->priority_level }} |
@endcomponent

@if($assetRelocationTicket->special_instructions)
**Special Instructions:**
{{ $assetRelocationTicket->special_instructions }}
@endif

Please review this request and take the necessary actions.

Thank you,<br>
{{ config('app.name') }}
@endcomponent
