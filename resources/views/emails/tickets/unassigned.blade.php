@component('mail::message')
# Unassigned Ticket Notification

Dear FCM {{ $facilityManager->firstname }} {{ $facilityManager->lastname }},

This is to notify you that an unassigned ticket requires your attention:

@component('mail::table')
| Field                | Value                                 |
|----------------------|---------------------------------------|
| Ticket Number        | {{ $ticket->ticket_number }}         |
| Description          | {{ $ticket->description }}           |
| Incident Type        | {{ $ticket->incidentType->name }}    |
| Location             | {{ $ticket->location->name }}        |
| Building             | {{ $ticket->building->name }}        |
| Floor                | {{ $ticket->floor->floor_number }}   |
| Room                 | {{ $ticket->room->room_number }}     |
| Priority             | {{ $ticket->priority_level }}        |
| Turnaround Time      | {{ $ticket->turnaround_time }}       |
@endcomponent

{{ $message }}

The ticket has reached {{ $message }} of its turnaround time.

Please take the necessary actions to assign and resolve this ticket.

Regards,<br>
Your Support Team
@endcomponent
