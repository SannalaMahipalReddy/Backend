<?php

namespace App\Http\Controllers;

use App\Models\CommunityPost;
use Illuminate\Http\Request;

class CommunityPostController extends Controller
{
    /**
     * Display a listing of the posts.
     */
    public function index()
    {
        // Load community and user relationships with posts
        $posts = CommunityPost::with(['community', 'user'])->get();
        return response()->json($posts);
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'community_id' => 'required|exists:communities,id',
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        // Create and return the post with relationships loaded
        $post = CommunityPost::create($request->all());
        $post->load(['community', 'user']); // Load relationships

        return response()->json($post, 201);
    }

    /**
     * Display the specified post.
     */
    public function show($id)
    {
        $post = CommunityPost::with(['community', 'user', 'comments'])->find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return response()->json($post);
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, $id)
    {
        $post = CommunityPost::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $request->validate([
            'content' => 'sometimes|required|string',
        ]);

        $post->update($request->all());
        $post->load(['community', 'user']); // Reload relationships after update

        return response()->json($post);
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy($id)
    {
        $post = CommunityPost::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
