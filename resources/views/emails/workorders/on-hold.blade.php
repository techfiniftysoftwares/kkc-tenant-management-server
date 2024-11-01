@component('mail::message')
# Workorder On Hold and Ticket Closed

Dear {{ $user->firstname }} {{ $user->lastname }},

We are writing to inform you that the workorder associated with your ticket has been put on hold, and as a result, your ticket has been closed. Here are the details:

@component('mail::table')
| Field | Value |
|-------|-------|
| Ticket Number | {{ $ticket->ticket_number }} |
| Workorder Number | {{ $workOrder->work_order_number }} |
| Description | {{ $workOrder->description }} |
| Status | On Hold |
@endcomponent

@if($comment)
**Reason for putting the workorder on hold:**
{{ $comment }}
@endif

We apologize for any inconvenience this may cause. Our team will continue to work on resolving the issue, and we will update you when there's progress on the workorder.

If you have any questions or need further clarification, please don't hesitate to contact our support team.

Thank you for your understanding and patience.

Regards,<br>
{{ config('app.name') }} Support Team
@endcomponent
