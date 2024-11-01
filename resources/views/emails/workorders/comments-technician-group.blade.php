@component('mail::message')
# Workorder Comments

Dear {{ $technician->firstname }} {{ $technician->lastname }},

Comments have been added to the workorder assigned to your technician group:

@component('mail::panel')
{{ $workorder->comments }}
@endcomponent

Regards,<br>
Your Support Team
@endcomponent