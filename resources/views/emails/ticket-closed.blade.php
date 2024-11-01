@component('mail::message')
# Ticket Closed

Dear {{ $ticket->name }},

Your ticket with the number {{ $ticket->ticket_number }} has been closed and attended to.

@component('mail::panel')
{{ $ticket->description }}
@endcomponent

Thank you for reporting the issue. If you have any further concerns or require additional assistance, please feel free to raise a new ticket.

Regards,<br>
Your Support Team
@endcomponent