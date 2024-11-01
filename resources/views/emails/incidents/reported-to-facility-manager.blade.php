@component('mail::message')
# New Incident Reported

Dear {{ $facilityManager->firstname }} {{ $facilityManager->lastname }},

A new incident ticket has been reported. Here are the details:

@component('mail::table')
| Field | Value |
|-------|-------|
| Ticket Number | {{ $ticket->ticket_number }} |
| Description | {{ $ticket->description }} |
| Incident Type | {{ $incidentType->name }} |
| Date/Time of Incident | {{ $ticket->date_time_of_incident }} |
| Priority | {{ $ticket->priority_level }} |
| Status | {{ $ticket->status }} |
@endcomponent

@if($ticket->asset_id)
**Asset Involved:** {{ $ticket->asset->name ?? 'N/A' }}
@endif

**Location:**
{{ $ticket->building->name ?? 'N/A' }}
@if($ticket->floor_id)
, {{ $ticket->floor->name ?? 'N/A' }}
@endif
@if($ticket->room_id)
, {{ $ticket->room->name ?? 'N/A' }}
@endif
@if($ticket->stairs_id)
, {{ $ticket->stairs->name ?? 'N/A' }}
@endif
@if($ticket->common_area_id)
, {{ $ticket->commonArea->name ?? 'N/A' }}
@endif
@if($ticket->corridor_id)
, {{ $ticket->corridor->name ?? 'N/A' }}
@endif

Please take the necessary actions to address this incident.

Thank you,<br>
{{ config('app.name') }}
@endcomponent
