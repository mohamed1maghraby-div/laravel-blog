<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Traits\Admin\FiltersTrait;
use App\Traits\ImagesManagerTrait;
use Illuminate\Support\Facades\Cache;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    use FiltersTrait, ImagesManagerTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!\auth()->user()->ability('admin', 'manage_posts,show_posts')){
            return redirect('admin/index');
        }
        
        $this->setFilters(request()->keyword, request()->status, request()->sort_by, request()->order_by, request()->limit_by);
        $posts = Post::with(['user', 'category', 'comments'])->post();

        if($this->getKeyword() != null){
            $posts = $posts->search($this->getKeyword());
        }

        if($this->FiltersCategoryId(request()->category_id) != null){
            $posts = $posts->whereCategoryId($this->FiltersCategoryId(request()->category_id));
        }
        if($this->getStatus() != null){
            $posts = $posts->whereStatus($this->getStatus());
        }

        $posts = $posts->orderBy($this->getSortBy(), $this->getOrderBy())->paginate($this->getLimitBy());
        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!\auth()->user()->ability('admin', 'create_posts')){
            return redirect('admin/index');
        }

        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        if(!\auth()->user()->ability('admin', 'create_posts')){
            return redirect('admin/index');
        }

        $post = auth()->user()->posts()->create($request->validated());
        $this->PostImagesUploade($request->images, $post);

        if($request->status == 1){
            Cache::forget('recent_posts');
        }
        return redirect()->route('admin.posts.index')->with([
            'message' => 'Post created successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!\auth()->user()->ability('admin', 'display_posts')){
            return redirect('admin/index');
        }

        $post = Post::with(['media', 'category','user', 'comments'])->whereId($id)->post()->first();
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!\auth()->user()->ability('admin', 'update_posts')){
            return redirect('admin/index');
        }
        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');
        $post = Post::with(['media', 'category','user', 'comments'])->whereId($id)->post()->first();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        if(!\auth()->user()->ability('admin', 'update_posts')){
            return redirect('admin/index');
        }
        $post = Post::whereId($id)->post()->first();

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

    public function removeImage($media_id)
    {
        if(!\auth()->user()->ability('admin', 'delete_posts')){
            return redirect('admin/index');
        }

        return $this->destroyPostImage($media_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!\auth()->user()->ability('admin', 'delete_posts')){
            return redirect('admin/index');
        }

        $post = Post::whereId($id)->post()->first();

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
}
