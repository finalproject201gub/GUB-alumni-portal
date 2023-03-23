<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;

class UpdatePostApiController extends Controller
{
    public function __invoke(PostRequest $request, $postId)
    {
        try {
            $post = Post::query()
                ->findOrFail($postId);

            $post->update(['content' => $request->content,]);

            return response()->json(
                [
                    'data' => $post,
                    'status' => 'success',
                    'message' => 'Post updated successfully',
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
