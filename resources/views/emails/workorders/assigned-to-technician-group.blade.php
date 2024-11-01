@component('mail::message')
# New Workorder Assigned

Dear {{ $technician->firstname }} {{ $technician->lastname }},

A new workorder has been assigned to you. Here are the details:

@component('mail::table')
| Field | Value |
|-------|-------|
| Workorder Number | {{ $formattedWorkOrder['work_order_number'] }} |
| Description | {{ $formattedWorkOrder['description'] }} |
| Status | {{ $formattedWorkOrder['status'] }} |
| Priority | {{ $formattedWorkOrder['priority_level'] }} |
| Scheduled Start | {{ $formattedWorkOrder['scheduled_start_time'] }} |
| Scheduled End | {{ $formattedWorkOrder['scheduled_end_time'] }} |
| Location | {{ $formattedWorkOrder['location'] }} |
@endcomponent

@if($formattedWorkOrder['ticket'])
## Related Ticket Information
- Ticket Number: {{ $formattedWorkOrder['ticket']['ticket_number'] }}
- Description: {{ $formattedWorkOrder['ticket']['description'] }}
- Status: {{ $formattedWorkOrder['ticket']['status'] }}
@if($formattedWorkOrder['ticket']['incident_type'])
- Incident Type: {{ $formattedWorkOrder['ticket']['incident_type']['name'] }}
@endif
@if($formattedWorkOrder['ticket']['date_time_of_incident'])
- Date/Time of Incident: {{ $formattedWorkOrder['ticket']['date_time_of_incident'] }}
@endif
@endif

@if($formattedWorkOrder['asset'])
## Asset Information
- Asset Name: {{ $formattedWorkOrder['asset']['name'] }}
@endif

@if($formattedWorkOrder['incident_work_order'])
## Incident Work Order Details
- Date/Time of Incident: {{ $formattedWorkOrder['incident_work_order']['date_time_of_incident'] }}
- Description: {{ $formattedWorkOrder['incident_work_order']['description'] }}
- Priority Level: {{ $formattedWorkOrder['incident_work_order']['priority_level'] }}
- Status: {{ $formattedWorkOrder['incident_work_order']['status'] }}
@endif

@if(count($formattedWorkOrder['checklists']) > 0)
## Checklists to Complete
@foreach($formattedWorkOrder['checklists'] as $checklist)
- {{ $checklist['template']['name'] }} (Status: {{ $checklist['status'] }})
  @foreach($checklist['template']['sections'] as $section)
  - {{ $section['name'] }} ({{ $section['items_count'] }} items)
  @endforeach
@endforeach
@endif

@if(count($formattedWorkOrder['spare_parts']) > 0)
## Requested Spare Parts
@foreach($formattedWorkOrder['spare_parts'] as $sparePart)
- {{ $sparePart['spare_part']['name'] }} (Quantity: {{ $sparePart['quantity_requested'] }}, Status: {{ $sparePart['status'] }})
@endforeach
@endif

Please review the workorder details and take necessary action. If you have any questions or need additional information, please contact your supervisor.

Thank you for your prompt attention to this matter.

Regards,<br>
{{ config('app.name') }} Support Team
@endcomponent
