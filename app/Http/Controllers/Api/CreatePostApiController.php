<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class CreatePostApiController extends Controller
{
    public function __invoke(PostRequest $request, Post $post): \Illuminate\Http\JsonResponse
    {
        try {

            $images = $request->get('images') ?? [];

            $post->fill([
                'user_id' => auth()->user()->id,
                'content' => $request->get('content'),
            ])->save();

            foreach ($images as $image) {
                $image = $image['image_url'];
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = Str::random(10).time().'.'.'png';
                $path = 'posts/' . $imageName;

                File::put(public_path().'/'. $path, base64_decode($image));

                $post->images()->create([
                    'path' => $path,
                    'image_type' => 'png',
                    'uploaded_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                ]);
            }

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
