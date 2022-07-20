<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Ui\Presets\React;

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

    public function store_comment(Request $request, $slug)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'url' => 'required|url',
            'email' => 'required|email',
            'comment' => 'required|min:10'
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $post = Post::whereSlug($slug)->post()->active()->first();

        if($post){

            $userId = auth()->check() ? auth()->id() : null;
            $data['name'] = $request->name;
            $data['url'] = $request->url;
            $data['email'] = $request->email;
            $data['ip_address'] = $request->ip();
            $data['comment'] = $request->comment;
            $data['post_id'] = $post->id;
            $data['user_id'] = $userId;

            $comment = $post->comments()->create($data);

            return redirect()->back()->with([
                'message' => 'Comment added successfully',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

}
