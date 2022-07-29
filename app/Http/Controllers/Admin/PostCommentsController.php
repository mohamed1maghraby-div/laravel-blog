<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class PostCommentsController extends Controller
{
    public function __construct()
    {
        if(\auth()->check()){
            $this->middleware('auth');
        }else{
            return redirect()->route('admin.login');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!\auth()->user()->ability('admin', 'manage_post_comments,show_post_comments')){
            return redirect('admin/index');
        }

        $keyword = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $postId = (isset(\request()->post_id) && \request()->post_id != '') ? \request()->post_id : null;
        $categoryId = (isset(\request()->category_id) && \request()->category_id != '') ? \request()->category_id : null;
        $status = (isset(\request()->status) && \request()->status != '') ? \request()->status : null;
        $sort_by = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'desc';
        $limit_by = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';


        $comments = Comment::query();
        if($keyword != null){
            $comments = $comments->search($keyword);
        }

        if($postId != null){
            $comments = $comments->wherePostId($postId);
        }

        if($status != null){
            $comments = $comments->whereStatus($status);
        }

        $comments = $comments->orderBy($sort_by, $order_by)->paginate($limit_by);
        $posts = Post::post()->pluck('title', 'id');
        return view('admin.post_comments.index', compact('posts', 'comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!\auth()->user()->ability('admin', 'update_post_comments')){
            return redirect('admin/index');
        }
        $comment = Comment::whereId($id)->first();
        return view('admin.post_comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!\auth()->user()->ability('admin', 'update_post_comments')){
            return redirect('admin/index');
        }
        
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'url' => 'required|url',
            'status' => 'required',
            'comment' => 'required',
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }
        $comment = Comment::whereId($id)->first();

        if($comment){
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['url'] = $request->url;
            $data['status'] = $request->status;
            $data['comment'] = Purify::clean($request->comment);

            $comment->update($data);

            Cache::forget('recent_comments');

            return redirect()->route('admin.post_comments.index')->with([
                'message' => 'Comment updated successfully',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!\auth()->user()->ability('admin', 'delete_post_comments')){
            return redirect('admin/index');
        }

        $comment = Comment::whereId($id)->first();
        $comment->delete();

        return redirect()->route('admin.post_comments.index')->with([
            'message' => 'Comment deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
