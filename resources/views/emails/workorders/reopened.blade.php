@component('mail::message')
# Workorder Reopened and Ticket Updated

Dear {{ $user->firstname }} {{ $user->lastname }},

We are pleased to inform you that the workorder associated with your ticket has been reopened, and your ticket status has been updated. Here are the details:

@component('mail::table')
| Field | Value |
|-------|-------|
| Ticket Number | {{ $ticket->ticket_number }} |
| Workorder Number | {{ $workOrder->work_order_number }} |
| Description | {{ $workOrder->description }} |
| Status | {{ $ticket->status }} |
@endcomponent

Our team has resumed work on resolving the issue. We will keep you updated on any progress made on the workorder.

If you have any questions or need further information, please dont hesitate to contact our support team.

Thank you for your patience and understanding.

Regards,<br>
{{ config('app.name') }} Support Team
@endcomponent
