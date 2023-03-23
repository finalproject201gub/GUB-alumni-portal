<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeletePostApiController extends Controller
{
    public function __invoke($id): \Illuminate\Http\JsonResponse
    {
        try {
            $post = Post::query()
                ->where('user_id', auth()->user()->id)
                ->findOrFail($id);

            $post->delete();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Post deleted successfully',
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
