<?php

namespace App\Http\Controllers\User;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ImagesManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ImagesManagerTrait;

    public function index()
    {
        $posts = auth()->user()->posts()->with(['media', 'category', 'user'])->withCount('comments')->orderBy('id', 'desc')->paginate(10);
        return view('user.dashboard.dashboard', compact('posts'));
    }
    
    public function edit_info()
    {
        return view('user.dashboard.edit_info');
    }

    public function update_info(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'bio' => 'required|min:10',
            'receive_email' => 'required',
            'user_image' => 'nullable|image|max:20000|mimes:jpeg,jpg,png',
        ]);
        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['mobile'] = $request->mobile;
        $data['bio'] = Purify::clean($request->bio);
        $data['receive_email'] = $request->receive_email;
        $data['user_image'] = $this->UserImageUploade($request->file('user_image'), auth()->user()->user_image, auth()->user()->username);

        $update = auth()->user()->update($data);
        if($update){
            return redirect()->back()->with([
                'message' => 'Information updated successfully',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    public function update_password(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);
        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }
        $user = auth()->user();

        if(Hash::check($request->current_password, $user->password)){
            $update = $user->update([
                'password' => bcrypt($request->password)
            ]);
            if($update){
                return redirect()->back()->with([
                    'message' => 'Password updated successfully',
                    'alert-type' => 'success'
                ]);
            }else{
                return redirect()->back()->with([
                    'message' => 'Something was wrong',
                    'alert-type' => 'danger'
                ]);
            }
        }else{
            return redirect()->back()->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger'
            ]);
        }
    }

    public function create_post()
    {
        $categories = Category::whereStatus(1)->pluck('name', 'id');
        return view('user.dashboard.create_post', compact('categories'));
    }

    public function store_post(PostRequest $request)
    {
        $post = auth()->user()->posts()->create($request->validated());

        $this->PostImagesUploade($request->images, $post);

        if($request->status == 1){
            Cache::forget('recent_posts');
        }
        return redirect()->back()->with([
            'message' => 'Post created successfully',
            'alert-type' => 'success'
        ]);
    }
    public function edit_post($post_id)
    {
        $post = Post::whereSlug($post_id)->orWhere('id', $post_id)->whereUserId(auth()->id())->first();
        if($post){
            $categories = Category::whereStatus(1)->pluck('name', 'id');
            return view('user.dashboard.edit_post', compact('categories', 'post'));
        }
        return redirect()->route('user.index');
    }

    public function update_post(PostRequest $request, $post_id)
    {
        $post = Post::whereSlug($post_id)->orWhere('id', $post_id)->whereUserId(auth()->id())->first();
        if($post){
            $post->update($request->validated());
            $this->PostImagesUploade($request->images, $post);
            
            if($request->status == 1){
                Cache::forget('recent_posts');
            }
            return redirect()->back()->with([
                'message' => 'Post updated successfully',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    public function destroy_post_media($media_id)
    {
        return $this->destroyPostImage($media_id);
    }

    public function destroy_post(Request $request, $post_id)
    {
        $post = Post::whereSlug($post_id)->orWhere('id', $post_id)->whereUserId(auth()->id())->first();

        if($post){
            $this->destroyPostMedia($post);
            $post->delete();

            return redirect()->back()->with([
                'message' => 'Post deleted successfully',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    public function show_comments(Request $request)
    {
        $comments = Comment::query();

        if(isset($request->post) && $request->post != ''){
            $comments = $comments->wherePostId($request->post);
        }else{

            $posts_id = auth()->user()->posts()->pluck('id')->toArray();
            $comments = $comments->whereIn('post_id', $posts_id);
        }
        $comments = $comments->orderBy('id', 'desc')->paginate(10);
        return view('user.dashboard.comments', compact('comments'));
    }

    public function edit_comment($comment_id)
    {
        $comment = Comment::whereId($comment_id)->whereHas('post', function($query){
            $query->where('posts.user_id', auth()->id());
        })->first();
        if($comment){
            return view('user.dashboard.edit_comment', compact('comment'));
        }else{
            return redirect()->back()->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger'
            ]);
        }
    }

    public function update_comment(CommentRequest $request, $comment_id)
    {
        $comment = Comment::whereId($comment_id)->whereHas('post', function($query){
            $query->where('posts.user_id', auth()->id());
        })->first();

        if($comment){
            $comment->update($request->validated());
            
            if($request->status == 1){
                Cache::forget('recent_comments');
            }

            return redirect()->back()->with([
                'message' => 'Comment updated successfully',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    public function destroy_comment(Request $request, $comment_id){
        $comment = Comment::whereId($comment_id)->whereHas('post', function($query){
            $query->where('posts.user_id', auth()->id());
        })->first();

        if($comment){
            $comment->delete();

            Cache::forget('recent_comments');

            return redirect()->back()->with([
                'message' => 'Comment deleted successfully',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }
}
