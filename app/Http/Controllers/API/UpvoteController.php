<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Roadmap; // Make sure to import Roadmap
use App\Models\Upvote;  // Make sure to import Upvote
use Illuminate\Support\Facades\Auth; // For authenticated user ID
use Illuminate\Http\JsonResponse;

class UpvoteController extends Controller
{
    /**
     * Toggles the upvote status for a given roadmap by its ID.
     * If an upvote exists for the current user and roadmap, it's removed.
     * Otherwise, a new upvote is created.
     *
     * @param  int  $roadmapId The ID of the roadmap to toggle upvote for.
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle($roadmapId): JsonResponse
    {
        // Find the roadmap by its ID, or throw a 404 if not found
        $roadmap = Roadmap::findOrFail($roadmapId);

        $userId = Auth::id(); // Get the ID of the currently authenticated user

        // Check if an upvote already exists for this user and roadmap
        $upvote = Upvote::where('user_id', $userId)
                        ->where('roadmap_id', $roadmap->id)
                        ->first();

        // If an upvote exists, delete it (un-upvote)
        if ($upvote) {
            $upvote->delete();
            return response()->json(['message' => 'Upvote removed']);
        } else {
            // If no upvote exists, create a new one
            Upvote::create([
                'user_id' => $userId,
                'roadmap_id' => $roadmap->id,
            ]);
            return response()->json(['message' => 'Upvoted']);
        }
    }
}
