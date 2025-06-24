<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Roadmap; 
use App\Models\Upvote; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\JsonResponse;

class UpvoteController extends Controller
{
   
    public function toggle($roadmapId): JsonResponse
    {
        $roadmap = Roadmap::findOrFail($roadmapId);

        $userId = Auth::id(); 

        $upvote = Upvote::where('user_id', $userId)
                        ->where('roadmap_id', $roadmap->id)
                        ->first();

        if ($upvote) {
            $upvote->delete();
            return response()->json(['message' => 'Upvote removed']);
        } else {
            Upvote::create([
                'user_id' => $userId,
                'roadmap_id' => $roadmap->id,
            ]);
            return response()->json(['message' => 'Upvoted']);
        }
    }
}
