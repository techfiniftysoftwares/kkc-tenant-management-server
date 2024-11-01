@component('mail::message')
# New Workorder Assigned

Dear {{ $technician->firstname }} {{ $technician->lastname }},

A new workorder has been assigned to you. Here are the details:

@component('mail::table')
| Field                | Value                                 |
|----------------------|---------------------------------------|
| Workorder Number     | {{ $workorder->workorder_no }}        |
| Ticket Number        | {{ $ticket->ticket_number }}          |
| Description          | {{ $ticket->description }}            |
| Incident Type        | {{ $ticket->incidentType->name }}     |
| Location             | {{ $ticket->location->name }}         |
| Priority             | {{ $ticket->priority_level }}         |
| Turnaround Time      | {{ $ticket->turnaround_time }}        |
@endcomponent

Please take the necessary actions to address this workorder.

Regards,<br>
<a href="mailto:no-reply@kusoya.com">no-reply@kusoya.com</a>
@endcomponent
