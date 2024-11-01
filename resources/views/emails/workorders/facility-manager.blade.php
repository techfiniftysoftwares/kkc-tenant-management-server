@component('mail::message')
# New Workorder Created

Dear FCM {{ $facilityManager->firstname }} {{ $facilityManager->lastname }},

A new workorder has been created for the following ticket:

@component('mail::table')
| Field                | Value                                 |
|----------------------|---------------------------------------|
| Workorder Number     | {{ $workorder->workorder_no }}        |
| Ticket Number        | {{ $ticket->ticket_number }}          |
| Description          | {{ $ticket->description }}            |
| Incident Type        | {{ $ticket->incidentType->name }}     |
| Location             | {{ $ticket->location->name }}         |
| Building             | {{ $ticket->building->name }}         |
| Floor                | {{ $ticket->floor->floor_number }}    |
| Room                 | {{ $ticket->room->room_number }}      |
| Priority             | {{ $ticket->priority_level }}         |
| Turnaround Time      | {{ $ticket->turnaround_time }}        |
@endcomponent

Please review the workorder and take necessary actions.

Regards,<br>
Your Support Team
@endcomponent
