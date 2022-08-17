<?php

namespace App\Http\Controllers\User;

use App\Models\Post;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\User;
use App\Notifications\NewCommentForAdminNotify;
use App\Notifications\NewCommentForPostOwnerNotify;

class IndexController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'category', 'media'])
            ->whereHas('category', function($query){
                $query->whereStatus(1);
            })
            ->whereHas('user', function($query){
                $query->whereStatus(1);
            })
            ->post()->active()->orderBy('id', 'desc')->paginate(5);

        return view('user.index', compact('posts'));
    }

    public function search(Request $request)
    {
        $keyword = isset($request->keyword) && $request->keyword != '' ? $request->keyword : null;

        $posts = Post::with(['user', 'category', 'media'])
            ->whereHas('category', function($query){
                $query->whereStatus(1);
            })
            ->whereHas('user', function($query){
                $query->whereStatus(1);
            });

        if($keyword != null){
            $posts = $posts->search($keyword, null, true);
        }

        $posts = $posts->post()->active()->orderBy('id', 'desc')->paginate(5);

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
            return view('errors.404');
        }
    }

    public function store_comment(CommentRequest $request, $slug)
    {
        $post = Post::whereSlug($slug)->post()->active()->first();
        if($post){
            $comment = $post->comments()->create(array_merge(
                $request->validated(),
                [
                    'post_id' => $post->id,
                    'ip_address' => $request->ip(),
                    'user_id' => auth()->check() ? auth()->id() : null,
                ]
            ));

            if(auth()->guest() || auth()->id() != $post->user_id){
                $post->user->notify(new NewCommentForPostOwnerNotify($comment));
            }

            User::whereHas('roles', function($query){
                $query->whereIn('name', ['admin', 'editor']);
            })->each(function($admin, $key) use($comment){
                $admin->notify(new NewCommentForAdminNotify($comment));
            });

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

    public function category($slug)
    {
        $category = Category::whereSlug($slug)->orWhere('id', $slug)->whereStatus(1)->first();

        if($category){
            $posts = Post::with(['media', 'user'])
                ->whereCategoryId($category->id)
                ->post()->active()->orderBy('id', 'desc')->paginate(5);

            return view('user.index', compact('posts'));
        }
        return redirect()->route('user.index');
    }

    public function archive($date)
    {
        if(str_contains($date, '-')){
            $exploded_date = explode('-', $date);
            $month = $exploded_date[0];
            $year = $exploded_date[1];
            $posts = Post::with(['media', 'user'])->whereMonth('created_at', $month)->whereYear('created_at', $year)
            ->post()->active()->orderBy('id', 'desc')->paginate(5);
    
            return view('user.index', compact('posts'));
        }
        return redirect()->route('user.index');
    }

    public function author($username)
    {
        $user = User::whereUsername($username)->whereStatus(1)->first();

        if($user){
            $posts = Post::with(['media', 'user'])->whereUserId($user->id)->post()->active()->orderBy('id', 'desc')->paginate(5);

            return view('user.index', compact('posts'));
        }
        return redirect()->route('user.index');
    }

    public function contact()
    {
        return view('user.contact');
    }

    public function store_contact(ContactRequest $request)
    {
        Contact::create($request->validated());
        return redirect()->back()->with([
            'message' => 'Message sent successfully',
            'alert-type' => 'sucess'
        ]);
    }
}
