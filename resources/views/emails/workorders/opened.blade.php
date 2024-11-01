@component('mail::message')
# Workorder Opened for Your Ticket

Dear {{ $user->firstname }} {{ $user->lastname }},

We are pleased to inform you that a workorder has been opened for your ticket. Here are the details:

@component('mail::table')
| Field | Value |
|-------|-------|
| Ticket Number | {{ $ticket->ticket_number }} |
| Workorder Number | {{ $workorder->workorder_no }} |
| Description | {{ $ticket->description }} |
| Scheduled Start Time | {{ $workorder->scheduled_start_time }} |
| Priority | {{ $workorder->priority_level }} |
@endcomponent

We will keep you updated on the progress of your request.

Thank you for your patience.

Regards,<br>
{{ config('app.name') }} Support Team
@endcomponent
