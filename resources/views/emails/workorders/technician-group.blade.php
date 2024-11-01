@component('mail::message')
# New Workorder Assigned

Dear {{ $technician->firstname }} {{ $technician->lastname }},

A new workorder has been assigned to your technician group. Here are the details:

@component('mail::table')
| Field                | Value                                 |
|----------------------|---------------------------------------|
| Workorder Number     | {{ $workorder->workorder_no }}        |
| Description          | {{ $ticket->description }}            |
| Incident Type        | {{ $ticket->incidentType->name }}     |
| Location             | {{ $ticket->location->name }}         |
| Building             | {{ $ticket->building->name }}         |
| Floor                | {{ $ticket->floor->floor_number }}    |
| Room                 | {{ $ticket->room->room_number }}      |
| Priority             | {{ $ticket->priority_level }}         |
| Turnaround Time      | {{ $ticket->turnaround_time }}        |
@endcomponent

Please take the necessary actions to address this workorder.

Regards,<br>
Your Support Team
@endcomponent
