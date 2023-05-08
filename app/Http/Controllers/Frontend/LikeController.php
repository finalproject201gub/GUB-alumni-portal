<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    public function likeInsertDelete(Post $post)
    {
        try {
            $like = $post->likes()->where('user_id', auth()->id())->first();
            if ($like) {
                $like->delete();
                $data['is_liked'] = false;
            } else {
                $this->like($post, Post::class);
                $data['is_liked'] = true;
            }
            $data['like_count'] = $post->likes()->count();
            
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error'
            ]);
        }
    }

    public function like($model, $likableType)
    {
        $model->likes()->create([
            'user_id' => auth()->id(),
            'likeable_id' => $model->id,
            'likeable_type' => $likableType,
            'like' => 1
        ]);
    }

    // public function dislike($id)
    // {
    //     $post = Post::findOrFail($id);
    //     $post->likes()->create([
    //         'user_id' => auth()->id(),
    //         'like' => 0
    //     ]);

    //     return redirect()->back();
    // }
}
