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

            foreach($request->get('images') ?? [] as $image) {
                if (!isset($image['id']) && isset($image['image_url'])) {
                    $image_parts = explode(";base64,", $image['image_url']);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $uniqid = uniqid();
                    $folderPath = 'posts/';
                    $file = $folderPath . $uniqid . '.'.$image_type;

                    file_put_contents($file, $image_base64);

                    $post->images()->create([
                        'path' => $file,
                        'image_type' => $image_type,
                        'uploaded_by' => auth()->user()->id,
                        'updated_by' => auth()->user()->id,
                    ]);
                }
            }

            $post->update(['content' => $request->content]);
            $post->load('user:id,name,avatar', 'likes:id,user_id', 'comments:id,user_id,body,created_at', 'images:id,attachable_id,path');
            $postData = [
                'id' => $post->id,
                'content' => $post->content,
                'author_avatar' =>$post->user->avatar ? asset('img/profile/'.$post->user->avatar) : asset('img/avatar.jpg'),
                'author_id' => $post->user->id,
                'author_name' => $post->user->name,
                'privacy_id' => 1,
                'privacy_name' => 'public',
                'is_liked' => $post
                    ->likes()
                    ->where('user_id', auth()->id())
                    ->exists(),
                'like_count' => $post->likes()->count(),
                'comment_count' => $post->comments()->count(),
                'comments' => $post
                    ->comments()
                    ->with('user:id,name,avatar', 'replies')
                    ->latest()
                    ->take(1)
                    ->get()
                    ->map(function ($comment) {
                        $avatar = $comment->user->avatar ? asset('img/profile/' . $comment->user->avatar) : asset('img/avatar.jpg');

                        return [
                            'id' => $comment->id,
                            'body' => $comment->body,
                            'commented_by' => $comment->user->name,
                            'commented_by_avatar' => $avatar,
                            'is_liked' => $comment
                                ->likes()
                                ->where('user_id', auth()->id())
                                ->exists(),
                            'like_count' => $comment->likes()->count(),
                            'created_at' => $comment->created_at,
                        ];
                    }),
                'images' => $post->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'image_url' => asset($image->path),
                    ];
                }),
                'created_at' => $post->created_at->diffForHumans(),
                'updated_at' => $post->updated_at->diffForHumans(),

            ];

            return response()->json(
                [
                    'data' => $postData,
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
