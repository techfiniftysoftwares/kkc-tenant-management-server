<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceChecklistType;
use App\Models\MaintenanceChecklistItem;

class MaintenanceChecklistItemSeeder extends Seeder
{
    public function run()
    {
        $items = [
            'HVAC' => [
                ['label' => 'Air Filter Status', 'name' => 'air_filter_status', 'field_type' => 'select', 'options' => ['Clean', 'Needs Replacement', 'Replaced'], 'required' => true],
                ['label' => 'Coil Condition', 'name' => 'coil_condition', 'field_type' => 'radio', 'options' => ['Good', 'Fair', 'Poor'], 'required' => true],
                ['label' => 'Refrigerant Level', 'name' => 'refrigerant_level', 'field_type' => 'number', 'placeholder' => 'Enter level in psi', 'required' => true],
                ['label' => 'Ductwork Inspection Notes', 'name' => 'ductwork_notes', 'field_type' => 'textarea', 'placeholder' => 'Enter any issues found', 'required' => false],
                ['label' => 'Thermostat Functional', 'name' => 'thermostat_functional', 'field_type' => 'checkbox', 'required' => true],
            ],
            'Plumbing' => [
                ['label' => 'Leak Detection', 'name' => 'leak_detection', 'field_type' => 'radio', 'options' => ['No Leaks', 'Minor Leaks', 'Major Leaks'], 'required' => true],
                ['label' => 'Water Pressure (PSI)', 'name' => 'water_pressure', 'field_type' => 'number', 'placeholder' => 'Enter pressure in PSI', 'required' => true],
                ['label' => 'Drain Line Status', 'name' => 'drain_line_status', 'field_type' => 'select', 'options' => ['Clear', 'Partially Blocked', 'Blocked'], 'required' => true],
                ['label' => 'Water Heater Condition', 'name' => 'water_heater_condition', 'field_type' => 'textarea', 'placeholder' => 'Describe the condition', 'required' => false],
                ['label' => 'Toilet Mechanism Check', 'name' => 'toilet_mechanism_check', 'field_type' => 'checkbox', 'required' => true],
            ],
            'Electrical' => [
                ['label' => 'Circuit Breaker Condition', 'name' => 'circuit_breaker_condition', 'field_type' => 'select', 'options' => ['Good', 'Needs Attention', 'Requires Replacement'], 'required' => true],
                ['label' => 'Wiring Insulation Check', 'name' => 'wiring_insulation', 'field_type' => 'radio', 'options' => ['Good', 'Fair', 'Poor'], 'required' => true],
                ['label' => 'Voltage Reading', 'name' => 'voltage_reading', 'field_type' => 'number', 'placeholder' => 'Enter voltage', 'required' => true],
                ['label' => 'GFCI Outlets Functional', 'name' => 'gfci_functional', 'field_type' => 'checkbox', 'required' => true],
                ['label' => 'Electrical Panel Inspection', 'name' => 'panel_inspection', 'field_type' => 'textarea', 'placeholder' => 'Describe the condition of the electrical panel', 'required' => true],
            ],
            'Fire Protection' => [
                ['label' => 'Fire Alarm System Test', 'name' => 'fire_alarm_test', 'field_type' => 'radio', 'options' => ['Passed', 'Failed'], 'required' => true],
                ['label' => 'Sprinkler System Pressure', 'name' => 'sprinkler_pressure', 'field_type' => 'number', 'placeholder' => 'Enter pressure in PSI', 'required' => true],
                ['label' => 'Fire Extinguisher Check', 'name' => 'fire_extinguisher_check', 'field_type' => 'checkbox', 'required' => true],
                ['label' => 'Emergency Lighting Test', 'name' => 'emergency_lighting_test', 'field_type' => 'select', 'options' => ['Functional', 'Needs Battery Replacement', 'Not Working'], 'required' => true],
                ['label' => 'Fire Door Inspection', 'name' => 'fire_door_inspection', 'field_type' => 'textarea', 'placeholder' => 'Note any issues with fire doors', 'required' => false],
            ],
            'Building Exterior' => [
                ['label' => 'Roof Condition', 'name' => 'roof_condition', 'field_type' => 'select', 'options' => ['Good', 'Needs Minor Repair', 'Needs Major Repair'], 'required' => true],
                ['label' => 'Wall Integrity Check', 'name' => 'wall_integrity', 'field_type' => 'radio', 'options' => ['No Issues', 'Minor Cracks', 'Major Damage'], 'required' => true],
                ['label' => 'Window Seal Inspection', 'name' => 'window_seal', 'field_type' => 'checkbox', 'required' => true],
                ['label' => 'Exterior Painting Condition', 'name' => 'exterior_paint', 'field_type' => 'select', 'options' => ['Good', 'Needs Touch-up', 'Needs Repainting'], 'required' => true],
                ['label' => 'Landscaping Notes', 'name' => 'landscaping_notes', 'field_type' => 'textarea', 'placeholder' => 'Note any landscaping issues or needs', 'required' => false],
            ],
            'Interior Finishes' => [
                ['label' => 'Floor Condition', 'name' => 'floor_condition', 'field_type' => 'select', 'options' => ['Good', 'Needs Cleaning', 'Needs Repair'], 'required' => true],
                ['label' => 'Wall Condition', 'name' => 'wall_condition', 'field_type' => 'radio', 'options' => ['Good', 'Needs Paint', 'Needs Repair'], 'required' => true],
                ['label' => 'Ceiling Inspection', 'name' => 'ceiling_inspection', 'field_type' => 'checkbox', 'required' => true],
                ['label' => 'Door Functionality', 'name' => 'door_functionality', 'field_type' => 'select', 'options' => ['Functional', 'Needs Adjustment', 'Needs Replacement'], 'required' => true],
                ['label' => 'Interior Painting Notes', 'name' => 'interior_paint_notes', 'field_type' => 'textarea', 'placeholder' => 'Note any interior painting needs', 'required' => false],
            ],
            'Elevator' => [
                ['label' => 'Elevator Operation Test', 'name' => 'elevator_operation', 'field_type' => 'radio', 'options' => ['Smooth', 'Needs Adjustment', 'Not Operational'], 'required' => true],
                ['label' => 'Door Function Check', 'name' => 'door_function', 'field_type' => 'checkbox', 'required' => true],
                ['label' => 'Emergency Phone Test', 'name' => 'emergency_phone', 'field_type' => 'select', 'options' => ['Functional', 'Not Functional'], 'required' => true],
                ['label' => 'Elevator Cab Condition', 'name' => 'cab_condition', 'field_type' => 'select', 'options' => ['Good', 'Needs Cleaning', 'Needs Repair'], 'required' => true],
                ['label' => 'Maintenance Notes', 'name' => 'elevator_maintenance_notes', 'field_type' => 'textarea', 'placeholder' => 'Enter any additional maintenance notes', 'required' => false],
            ],
            'General' => [
                ['label' => 'Overall Cleanliness', 'name' => 'overall_cleanliness', 'field_type' => 'radio', 'options' => ['Clean', 'Needs Attention', 'Unsatisfactory'], 'required' => true],
                ['label' => 'Safety Hazards Identified', 'name' => 'safety_hazards', 'field_type' => 'checkbox', 'required' => true],
                ['label' => 'Pest Control Check', 'name' => 'pest_control', 'field_type' => 'select', 'options' => ['No Issues', 'Minor Issues', 'Needs Immediate Attention'], 'required' => true],
                ['label' => 'Energy Efficiency Rating', 'name' => 'energy_efficiency', 'field_type' => 'number', 'placeholder' => 'Enter rating from 1-10', 'required' => true],
                ['label' => 'General Comments', 'name' => 'general_comments', 'field_type' => 'textarea', 'placeholder' => 'Enter any general comments or observations', 'required' => false],
            ],
        ];

        foreach ($items as $typeName => $typeItems) {
            $type = MaintenanceChecklistType::where('name', $typeName)->first();
            if ($type) {
                foreach ($typeItems as $index => $item) {
                    MaintenanceChecklistItem::create(array_merge($item, [
                        'maintenance_checklist_type_id' => $type->id,
                        'order' => $index + 1
                    ]));
                }
            }
        }
    }
}
