<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Response;

class CreatePostApiController extends Controller
{
    public function __invoke(PostRequest $request, Post $post)
    {
        try {
            $post->fill([
                'user_id' => auth()->user()->id,
                'content' => $request->content,
            ])->save();

            return response()->json(
                [
                    'data' => $post,
                    'status' => 'success',
                    'message' => 'Post created successfully',
                ],
                Response::HTTP_OK,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
