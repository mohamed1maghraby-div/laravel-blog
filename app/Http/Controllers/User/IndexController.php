<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $posts = Post::with(['media', 'user', 'category', 'media'])
            ->whereHas('category', function($query){
                $query->whereStatus(1);
            })
            ->whereHas('user', function($query){
                $query->whereStatus(1);
            })
            ->post()->active()->orderBy('id', 'desc')->paginate(5);

        return view('user.index', compact('posts'));
    }

    public function post_show($slug)
    {
        $post = Post::with(['category', 'media', 'user', 
            'approved_comments' => function($query){
                $query->orderBy('id', 'desc');
            }
        ]);
        $post = $post->whereHas('category', function($query){
            $query->whereStatus(1);
        })
        ->whereHas('user', function($query){
            $query->whereStatus(1);
        });
        $post = $post->whereSlug($slug)->active()->first();

        if($post){
            $blade = $post->post_type == 'post' ? 'post' : 'page';

            return view('user.' . $blade, compact('post'));
        }else{
            return redirect()->route('user.index');
        }
    }
}
