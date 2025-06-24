<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    
    public function index(Request $request): JsonResponse
    {
        try {
            $categories = Category::all();

            return response()->json($categories);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong while fetching categories.',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
