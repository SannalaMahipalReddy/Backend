<?php

namespace App\Http\Controllers;

use App\Models\CommunityComment;
use Illuminate\Http\Request;

class CommunityCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = CommunityComment::all();
        return response()->json($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:community_posts,id',
            'user_id' => 'required|exists:users,id',
            'comment' => 'required|string|max:500',
        ]);

        $comment = CommunityComment::create($request->all());
        return response()->json($comment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $comment = CommunityComment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        return response()->json($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $comment = CommunityComment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $comment->update($request->all());
        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $comment = CommunityComment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
