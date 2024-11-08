<?php

return [
    1 => [ //Electrical Material
        'electrical_type' => 'required|string|max:255',
        'voltage' => 'required|string',
        'wire_type' => 'required|string',
        'amperage' => 'required|string',
        'wire_gauge' => 'required|string',
        'conduit_type' => 'required|string',
        'conduit_size' => 'required|string',
        'circuit_breaker_rating' => 'required|string',
        'circuit_breaker_type' => 'required|string',
        'switch_type' => 'required|string',
        'receptacle_rating' => 'required|string',
        'receptacle_type' => 'required|string',
        'switch_rating' => 'required|string',
        'installation_date' => 'required|date',
    ],
    2 => [ //HVAC system
        'hvac_type' => 'required|string',
        'capacity' => 'required|string',
        'efficiency' => 'required|string',
        'refrigerant_type' => 'required|string',
        'air_filter_type' => 'required|string',
        'air_filter_merv' => 'required|string',
        'duct_material' => 'required|string',
        'duct_insulation_r_value' => 'required|string',
        'control_system_type' => 'required|string',
        'control_system_brand' => 'required|string',
        'thermostat_type' => 'required|string',
        'thermostat_brand' => 'required|string',
        'installation_date' => 'required|date',
    ],
    3 => [ //Door
        'door_type' => 'required|string',
        'door_material' => 'required|string',
        'door_size' => 'required|string',
        'door_fire_rating' => 'nullable|string',
        'door_sound_transmission_class' => 'nullable|string',
        'hinge_type' => 'required|string',
        'lock_type' => 'required|string',
        'lock_brand' => 'required|string',
        'lock_key_type' => 'required|string',
        'door_closer_type' => 'nullable|string',
        'door_closer_brand' => 'nullable|string',
        'handle_type' => 'required|string',
        'handle_material' => 'required|string',
        'threshold_material' => 'nullable|string',
        'weatherstripping_type' => 'nullable|string',
    ],
    5 => [ //Elevator
        'elevator_type' => 'required|string|max:255',
        'capacity' => 'required|string',
        'speed' => 'required|string',
        'motor_type' => 'required|string',
        'motor_power' => 'required|string',
        'cable_type' => 'required|string',
        'cable_diameter' => 'required|string',
        'brake_type' => 'required|string',
        'control_system_type' => 'required|string',
        'control_system_brand' => 'required|string',
        'door_operator_type' => 'required|string',
        'door_safety_type' => 'required|string',
        'car_enclosure_material' => 'required|string',
        'car_enclosure_finish' => 'required|string',
        'installation_date' => 'required|date',
    ],
    7 => [ //PLumbing Material
        'plumbing_type' => 'required|string',
        'material' => 'required|string',
        'finish' => 'required|string',
        'color' => 'required|string',
        'flow_rate' => 'required|string',
        'water_consumption' => 'required|string',
        'drain_size' => 'required|string',
        'trap_type' => 'required|string',
        'supply_line_size' => 'required|string',
        'supply_valve_type' => 'required|string',
        'water_pressure_requirement' => 'required|string',
        'installation_date' => 'required|date',
    ],
    8 => [ //Window Fixtures
        'window_type' => 'required|string',
        'window_size' => 'required|string',
        'glass_type' => 'required|string',
        'glass_thickness' => 'required|string',
        'glass_tint' => 'nullable|string',
        'glass_coating' => 'nullable|string',
        'frame_material' => 'required|string',
        'frame_finish' => 'required|string',
        'sealant_type' => 'nullable|string',
        'weatherstripping_type' => 'nullable|string',
        'screen_type' => 'nullable|string',
        'screen_material' => 'nullable|string',
        'opening_mechanism' => 'required|string',
        'lock_type' => 'nullable|string',
        'lock_brand' => 'nullable|string',
        'sound_transmission_class' => 'nullable|string',
        'u_value' => 'nullable|string',
        'solar_heat_gain_coefficient' => 'nullable|string',
    ],
    9 => [ //Security Equipment
        'security_type' => 'required|string',
        'camera_type' => 'nullable|string',
        'camera_resolution' => 'nullable|string',
        'camera_lens_type' => 'nullable|string',
        'camera_infrared_capability' => 'required|boolean',
        'recorder_type' => 'nullable|string',
        'recorder_storage_capacity' => 'nullable|string',
        'alarm_system_type' => 'required|string',
        'alarm_system_keypad_type' => 'required|string',
        'motion_detector_type' => 'nullable|string',
        'glass_break_detector_type' => 'nullable|string',
        'door_contact_type' => 'nullable|string',
        'access_control_system_type' => 'required|string',
        'access_control_reader_type' => 'required|string',
        'installation_date' => 'required|date',
    ],
    10 => [ //Fire System
        'fire_protection_type' => 'required|string',
        'coverage_area' => 'required|string',
        'sensor_type' => 'required|string',
        'sensor_spacing' => 'required|string',
        'alarm_type' => 'required|string',
        'alarm_decibels' => 'required|string',
        'sprinkler_type' => 'nullable|string',
        'sprinkler_temperature_rating' => 'nullable|string',
        'sprinkler_flow_rate' => 'nullable|string',
        'standpipe_material' => 'nullable|string',
        'standpipe_size' => 'nullable|string',
        'fire_pump_type' => 'nullable|string',
        'fire_pump_capacity' => 'nullable|string',
        'installation_date' => 'required|date',
    ],
    11 => [ //Tools
        'tool_category_id' => 'required|string|max:255',
        'assigned_to' => 'nullable|integer',
        'voltage' => 'nullable|string',
        'tool_size' => 'nullable|string',
        'tool_material' => 'nullable|string',
        'power_source' => 'nullable|string',
        'power_rating' => 'nullable|string',
        'battery_type' => 'nullable|string',
        'battery_capacity' => 'nullable|string',
        'tool_color' => 'required|string',
        'tool_weight' => 'required|string',
        'assigned_date' => 'required|date',
    ],
    12 => [ //Lighting Fixtures
        'lighting_type' => 'required|string',
        'material' => 'required|string',
        'dimensions' => 'required|string',
        'finish' => 'required|string',
        'color' => 'required|string',
        'lamp_type' => 'required|string',
        'lamp_wattage' => 'required|string',
        'lamp_color' => 'required|string',
        'ballast_type' => 'nullable|string',
        'voltage_requirement' => 'required|string',
        'energy_star_rated' => 'required|boolean',
    ],
    13 => [ //Furniture
        'furniture_type' => 'required|string',
        'material' => 'required|string',
        'dimensions' => 'required|string',
        'quantity' => 'required|integer',
        'finish' => 'required|string',
        'color' => 'required|string',
        'upholstery_material' => 'nullable|string',
        'upholstery_color' => 'nullable|string',
        'fire_retardant_treated' => 'required|integer',
    ],

];
