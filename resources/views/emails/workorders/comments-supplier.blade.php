@component('mail::message')
# Workorder Comments

Dear {{ $supplier->name }},

Comments have been added to the workorder assigned to you:

@component('mail::panel')
{{ $workorder->comments }}
@endcomponent

Regards,<br>
Your Support Team
@endcomponent