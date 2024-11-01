@component('mail::message')
# Spare Parts Request for Workorder

Dear {{ $manager->firstname }} {{ $manager->lastname }},

A new workorder has been created that requires spare parts. Please review the details and take necessary action:

@component('mail::table')
| Field | Value |
|-------|-------|
| Workorder Number | {{ $workorder->work_order_number }} |
| Description | {{ $workorder->description }} |
| Priority | {{ $workorder->priority_level }} |
@endcomponent

@if($workorder->spareParts->count() > 0)
## Requested Spare Parts:
@foreach($workorder->spareParts as $sparePart)
- {{ $sparePart->sparePart->part_name }} (Quantity: {{ $sparePart->quantity_requested }})
@endforeach
@endif

Please ensure the requested spare parts are available for the assigned technician.

Thank you for your prompt attention to this matter.

Regards,<br>
{{ config('app.name') }} Support Team
@endcomponent
