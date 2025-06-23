<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roadmap; 
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth; 

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

            $roadmaps->withCount('upvotes');

            if ($request->filled('sort_by') && $request->sort_by === 'upvotes_count') {
                $roadmaps->orderByDesc('upvotes_count'); 
            } else {
                $roadmaps->orderByDesc('id'); 
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


    public function show($id): JsonResponse
    {
        try {
            $roadmap = Roadmap::with([
                'comments' => function ($query) {
                    $query->whereNull('parent_id')
                          ->with(['user', 'replies.user', 'replies.replies.user']);
                }
            ])
            ->withCount('upvotes')
            ->findOrFail($id); 
    
            $roadmap->is_upvoted_by_current_user = Auth::check() && $roadmap->upvotes()->where('user_id', Auth::id())->exists();
    
            return response()->json($roadmap);
    
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Roadmap not found.'], 404);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong while fetching the roadmap.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
}
