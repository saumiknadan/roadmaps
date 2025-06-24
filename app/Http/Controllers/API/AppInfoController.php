<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppInfo;
use Illuminate\Http\JsonResponse;

class AppInfoController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $appInfo = AppInfo::first();

            if (!$appInfo) {
                return response()->json([
                    'message' => 'Application information not found.',
                    'app_info' => null 
                ], 404);
            }

            return response()->json($appInfo);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong while fetching application information.',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
