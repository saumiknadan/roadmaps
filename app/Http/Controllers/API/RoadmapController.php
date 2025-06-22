<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roadmap; 
use Illuminate\Http\JsonResponse;

class RoadmapController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $roadmaps = Roadmap::query();

            if ($request->filled('search')) {
                $roadmaps->where('title', 'like', '%' . $request->search . '%')
                         ->orWhere('description', 'like', '%' . $request->search . '%'); 
            }

            $perPage = $request->input('per_page', 10);

            $roadmaps = $roadmaps->orderByDesc('id')
                                 ->paginate($perPage);

            return response()->json($roadmaps);

        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'Something went wrong while fetching roadmaps.',
                'error' => $th->getMessage() 
            ], 500); 
        }
    }
}
