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
        // try {

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
            $post->load('user:id,name,avatar', 'likes:id,user_id', 'comments:id,user_id,body,created_at', 'images:id,attachable_id,path');

                // $post->author_avatar = $post->user->avatar ? asset('img/profile/'.$post->user->avatar) : asset('img/avatar.jpg');
                // $post->author_id = $post->user->id;
                // $post->author_name = $post->user->name;
                // $post->privacy_id = 1;
                // $post->privacy_name = 'public';
                // $post->is_liked = $post
                //     ->likes()
                //     ->where('user_id', auth()->id())
                //     ->exists();
                // $post->like_count = $post->likes()->count();
                // $post->comment_count = $post->comments()->count();
                // $post->comments = $post
                //     ->comments()
                //     ->with('user:id,name,avatar', 'replies')
                //     ->latest()
                //     ->take(1)
                //     ->get()
                //     ->map(function ($comment) {
                //         $avatar = $comment->user->avatar ? asset('img/profile/' . $comment->user->avatar) : asset('img/avatar.jpg');

                //         return [
                //             'id' => $comment->id,
                //             'body' => $comment->body,
                //             'commented_by' => $comment->user->name,
                //             'commented_by_avatar' => $avatar,
                //             'is_liked' => $comment
                //                 ->likes()
                //                 ->where('user_id', auth()->id())
                //                 ->exists(),
                //             'like_count' => $comment->likes()->count(),
                //             'created_at' => $comment->created_at,
                //         ];
                //     });
                //     $post->images = $post->images->map(function ($image) {
                //         return [
                //             'id' => $image->id,
                //             'image_url' => asset($image->path),
                //         ];
                //     });
                //     $post->created_at = $post->created_at->diffForHumans();
                //     $post->updated_at = $post->updated_at->diffForHumans();

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
                    'message' => 'Post created successfully',
                ],
                Response::HTTP_OK,
            );
        // } catch (\Exception $e) {
        //     return response()->json(
        //         [
        //             'status' => 'error',
        //             'message' => $e->getMessage(),
        //         ],
        //         Response::HTTP_INTERNAL_SERVER_ERROR,
        //     );
        // }
    }
}
