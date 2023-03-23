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
                ->with('user')
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