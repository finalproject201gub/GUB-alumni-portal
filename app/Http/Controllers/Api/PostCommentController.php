<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;

class PostCommentController extends Controller
{
    //all comments by post id
    public function index($postId)
    {
        try {
            $post = Post::findOrFail($postId);
            $comments = $post->comments()->with('user')->latest()->get();
            return response()->json([
                'status' => 'success',
                'data' => $comments,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'. $e->getMessage(),
            ]);
        }
    }

    //store comment
    public function store(CommentRequest $request, $postId)
    {
        try {
            $post = Post::findOrFail($postId);
            $comment = $post->comments()->create([
                'user_id' => auth()->user()->id,
                'body' => $request->body,
            ]);
            $comment = $comment->load('user');
            return response()->json([
                'status' => 'success',
                'data' => $comment,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'. $e->getMessage(),
            ]);
        }
    }

    //update comment
    public function update(CommentRequest $request, $id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->update([
                'body' => $request->body,
            ]);
            $comment = $comment->load('user');
            return response()->json([
                'status' => 'success',
                'data' => $comment,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'. $e->getMessage(),
            ]);
        }
    }

    //delete comment
    public function destroy($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Comment deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'. $e->getMessage(),
            ]);
        }
    }
}
