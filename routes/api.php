<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserLocationController;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\TechnicianController;
use App\Http\Controllers\Api\WorkorderController;
use App\Http\Controllers\Api\TechnicianGroupController;
use App\Http\Controllers\Api\TechnicianTypeController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\EquipmentsController;
use App\Http\Controllers\Api\EnergyConsumptionController;
use App\Http\Controllers\Api\SpaceController;
use App\Http\Controllers\Api\EnergyTypesController;
use App\Http\Controllers\Api\EnergyConsumptionLocationsController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\MaintenanceTypeController;
use App\Http\Controllers\Api\MaintenanceCostTypeController;
use App\Http\Controllers\Api\MaintenanceChecklistTypeController;
use App\Http\Controllers\Api\MaintenanceChecklistItemController;
use App\Http\Controllers\Api\MaintenanceChecklistController;
use App\Http\Controllers\Api\MaintenanceCostController;
use App\Http\Controllers\Api\MaintenanceController;
use App\Http\Controllers\Api\WorkOrderChecklistTypeController;
use App\Http\Controllers\Api\WorkOrderChecklistTemplateController;
use App\Http\Controllers\Api\WorkOrderChecklistSectionController;
use App\Http\Controllers\Api\WorkOrderChecklistItemController;
use App\Http\Controllers\Api\WorkOrderChecklistController;
use App\Http\Controllers\Api\WorkOrderChecklistResponseController;
use App\Http\Controllers\Api\WorkOrderCostTypeController;
use App\Http\Controllers\Api\ToolController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\BatchController;
use App\Http\Controllers\Api\ReportsController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\FacilityStructureController;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::namespace('App\Http\Controllers\Api')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', 'AuthController@login');
        Route::post('verify-otp', 'AuthController@verifyOTP');
        Route::post('password/send-reset-email', 'PasswordResetController@sendResetPasswordEmail');
        Route::post('password/reset', 'PasswordResetController@reset');
    });

    Route::group([
        'middleware' => ['auth:api']
    ], function () {
        Route::post('signup', 'AuthController@signup');
        Route::post('support', 'AuthController@submit');


        // notifications
        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
        Route::post('/notifications/{notification}/unread', [NotificationController::class, 'markAsUnread']);

        //logout
        Route::post('/logout', 'AuthController@logout');

        //Assets
        Route::post('/assets', [AssetController::class, 'store']);
        Route::get('/assets', [AssetController::class, 'index']);
        Route::get('/assets/{id}', [AssetController::class, 'show']);
        Route::put('/assets/{id}', [AssetController::class, 'update']);
        Route::delete('/assets/{id}', [AssetController::class, 'destroy']);
        Route::get('/asset-types', [AssetController::class, 'getAssetTypes']);
        Route::get('/suppliers', [AssetController::class, 'getSuppliers']);







        // Facility routes
        Route::post('/facilities', [FacilityStructureController::class, 'createFacility']);

        Route::get('/facilities/{id}', [FacilityStructureController::class, 'getFacility']);

        Route::get('/facilities', [FacilityStructureController::class, 'getAllFacilities']);

        Route::put('/facilities/{id}', [FacilityStructureController::class, 'updateFacility']);
        Route::delete('/facilities/{id}', [FacilityStructureController::class, 'deleteFacility']);

        // Facility Type routes
        Route::post('/facility-types', [FacilityStructureController::class, 'createFacilityType']);
        Route::get('/facility-types/{id}', [FacilityStructureController::class, 'getFacilityType']);

        Route::get('/facility-types', [FacilityStructureController::class, 'getAllFacilityTypes']);

        Route::put('/facility-types/{id}', [FacilityStructureController::class, 'getFacilityTypeById']);
        Route::delete('/facility-types/{id}', [FacilityStructureController::class, 'deleteFacilityType']);

        // Branch routes
        Route::post('/branches', [FacilityStructureController::class, 'createBranch']);
        Route::get('/branches', [FacilityStructureController::class, 'getAllBranches']);
        Route::get('facilities/{facilityId}/branches', [FacilityStructureController::class, 'getBranchesByFacilityId']);
        Route::get('/branches/{id}', [FacilityStructureController::class, 'getBranchById']);
        Route::put('/branches/{id}', [FacilityStructureController::class, 'updateBranch']);
        Route::delete('/branches/{id}', [FacilityStructureController::class, 'deleteBranch']);

        // Building Type routes
        Route::post('/building-types', [FacilityStructureController::class, 'createBuildingType']);
        Route::get('/building-types', [FacilityStructureController::class, 'getAllBuildingTypes']);
        Route::get('/building-types/{id}', [FacilityStructureController::class, 'getBuildingTypeById']);
        Route::put('/building-types/{id}', [FacilityStructureController::class, 'updateBuildingType']);
        Route::delete('/building-types/{id}', [FacilityStructureController::class, 'deleteBuildingType']);




        Route::get('/facilities/{facilityId}/buildings', [FacilityStructureController::class, 'getBuildingsByFacility']);
        Route::get('/branches/{branchId}/buildings', [FacilityStructureController::class, 'getBuildingsByBranch']);


        // Building routes
        Route::post('/buildings', [FacilityStructureController::class, 'createBuilding']);
        Route::get('/buildings', [FacilityStructureController::class, 'getAllBuildings']);
        Route::get('/buildings/{id}', [FacilityStructureController::class, 'getBuildingById']);
        Route::put('/buildings/{id}', [FacilityStructureController::class, 'updateBuilding']);
        Route::delete('/buildings/{id}', [FacilityStructureController::class, 'deleteBuilding']);

        // Building Information Key routes
        Route::post('/building-info-keys', [FacilityStructureController::class, 'createBuildingInfoKey']);
        Route::get('/building-info-keys', [FacilityStructureController::class, 'getAllBuildingInfoKeys']);

        // Building Attribute Type routes
        Route::post('/building-attribute-types', [FacilityStructureController::class, 'createBuildingAttributeType']);
        Route::get('/building-attribute-types', [FacilityStructureController::class, 'getAllBuildingAttributeTypes']);

        Route::post('building-information-values', [FacilityStructureController::class, 'addBuildingInformation']);

        Route::get('/building-attributes', [FacilityStructureController::class, 'getBuildingAttribute']);

        Route::post('/building-attributes', [FacilityStructureController::class, 'storeBuildingAttribute']);

        Route::get('/building-attributes/{id}', [FacilityStructureController::class, 'showBuildingAttribute']);

        Route::put('/building-attributes/{id}', [FacilityStructureController::class, 'updateBuildingAttribute']);

        Route::delete('/building-attributes/{id}', [FacilityStructureController::class, 'destroyBuildingAttribute']);

        Route::get('buildings/{buildingId}/information', [FacilityStructureController::class, 'getBuildingInformation']);

        Route::get('building-attributes/{building_attribute_id}/information', [FacilityStructureController::class, 'getAttributeInformation']);




        // Building Attribute Type routes
        Route::post('/attribute-information-keys', [FacilityStructureController::class, 'createAttributeInformationKey']);
        Route::post('/attribute-information-values', [FacilityStructureController::class, 'createAttributeInformationValue']);


        Route::get('/attribute-information-key/attribute-type/{building_attribute_type_id}', [FacilityStructureController::class, 'getAttributeInformationKeysByType']);


        Route::get('/buildings/{buildingId}/attributes', [FacilityStructureController::class, 'getBuildingAttributes']);



        Route::get('/locations', [UserLocationController::class, 'index']);
        Route::post('/locations', [UserLocationController::class, 'store']);
        Route::post('/multiple', [UserLocationController::class, 'assignMultiple']);
        Route::put('/locations/{location}', [UserLocationController::class, 'update']);
        Route::delete('/locations/{location}', [UserLocationController::class, 'destroy']);


        Route::get('/spare-parts', 'InventoryController@getAllSpareParts');
        Route::get('/consumables', 'InventoryController@getAllConsumables');

        Route::post('/spare-parts', 'BatchController@storeSparePart');
        Route::post('/consumables', 'BatchController@storeConsumable');
        Route::put('/consumables/{id}', 'BatchController@restockConsumable');
        Route::put('/spare-parts/{id}', 'BatchController@restockSparePart');
        Route::put('/consumables/edit/{id}', 'BatchController@updateConsumable');
        Route::put('/spare-parts/edit/{id}', 'BatchController@updateSparePart');

        Route::get('/spare-parts/{id}', 'InventoryController@showSparePart');
        Route::get('/consumables/{id}', 'InventoryController@showConsumable');

        Route::get('/consumable-categories', 'InventoryController@getAllConsumableCategories');
        Route::get('/consumable-categories/{id}', 'InventoryController@getConsumableCategoryById');
        Route::post('/consumable-categories', 'InventoryController@createConsumableCategory');
        Route::put('/consumable-categories/{id}', 'InventoryController@updateConsumableCategory');
        Route::delete('/consumable-categories/{id}', 'InventoryController@deleteConsumableCategory');

        // Routes for ConsumableTransactionController
        Route::post('/consumables/issue', [TransactionController::class, 'issueConsumable']);
        Route::post('/spare-parts/issue', [TransactionController::class, 'issueSparePart']);


        Route::post('/consumables/issue', [TransactionController::class, 'issueConsumable']);
        Route::post('/consumables/purchase', [TransactionController::class, 'purchaseConsumable']);
        Route::post('/spare-parts/issue', [TransactionController::class, 'issueSparePart']);
        Route::post('/spare-parts/purchase', [TransactionController::class, 'purchaseSparePart']);



        //Tool Management
        Route::get('tool-categories', [ToolController::class, 'indexCategories']);
        Route::post('tool-categories', [ToolController::class, 'storeCategory']);
        Route::get('tool-categories/{id}', [ToolController::class, 'showCategory']);
        Route::put('tool-categories/{id}', [ToolController::class, 'updateCategory']);
        Route::delete('tool-categories/{id}', [ToolController::class, 'destroyCategory']);
        //Incidents
        Route::post('/report-incident', [TicketController::class, 'reportIncident']);
        Route::get('/incident-types', [TicketController::class, 'getIncidentTypes']);
        Route::get('/tickets', [TicketController::class, 'index']);
        Route::get('/incident-tickets', [TicketController::class, 'getIncidentTickets']);
        Route::get('/incident-ticket-details/{id}', [TicketController::class, 'getIncidentTicketDetails']);
        Route::post('/reject-ticket', [TicketController::class, 'rejectTicket']);
        // Maintenance Route
        Route::post('/report-maintenance', [TicketController::class, 'reportMaintenance']);
        Route::get('/maintenance-tickets', [TicketController::class, 'getMaintenanceTickets']);
        Route::get('/maintenance-ticket-details/{id}', [TicketController::class, 'getMaintenanceTicketDetails']);
        // asset relocation
        Route::post('/report-asset-relocation', [TicketController::class, 'reportAssetRelocationTicket']);
        Route::get('/asset-relocation-tickets', [TicketController::class, 'getAssetRelocationTickets']);
        Route::get('/asset-relocation-ticket-details/{id}', [TicketController::class, 'getAssetRelocationTicketDetails']);
        // aseet requisition ticket
        Route::post('/report-requisition', [TicketController::class, 'reportRequisitionTicket']);
        Route::get('/requisition-tickets', [TicketController::class, 'getRequisitionTickets']);
        Route::get('/requisition-ticket-details/{id}', [TicketController::class, 'getRequisitionTicketDetails']);
        // my tickets
        Route::get(
            '/my-tickets',
            [TicketController::class, 'getMyTickets']
        );
        Route::get('/my-ticket-details/{id}', [TicketController::class, 'getMyTicketDetails']);
        // user
        Route::apiResource('/users', 'UserController')->only(['index']);
        Route::get('/user/profile', [UserController::class, 'getProfile']);
        Route::put('/user/profile', [UserController::class, 'updateProfile']);
        Route::put('/users/{user}/edit', [UserController::class, 'updateUserSpecifics']);
        Route::get('/users/branch/{id}', [UserController::class, 'getUsersByBranch']);


        //Equipments
        Route::apiResource('equipments', EquipmentsController::class);
        Route::get('/equipment-types', [EquipmentsController::class, 'getEquipmentTypes']);


        //Energy Consumptions
        Route::apiResource('energy-consumptions', EnergyConsumptionController::class);


        //Energy Consumptions types
        Route::apiResource('energy-types', EnergyTypesController::class);


        //Energy Consumptions Locations
        Route::apiResource('energy-consumption-locations', EnergyConsumptionLocationsController::class);

        Route::apiResource('/roles', RoleController::class);
        Route::apiResource('/permissions', PermissionController::class);
        Route::put('roles/{role}/permissions', [RoleController::class, 'updatePermissions']);


        // get modules
        Route::get('/modules', [ModuleController::class, 'getModules']);

        // technicians
        Route::get('/technicians/{id?}', [TechnicianController::class, 'index']);
        Route::post('/technicians', [TechnicianController::class, 'store']);
        Route::put('/technicians/{id}', [TechnicianController::class, 'update']);
        // technician type
        Route::get('/technician-types/{id?}', [TechnicianTypeController::class, 'getTechnicianType']);
        Route::get('/technician-types', [TechnicianTypeController::class, 'index']);
        Route::post('/technician-types', [TechnicianTypeController::class, 'store']);
        Route::put('/technician-types', [TechnicianTypeController::class, 'update']);
        Route::delete('/technician-types', [TechnicianTypeController::class, 'destroy']); // Add this line


        // technician group
        // Technician Group routes
        Route::prefix('technician-groups')->group(function () {
            Route::get('/', [TechnicianGroupController::class, 'index']);
            Route::get('/{id}', [TechnicianGroupController::class, 'show']); // Assuming you want a show method
            Route::post('/', [TechnicianGroupController::class, 'store']);
            Route::put('/', [TechnicianGroupController::class, 'update']);
            Route::post('/assign-lead', [TechnicianGroupController::class, 'assignGroupLead']);
            Route::delete('/', [TechnicianGroupController::class, 'destroy']); // Add this line
        });

        // workorders
        Route::get('/workorders/{id?}', [WorkOrderController::class, 'index']);
        Route::post('/workorders', [WorkOrderController::class, 'store']);
        Route::post('/work-orders/close', [WorkOrderController::class, 'closeWorkorder']);
        Route::post('/workorders/comments', [WorkOrderController::class, 'addComments']);
        Route::post('/work-orders/hold', [WorkOrderController::class, 'putWorkorderOnHold']);
        Route::post('/work-orders/complete', [WorkOrderController::class, 'completeWorkOrder']);
        Route::post('/work-orders/reopen', [WorkOrderController::class, 'reopenWorkorder']);
        // incident workorders
        Route::post('/work-orders/create-incident', [WorkOrderController::class, 'createIncidentWorkorder']);
        Route::post('/work-orders/incident/details', [WorkOrderController::class, 'getIncidentWorkOrderDetails']);
        // requistion workorders
        Route::post('/work-orders/create-requisition', [WorkOrderController::class, 'createRequisitionWorkorder']);
        // Get details of a specific requisition work order
        Route::get('/work-orders/requisition/{work_order_id}', [WorkOrderController::class, 'getRequisitionWorkOrderDetails']);
        // Get all requisition work orders
        Route::get('/work-orders/requisition', [WorkOrderController::class, 'getAllRequisitionWorkOrders']);
        // relocaton
        // Create asset relocation work order
        Route::post('/work-orders/asset-relocation', [WorkOrderController::class, 'createAssetRelocationWorkorder']);
        // Get all asset relocation work orders
        Route::get('/work-orders/asset-relocation', [WorkOrderController::class, 'getAllAssetRelocationWorkorders']);
        // Get asset relocation work order details
        Route::post('/work-orders/asset-relocation/details', [WorkOrderController::class, 'getAssetRelocationWorkorderDetails']);
        //techinician workorders
        // Technician Assigned Incident Work Orders
        Route::get('/technician/incident-work-orders', [WorkOrderController::class, 'getTechnicianAssignedIncidentWorkOrders']);
        // Technician Group Assigned Incident Work Orders
        Route::get('/technician/group/incident-work-orders', [WorkOrderController::class, 'getTechnicianGroupAssignedIncidentWorkOrders']);
        // Technician Type Assigned Incident Work Orders
        Route::get('/technician/type/incident-work-orders', [WorkOrderController::class, 'getTechnicianTypeAssignedIncidentWorkOrders']);
        Route::get('/technician/all-assigned-incident-work-orders', [WorkOrderController::class, 'getAllAssignedIncidentWorkOrders']);
        // Add the route for getting all incident work orders
        Route::get('/work-orders/incident', [WorkOrderController::class, 'getAllIncidentWorkOrders']);

        // checklists
        Route::post('/work-orders/checklists', [WorkOrderChecklistController::class, 'getChecklists']);
        Route::post('work-orders/checklists/responses', [WorkOrderChecklistController::class, 'submitChecklistResponses']);
        Route::post('/work-orders/checklists/complete', [WorkOrderChecklistController::class, 'completeChecklist']);
        Route::post('/work-orders/checklists/get', [WorkOrderChecklistController::class, 'getChecklist']);
        Route::post('/work-orders/checklists/review', [WorkOrderChecklistController::class, 'reviewChecklists']);
        // workorder checklist
        // Work Order Checklist Types
        // Work Order Checklist Types
        Route::get('work-order-checklist-types/{id?}', [WorkOrderChecklistTypeController::class, 'index']);
        Route::post('work-order-checklist-types', [WorkOrderChecklistTypeController::class, 'store']);
        Route::put('work-order-checklist-types', [WorkOrderChecklistTypeController::class, 'update']);
        Route::delete('work-order-checklist-types', [WorkOrderChecklistTypeController::class, 'destroy']);

        // Work Order Checklist Templates
        Route::get('work-order-checklist-templates/{id?}', [WorkOrderChecklistTemplateController::class, 'index']);
        Route::post('work-order-checklist-templates', [WorkOrderChecklistTemplateController::class, 'store']);
        Route::put('work-order-checklist-templates', [WorkOrderChecklistTemplateController::class, 'update']);
        Route::delete('work-order-checklist-templates', [WorkOrderChecklistTemplateController::class, 'destroy']);

        // Work Order Checklist Sections
        Route::get('work-order-checklist-templates/{templateId}/sections', [WorkOrderChecklistSectionController::class, 'index']);
        Route::post('work-order-checklist-sections', [WorkOrderChecklistSectionController::class, 'store']);
        Route::put('work-order-checklist-sections', [WorkOrderChecklistSectionController::class, 'update']);
        Route::delete('work-order-checklist-sections', [WorkOrderChecklistSectionController::class, 'destroy']);
        Route::post('work-order-checklist-template-sections', [WorkOrderChecklistSectionController::class, 'getSectionsByTemplate']);

        // Work Order Checklist Items
        Route::get('work-order-checklist-sections/{sectionId}/items', [WorkOrderChecklistItemController::class, 'index']);
        Route::post('work-order-checklist-items', [WorkOrderChecklistItemController::class, 'store']);
        Route::put('work-order-checklist-items', [WorkOrderChecklistItemController::class, 'update']);
        Route::delete('work-order-checklist-items', [WorkOrderChecklistItemController::class, 'destroy']);

        // Work Order Checklists
        Route::get('work-orders/{workOrderId}/checklists', [WorkOrderChecklistController::class, 'index']);
        Route::post('work-order-checklists', [WorkOrderChecklistController::class, 'store']);
        Route::put('work-order-checklists', [WorkOrderChecklistController::class, 'update']);
        Route::delete('work-order-checklists', [WorkOrderChecklistController::class, 'destroy']);

        // Work Order Checklist Responses
        Route::get('work-order-checklists/{checklistId}/responses', [WorkOrderChecklistResponseController::class, 'index']);
        Route::post('work-order-checklist-responses', [WorkOrderChecklistResponseController::class, 'store']);
        Route::put('work-order-checklist-responses', [WorkOrderChecklistResponseController::class, 'update']);
        Route::delete('work-order-checklist-responses', [WorkOrderChecklistResponseController::class, 'destroy']);
        Route::prefix('work-order-cost-types')->group(function () {
            Route::get('/{id?}', [WorkOrderCostTypeController::class, 'index']);
            Route::post('/', [WorkOrderCostTypeController::class, 'store']);
            Route::put('/{id}', [WorkOrderCostTypeController::class, 'update']);
        });
        // Suppliers
        Route::get('/suppliers/{id?}', [SupplierController::class, 'index']);
        Route::post('/suppliers', [SupplierController::class, 'store']);
        Route::put('/suppliers/{id}', [SupplierController::class, 'update']);;

        // Route for broadcasting authentication
        Route::post('/broadcasting/auth', function (Request $request) {
            return Broadcast::auth($request);
        });


        // technicians
        Route::get('/technicians/{id?}', [TechnicianController::class, 'index']);
        Route::post('/technicians', [TechnicianController::class, 'store']);
        Route::put('/technicians/{id}', [TechnicianController::class, 'update']);
        // technician group
        Route::get('/technician-groups/{id?}', [TechnicianGroupController::class, 'index']);
        Route::post('/technician-groups', [TechnicianGroupController::class, 'store']);
        Route::put('/technician-groups/{id}', [TechnicianGroupController::class, 'update']);
        // Suppliers
        Route::get('/suppliers/{id?}', [SupplierController::class, 'index']);
        Route::post('/suppliers', [SupplierController::class, 'store']);
        Route::put('/suppliers/{id}', [SupplierController::class, 'update']);;

        // Maintenance types
        Route::get('/maintenance-types/{id?}', [MaintenanceTypeController::class, 'index']);
        Route::post('/maintenance-types', [MaintenanceTypeController::class, 'store']);
        Route::put('/maintenance-types', [MaintenanceTypeController::class, 'update']);

        // Maintenance Cost Types
        Route::get('/maintenance-cost-types/{id?}', [MaintenanceCostTypeController::class, 'index']);
        Route::post('/maintenance-cost-types', [MaintenanceCostTypeController::class, 'store']);
        Route::put('/maintenance-cost-types', [MaintenanceCostTypeController::class, 'update']);
        // Maintenance Checklist Types
        Route::get('/maintenance-checklist-types/{id?}', [MaintenanceChecklistTypeController::class, 'index']);
        Route::post('/maintenance-checklist-types', [MaintenanceChecklistTypeController::class, 'store']);
        Route::put('/maintenance-checklist-types', [MaintenanceChecklistTypeController::class, 'update']);
        // Maintenance Checklist Items
        Route::get('/maintenance-checklist-items/{id?}', [MaintenanceChecklistItemController::class, 'index']);
        Route::post('/maintenance-checklist-items', [MaintenanceChecklistItemController::class, 'store']);
        Route::put('/maintenance-checklist-items', [MaintenanceChecklistItemController::class, 'update']);
        Route::delete('/maintenance-checklist-items', [MaintenanceChecklistItemController::class, 'destroy']);
        // Get Checklist Items by Checklist Type
        Route::get('/maintenance-checklist-types/{checklistTypeId}/items', [MaintenanceChecklistItemController::class, 'indexByChecklistType']);
        // Maintenance Checklists
        Route::get('/maintenance-checklists', [MaintenanceChecklistController::class, 'index']);
        Route::post('/maintenance-checklists', [MaintenanceChecklistController::class, 'store']);
        Route::put('/maintenance-checklists', [MaintenanceChecklistController::class, 'update']);
        Route::delete('/maintenance-checklists', [MaintenanceChecklistController::class, 'destroy']);

        // Get Checklists by Maintenance
        Route::get('/maintenances/{maintenanceId}/checklists', [MaintenanceChecklistController::class, 'getChecklistsByMaintenance']);
        // / Maintenance Costs
        Route::get('/maintenance-costs', [MaintenanceCostController::class, 'index']);
        Route::get('/maintenance-costs/{id}', [MaintenanceCostController::class, 'show']);
        Route::post(
            '/maintenance-costs',
            [MaintenanceCostController::class, 'store']
        );
        Route::put('/maintenance-costs', [MaintenanceCostController::class, 'update']);
        Route::delete('/maintenance-costs', [MaintenanceCostController::class, 'destroy']);
        Route::prefix('maintenances')->group(function () {
            Route::get('/', [MaintenanceController::class, 'index']);
            Route::get('/{id}', [MaintenanceController::class, 'show']);
            Route::post('/', [MaintenanceController::class, 'store']);
            Route::put('/{id}', [MaintenanceController::class, 'update']);
            Route::delete('/{id}', [MaintenanceController::class, 'destroy']);
        });

        // Route for broadcasting authentication
        Route::post('/broadcasting/auth', function (Request $request) {
            return Broadcast::auth($request);
        });

        Route::get('/ticket-attachment/{type}/{filename}', function ($type, $filename) {
            $path = storage_path("app/public/tickets/$type/$filename");
            if (!file_exists($path)) {
                abort(404);
            }
            return response()->file($path);
        })->where('type', 'photos|documents')->where('filename', '.*');

        //  Enter the URL for your API endpoint, e.g., http://your-domain.com/api/workorders.
        //     For testing search:


        //     Add the search query parameter: http://your-domain.com/api/workorders?search=keyword


        //     For testing filter:

        //     Add the filter query parameter with the desired filters:

        //     Filter by status: http://your-domain.com/api/workorders?filter[status]=open
        //     Filter by technician ID: http://your-domain.com/api/workorders?filter[technician_id]=1
        //     Filter by multiple fields: http://your-domain.com/api/workorders?filter[status]=open&filter[technician_id]=1




        //     For testing sort:

        //     Add the sort query parameter: http://your-domain.com/api/workorders?sort=created_at (ascending order)
        //     Add the sort query parameter with a - prefix for descending order: http://your-domain.com/api/workorders?sort=-created_at


        //     For testing combinations:

        //     Search and filter: http://your-domain.com/api/workorders?search=keyword&filter[status]=open
        //     Search, filter, and sort: http://your-domain.com/api/workorders?search=keyword&filter[status]=open&sort=-created_at



        //     Search and filter: http://your-domain.com/api/workorders?search=keyword&filter[status]=open
        //     Search, filter, and sort: http://your-domain.com/api/workorders?search=keyword&filter[status]=open&sort=-created_at



        Route::post('/upload', [FileUploadController::class, 'upload']);


        // Reports by date
        Route::get('/reports/work-orders/asset-relocation', [ReportsController::class, 'generateAssetRelocationReport']);
        Route::get('/reports/work-orders/requisition', [ReportsController::class, 'generateRequisitionReport']);
        Route::get('/reports/work-orders/incident', [ReportsController::class, 'generateIncidentReport']);
        Route::get('/reports/energy-consumption', [ReportsController::class, 'generateEnergyConsumptionReport']);

        Route::get('/reports/inventory/batches', [ReportsController::class, 'generateInventoryBatchReport']);
        Route::get('/reports/inventory/dispatch-transactions', [ReportsController::class, 'generateDispatchTransactionReport']);
        Route::get('/reports/inventory/levels', [ReportsController::class, 'generateInventoryLevelReport']);

        Route::get('/reports/assets/depreciation', [ReportsController::class, 'generateDepreciationReport']);
        Route::get('/reports/assets/list', [ReportsController::class, 'generateAssetListReport']);
        Route::get('/reports/assets/maintenance', [ReportsController::class, 'generateAssetMaintenanceReport']);
    });
});
