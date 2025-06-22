<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Roadmap; 
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth; 

class CommentController extends Controller
{
    
    public function index($roadmapId): JsonResponse
    {
        $roadmap = Roadmap::findOrFail($roadmapId);

        $comments = $roadmap->comments()
            ->whereNull('parent_id') 
            ->with(['user', 'replies.user', 'replies.replies.user']) 
            ->get();

        return response()->json($comments);
    }

    
    public function store(Request $request, $roadmapId): JsonResponse
    {
        $request->validate([
            'comment' => 'required|string|max:300',
            'parent_id' => 'nullable|exists:comments,id', 
        ]);

        $roadmap = Roadmap::findOrFail($roadmapId);

        
        $comment = $roadmap->comments()->create([
            'user_id' => Auth::id(), 
            'comment' => $request->comment,
            'parent_id' => $request->parent_id,
        ]);

       
        $comment->load('user');

      
        return response()->json($comment, 201); 
    }

    public function update(Request $request, $commentId): JsonResponse
    {
        $comment = Comment::findOrFail($commentId);

        if (Auth::id() !== $comment->user_id) {
            return response()->json(['message' => 'Unauthorized to update this comment.'], 403);
        }

        $request->validate([
            'comment' => 'required|string|max:300',
        ]);

        $comment->update([
            'comment' => $request->comment,
        ]);

        $comment->load(['user', 'replies.user', 'replies.replies.user']);
        
        return response()->json($comment);
    }

 
    public function destroy($commentId): JsonResponse
    {
        $comment = Comment::findOrFail($commentId);

        
        if (Auth::id() !== $comment->user_id) {
            return response()->json(['message' => 'Unauthorized to delete this comment.'], 403);
        }
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully.']);
    }
}
