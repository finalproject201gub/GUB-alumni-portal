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
            $posts = Post::query()->get();

            return response()->json(
                [
                    'data' => $posts,
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
