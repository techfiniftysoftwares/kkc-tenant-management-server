@component('mail::message')
# Requisition Workorder Opened

Dear {{ $user->firstname }} {{ $user->lastname }},

A requisition workorder has been opened for your ticket. Here are the details:

@component('mail::table')
| Field | Value |
|-------|-------|
| Ticket Number | {{ $ticket->ticket_number }} |
| Workorder Number | {{ $workOrder->work_order_number }} |
| Description | {{ $workOrder->description }} |
| Status | {{ $workOrder->status }} |
| Priority | {{ $workOrder->priority_level }} |
@endcomponent

We will process your requisition and keep you updated on its status.

Thank you for your patience.

Regards,<br>
{{ config('app.name') }} Support Team
@endcomponent
