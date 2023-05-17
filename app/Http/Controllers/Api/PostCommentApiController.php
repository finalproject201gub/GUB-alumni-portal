<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Response;

class PostCommentApiController extends Controller
{
    public function __invoke($postId): \Illuminate\Http\JsonResponse
    {
        try {
            $offset = request()->get('offset', 0);
            $limit = request()->get('limit', 5);

            $data = Comment::query()
                ->where(['commentable_type' => Post::class, 'commentable_id' => $postId])
                ->with('user')
                ->offset($offset)
                ->limit($limit)
                ->get();

            return response()->json(
                [
                    'data' => $data,
                    'status' => 'success',
                    'message' => 'Comments retrieved successfully',
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
