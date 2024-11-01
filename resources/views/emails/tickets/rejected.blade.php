@component('mail::message')
# Ticket Rejected

Dear {{ $user->firstname }} {{ $user->lastname }},

Your ticket with the number {{ $ticket->ticket_number }} has been rejected.

@component('mail::panel')
**Ticket Details:**
{{ $ticket->description }}

**Reason for Rejection:**
{{ $reason }}
@endcomponent

If you have any questions about this decision or need further clarification, please feel free to raise a new ticket or contact your facility manager.

Thank you for your understanding.

Regards,<br>
{{ config('app.name') }} Support Team
@endcomponent
