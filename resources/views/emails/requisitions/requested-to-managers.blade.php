@component('mail::message')
# New Requisition Request

Dear {{ $manager->firstname }} {{ $manager->lastname }},

A new requisition request has been submitted. Here are the details:

@component('mail::table')
| Field | Value |
|-------|-------|
| Ticket Number | {{ $ticket->ticket_number }} |
| Item Name | {{ $requisitionTicket->item_name }} |
| Quantity | {{ $requisitionTicket->quantity }} |
| Required By | {{ $requisitionTicket->required_by_date }} |
| Desired Dispatch Date | {{ $requisitionTicket->desired_dispatch_date }} |
| Status | {{ $ticket->status }} |
| Priority | {{ $ticket->priority_level }} |
| Reason | {{ $requisitionTicket->reason }} |
@endcomponent

**Location:**
{{ $requisitionTicket->building->name ?? 'N/A' }}
@if($requisitionTicket->floor_id)
, {{ $requisitionTicket->floor->name ?? 'N/A' }}
@endif
@if($requisitionTicket->room_id)
, {{ $requisitionTicket->room->name ?? 'N/A' }}
@endif
@if($requisitionTicket->corridor_id)
, {{ $requisitionTicket->corridor->name ?? 'N/A' }}
@endif
@if($requisitionTicket->stairs_id)
, {{ $requisitionTicket->stairs->name ?? 'N/A' }}
@endif
@if($requisitionTicket->common_area_id)
, {{ $requisitionTicket->commonArea->name ?? 'N/A' }}
@endif

@if($requisitionTicket->specifications)
**Specifications:**
{{ $requisitionTicket->specifications }}
@endif

Please review this request and take the necessary actions.

Thank you,<br>
{{ config('app.name') }}
@endcomponent
