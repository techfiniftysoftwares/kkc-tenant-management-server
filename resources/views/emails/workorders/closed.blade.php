@component('mail::message')
# Workorder and Ticket Closed

Dear {{ $user->firstname }} {{ $user->lastname }},

We are writing to inform you that the following workorder and its associated ticket have been closed:

@component('mail::table')
| Field | Value |
|-------|-------|
| Workorder Number | {{ $workOrder->work_order_number }} |
| Ticket Number | {{ $ticket->ticket_number }} |
| Description | {{ $workOrder->description }} |
| Closed By | {{ $closedByUser->firstname }} {{ $closedByUser->lastname }} |
| Closed At | {{ $workOrder->updated_at->format('Y-m-d H:i:s') }} |
@endcomponent

@if($user->role_id == 1)
As the Facility Manager, please review the closure details and ensure all necessary steps have been completed.
@else
If you have any questions or concerns regarding the closure of this workorder and ticket, please dont hesitate to contact our support team.
@endif

Thank you for your attention to this matter.

Regards,<br>
{{ config('app.name') }} Support Team
@endcomponent
