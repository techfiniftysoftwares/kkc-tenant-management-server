<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Support\Facades\Cache;


class ModuleController extends Controller
{

    public function getModules()
    {
        try {
            $modules = Module::with(['submodules' => function ($query) {
                $query->select('id', 'module_id', 'title');
            }])
            ->select('id','name')
            ->get();

            if ($modules->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'success' => true,
                    'message' => 'No modules found',
                    'data' => []
                ], 200);
            }

            return successResponse('Modules and submodules retrieved successfully', $modules);
        } catch (\Exception $e) {
            return serverErrorResponse('Failed to retrieve modules and submodules', $e->getMessage());
        }
    }







}
