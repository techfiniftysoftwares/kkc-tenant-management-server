<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Submodule;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{

    public function run()
    {
        $modules = [
            [
                'id' => 1,
                'icon' => 'RiCustomerService2Line',
                'name' => 'Help Desk',
                'submodules' => [
                    ['title' => 'Dashboard', 'path' => 'helpdesk/helpdesk-dashboard'],
                    ['title' => 'Report Incident', 'path' => 'helpdesk/report-incident'],
                    ['title' => 'Manage Incident Tickets', 'path' => 'helpdesk/incident-tickets'],
                    ['title' => 'Manage Work Orders', 'path' => 'helpdesk/workorders'],
                ],
            ],
            [
                'id' => 2,
                'icon' => 'MdOutlineElectricBolt',
                'name' => 'Energy & Sustainability',
                'submodules' => [
                    ['title' => 'Dashboard', 'path' => 'energy-management/energy-dashboard'],
                    ['title' => 'Energy Consumption', 'path' => 'energy-management/energy-consumption'],
                    ['title' => 'Utiliy Bill', 'path' => 'energy-management/utility-bill'],
                    ['title' => 'Energy Audit', 'path' => 'energy-management/energy-audit'],
                ],
            ],
            [
                'id' => 3,
                'icon' => 'GiMightySpanner',
                'name' => 'Maintenance',
                'submodules' => [
                    ['title' => 'Maintenance Schedule', 'path' => 'maintenance/maintenance-schedule'],
                    ['title' => 'Preventve Maintenance', 'path' => 'maintenance/preventive-maintenance'],
                    ['title' => 'Maintenance Records', 'path' => 'maintenance/maintenance-records'],
                ],
            ],
            [
                'id' => 4,
                'icon' => 'AiOutlineAudit',
                'name' => 'Inspection and Audits',
                'submodules' => [
                    ['title' => 'HSEQ', 'path' => 'hseq'],
                    ['title' => 'Checklists', 'path' => 'checklists'],
                    ['title' => 'FM Audit', 'path' => 'fm-audits'],
                    ['title' => 'Walkoubout', 'path' => 'walkabouts'],
                    ['title' => 'Inspection', 'path' => 'inspections'],
                ],
            ],
            [
                'id' => 5,
                'icon' => 'MdAccountBalance',
                'name' => 'Accounting',
                'submodules' => [
                    ['title' => 'Invoicing', 'path' => 'accounting/invoicing'],
                    ['title' => 'Budget', 'path' => 'accounting/budget'],
                ],
            ],
            [
                'id' => 6,
                'icon' => 'GiDesk',
                'name' => 'Space Management',
                'submodules' => [
                    ['title' => 'Space Layout', 'path' => 'space-management/spacelayout'],
                    ['title' => 'Ocupancy', 'path' => 'space-management/ocupancy'],
                    ['title' => 'Change Request', 'path' => 'space-management/change-request'],
                ],
            ],
            [
                'id' => 7,
                'icon' => 'GrMoney',
                'name' => 'Asset Management',
                'submodules' => [
                    ['title' => 'Assets', 'path' => 'asset-management/assets'],
                    ['title' => 'Tools', 'path' => 'asset-management/tools'],
                    ['title' => 'Spare parts', 'path' => 'asset-management/spare-parts'],
                ],
            ],
            [
                'id' => 8,
                'icon' => 'AiOutlineControl',
                'name' => 'Consumables Control',
                'submodules' => [
                    ['title' => 'Consumables', 'path' => 'consumables-control/consumables'],
                ],
            ],
            [
                'id' => 20,
                'icon' => 'AiOutlineControl',
                'name' => 'Inventory',
                'submodules' => [],
            ],
            [
                'id' => 9,
                'icon' => 'BsClipboard2Data',
                'name' => 'Reports',
                'submodules' => [
                    ['title' => 'Ticket Reports', 'path' => 'ticket-reports'],
                    ['title' => 'Workorder Reports', 'path' => 'workorder-reports'],
                    ['title' => 'Energy Reports', 'path' => 'energy-reports'],
                ],
            ],
            [
                'id' => 10,
                'icon' => 'SiAlwaysdata',
                'name' => 'Charts & Visualizations',
                'submodules' => [
                    ['title' => 'Ticket Charts', 'path' => 'ticket-charts'],
                    ['title' => 'Workorder Charts', 'path' => 'workorder-charts'],
                    ['title' => 'Energy Charts', 'path' => 'energy-charts'],
                ],
            ],
            [
                'id' => 11,
                'icon' => 'MdManageAccounts',
                'name' => 'User Management',
                'submodules' => [
                    ['title' => 'Users', 'path' => 'user-management/users'],
                    ['title' => 'User Roles', 'path' => 'user-management/roles'],
                    ['title' => 'Technicians', 'path' => 'user-management/technicians'],
                    ['title' => 'Suppliers', 'path' => 'user-management/suppliers'],
                ],
            ],
            [
                'id' => 12,
                'icon' => 'IoSettingsSharp',
                'name' => 'System Config',
                'submodules' => [],
            ],
        ];

        foreach ($modules as $module) {
            $moduleId = DB::table('modules')->insertGetId([
                'id' => $module['id'],
                'icon' => $module['icon'],
                'name' => $module['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($module['submodules'] as $submodule) {
                DB::table('submodules')->insert([
                    'module_id' => $moduleId,
                    'title' => $submodule['title'],
                    'path' => $submodule['path'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    
}
}
