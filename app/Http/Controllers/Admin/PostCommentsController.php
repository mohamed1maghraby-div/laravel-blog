<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Traits\Admin\FiltersTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Cache;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class PostCommentsController extends Controller
{
    use FiltersTrait;

    public function index()
    {
        if(!\auth()->user()->ability('admin', 'manage_post_comments,show_post_comments')){
            return redirect('admin/index');
        }

        $this->setFilters(request()->keyword, request()->status, request()->sort_by, request()->order_by, request()->limit_by);
        $comments = Comment::query();
        if($this->getKeyword() != null){
            $comments = $comments->search($this->getKeyword());
        }

        if($this->FiltersPostId(request()->post_id) != null){
            $comments = $comments->wherePostId($this->FiltersPostId(request()->post_id));
        }

        if($this->getStatus() != null){
            $comments = $comments->whereStatus($this->getStatus());
        }

        $comments = $comments->orderBy($this->getSortBy(), $this->getOrderBy())->paginate($this->getLimitBy());
        $posts = Post::post()->pluck('title', 'id');
        return view('admin.post_comments.index', compact('posts', 'comments'));
    }

    public function edit($id)
    {
        if(!\auth()->user()->ability('admin', 'update_post_comments')){
            return redirect('admin/index');
        }
        $comment = Comment::whereId($id)->first();
        return view('admin.post_comments.edit', compact('comment'));
    }

    public function update(CommentRequest $request, $id)
    {
        if(!\auth()->user()->ability('admin', 'update_post_comments')){
            return redirect('admin/index');
        }
        
        $comment = Comment::whereId($id)->first();

        if($comment){

            $comment->update($request->validated());

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
