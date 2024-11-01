@component('mail::message')
# Workorder Turnaround Time Notification

Dear {{ $technician->firstname }} {{ $technician->lastname }},

The workorder with number {{ $workorder->workorder_no }} has reached {{ $message }}.

Please take necessary actions to ensure the workorder is completed within the remaining time.

@component('mail::table')
| Field | Value |
| ----- | ----- |
| Workorder Number | {{ $workorder->workorder_no }} |
| Ticket Number | {{ $workorder->ticket->ticket_number }} |
| Description | {{ $workorder->ticket->description }} |
| Created At | {{ $workorder->created_at }} |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
