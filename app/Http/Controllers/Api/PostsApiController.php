<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Response;

class PostsApiController extends Controller
{
    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        try {
            $posts = Post::query()
                ->with('user', 'likes')
                ->active()
                ->latest()
                ->get();

            $data = $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'body' => $post->body,
                    'author_id' => $post->user->id,
                    'author_name' => $post->user->name,
                    'privacy_id' => 1,
                    'privacy_name' => 'public',
                    'content' => $post->content,
                    'is_liked' => $post->likes()->where('user_id', auth()->id())->exists(),
                    'like_count' => $post->likes()->count(),
                    'comment_count' => $post->comments()->count(),
                    'comments' => $post->comments()->with('user')->latest()->get(),
                    'created_at' => $post->created_at->diffForHumans(),
                    'updated_at' => $post->updated_at,
                ];
            });

            return response()->json(
                [
                    'data' => $data,
                    'status' => 'success',
                    'message' => 'Posts retrieved successfully',
                ],
                Response::HTTP_OK,
            );
        } catch (\Exception $exception) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $exception->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
