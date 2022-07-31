<?php

namespace App\Http\Livewire\Admin;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;

class LastPostComments extends Component
{
    public function render()
    {
        $posts = Post::post()->withCount('comments')->orderBy('id', 'desc')->take(5)->get();
        $comments = Comment::orderBy('id', 'desc')->take(5)->get();
        return view('livewire.admin.last-post-comments',compact('posts', 'comments'));
    }
}
