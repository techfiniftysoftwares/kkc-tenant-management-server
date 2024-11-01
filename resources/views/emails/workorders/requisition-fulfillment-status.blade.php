@component('mail::message')
# Requisition Fulfillment Status Update

Dear {{ $user->firstname }} {{ $user->lastname }},

We have an update on the fulfillment status of your requisition. Here are the details:

@component('mail::table')
| Field | Value |
|-------|-------|
| Ticket Number | {{ $ticket->ticket_number }} |
| Workorder Number | {{ $workOrder->work_order_number }} |
| Status | {{ $workOrder->status }} |
| Fulfillment Status | {{ $availabilityStatus }} |
@endcomponent

**Details:** {{ $commentDetails }}

@if(str_contains($workOrder->status, 'On Hold'))
Please note that the workorder has been put on hold due to the current fulfillment status. We will update you once we can proceed further.
@endif

If you have any questions, please dont hesitate to contact us.

Thank you for your understanding.

Regards,<br>
{{ config('app.name') }} Support Team
@endcomponent
