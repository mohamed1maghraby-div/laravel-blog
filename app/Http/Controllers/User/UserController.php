<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
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

        if($image = $request->file('user_image')){
            if(auth()->user()->user_image != ''){
                if(File::exists('/assets/users/' . auth()->user()->user_image)){
                    unlink('/assets/users/' . auth()->user()->user_image);
                }
            }
            $filename = Str::slug(auth()->user()->username) . '.' . $image->getClientOriginalExtension();
            $path = public_path('assets/users/' . $filename);
            Image::make($image->getRealPath())->resize(300, 300, function($constraint){
                $constraint->aspectRatio();
            })->save($path, 100);
            $data['user_image'] = $filename;
        }
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

    public function store_post(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:50',
            'status' => 'required',
            'comment_able' => 'required',
            'category_id' => 'required'
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }
        $data['title'] = $request->title;
        $data['description'] = Purify::clean($request->description);
        $data['status'] = $request->status;
        $data['comment_able'] = $request->comment_able;
        $data['category_id'] = $request->category_id;

        $post = auth()->user()->posts()->create($data);

        if($request->images && count($request->images) > 0){
            $i = 1;
            foreach($request->images as $file){
                $filename = $post->slug . '-' . time() . '-' . $i . $file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_type = $file->getMimeType();
                $path = public_path('assets/posts/' . $filename);
                Image::make($file->getRealPath())->resize(800, null, function($constraint){
                    $constraint->aspectRatio();
                })->save($path, 100);
                $post->media()->create([
                    'file_name' => $filename,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                ]);
                $i++;
            }
        }
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

    public function update_post(Request $request, $post_id)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:50',
            'status' => 'required',
            'comment_able' => 'required',
            'category_id' => 'required'
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }
        $post = Post::whereSlug($post_id)->orWhere('id', $post_id)->whereUserId(auth()->id())->first();

        if($post){
            $data['title'] = $request->title;
            $data['description'] = Purify::clean($request->description);
            $data['status'] = $request->status;
            $data['comment_able'] = $request->comment_able;
            $data['category_id'] = $request->category_id;

            $post = auth()->user()->posts()->create($data);

            if($request->images && count($request->images) > 0){
                $i = 1;
                foreach($request->images as $file){
                    $filename = $post->slug . '-' . time() . '-' . $i . $file->getClientOriginalExtension();
                    $file_size = $file->getSize();
                    $file_type = $file->getMimeType();
                    $path = public_path('assets/posts/' . $filename);
                    Image::make($file->getRealPath())->resize(800, null, function($constraint){
                        $constraint->aspectRatio();
                    })->save($path, 100);

                    $post->media()->create([
                        'file_name' => $filename,
                        'file_size' => $file_size,
                        'file_type' => $file_type,
                    ]);
                    $i++;
                }
            }
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
        $media = PostMedia::whereId($media_id)->first();
        if($media){
            if(File::exists('assets/posts/' . $media->file_name)){
                unlink('assets/posts/' . $media->file_name);
            }
            $media->delete();
            return true;
        }
        return false;
    }

    public function destroy_post(Request $request, $post_id)
    {
        $post = Post::whereSlug($post_id)->orWhere('id', $post_id)->whereUserId(auth()->id())->first();

        if($post){
            if($post->media->count() > 0){
                foreach($post->media as $media){
                    if(File::exists('assets/posts/' . $media->file_name)){
                        unlink('assets/posts/' . $media->file_name);
                    }
                }
            }

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

    public function update_comment(Request $request, $comment_id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'url' => 'required|url',
            'status' => 'required',
            'comment' => 'required'
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }
        $comment = Comment::whereId($comment_id)->whereHas('post', function($query){
            $query->where('posts.user_id', auth()->id());
        })->first();

        if($comment){
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['url'] = $request->url != '' ? $request->url : null;
            $data['status'] = $request->status;
            $data['comment'] = Purify::clean($request->comment);

            $comment->update($data);

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