
<div class="widget">
    {!! Form::open(['route' => 'user.search', 'method' => 'get']) !!}
    <div class="search-box">
        {!! Form::text('keyword', old('keyword', request()->keyword), ['class' => 'form-control', 'placeholder' => 'Search...']) !!}
        {!! Form::button('<i class="fa fa-search"></i>', ['type' => 'submit', 'class' => 'search-btn']) !!}
    </div>
    {!! Form::close() !!}
</div>
<div class="widget">
    <h5 class="widget-title font-alt">Blog Categories</h5>
    <ul class="icon-list">
        @foreach ($global_categories as $global_category)
            <li><a href="#">{{ $global_category->name }}</a></li>
        @endforeach
    </ul>
</div>
<div class="widget">
    <h5 class="widget-title font-alt">Recent Posts</h5>
    <ul class="widget-posts">
        @foreach ($recent_posts as $recent_post)
            <li class="clearfix">
                <div class="widget-posts-image">
                    <a href="#">
                        @if ($recent_post->media->count() > 0)
                            <img src="{{ asset('assets/posts/' . $recent_post->media->first()->file_name) }}" alt="{{ $recent_post->title }}"/>
                        @else
                            <img src="{{ asset('assets/posts/sidebar-default.jpg') }}" alt="{{ $recent_post->title }}"/>
                        @endif
                    </a>
                </div>
                <div class="widget-posts-body">
                    <div class="widget-posts-title"><a href="{{ route('posts.show', $recent_post->slug) }}">{{ Str::limit($recent_post->title, 24, '...') }}</a></div>
                    <div class="widget-posts-meta">{{ $recent_post->created_at->format('d M') }}</div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
<div class="widget">
    <h5 class="widget-title font-alt">Archives</h5>
    <ul class="icon-list">
        @foreach ($global_archives as $key => $val)
            <li><a href="#">{{ date("F", mktime(0,0,0, $key, 1)) . ' ' . $val }}</a></li>
        @endforeach
    </ul>
</div>
<div class="widget">
    <h5 class="widget-title font-alt">Recent Comments</h5>
    <ul class="widget-posts">
    @foreach ($recent_comments as $recent_comment)
        <li class="clearfix">
                <div class="widget-posts-image">
                    <a href="#">
                            <img src={{ get_gravatar($recent_comment->email, 47) }}" alt="{{ $recent_comment->name }}"/>
                    </a>
                </div>
                <div class="widget-posts-body">
                    <div class="widget-posts-title"><a href="#">{{ $recent_comment->name }} say:</a></div>
                    <div class="widget-posts-meta"><p>{!! Str::limit($recent_comment->comment, 20, '...') !!}</p></div>
                </div>
            </li>
    @endforeach
    </ul>
</div>