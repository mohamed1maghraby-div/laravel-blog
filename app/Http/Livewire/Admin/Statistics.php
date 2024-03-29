<?php

namespace App\Http\Livewire\Admin;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Livewire\Component;

class Statistics extends Component
{
    public function render()
    {
        $all_users = User::whereHas('roles', function($query){
            $query->where('name', 'user');
        })->whereStatus(1)->count();

        $active_posts = Post::whereStatus(1)->post()->count();
        $inactive_posts = Post::whereStatus(0)->post()->count();
        $active_comments = Comment::whereStatus(1)->count();

        return view('livewire.admin.statistics', compact('all_users', 'active_posts', 'inactive_posts', 'active_comments'));
    }
}
