@extends('layouts.app')
@section('content')
<section class="module-small">
          <div class="container">
            <div class="row">
              <div class="col-sm-8">
                <div class="post">
                    <div class="post-thumbnail">
                        <img src="{{ asset('user/assets/images/post-4.jpg') }}" alt="Blog Featured Image"/>
                    </div>
                  <div class="post-header font-alt">
                    <h1 class="post-title">{{ $post->title }}</h1>
                    <div class="post-meta">By&nbsp;<a href="{{ route('user.author', $post->user->username) }}">{{ $post->user->username }}</a>| {{ $post->created_at->format('d M') }} | {{ $post->comments->count() }} Comment{{ $post->comments->count() > 0 ? 's' : '' }} | <a href="{{ route('user.category', $post->category->slug) }}">{{ $post->category->name }} </a>
                    </div>
                  </div>
                  <div class="post-entry">
                    {!! $post->description !!}
                  </div>
                </div>
                <div class="comments">
                  <h4 class="comment-title font-alt">There {{ $post->approved_comments->count() > 1 ? 'are ' . $post->approved_comments->count() . ' comments' : 'is ' . $post->approved_comments->count() . ' comment'}}</h4>
                  @forelse ($post->approved_comments as $comment)
                    <div class="comment clearfix">
                      <div class="comment-avatar">
                        <img src="{{ get_gravatar($comment->email, 46) }}" alt="avatar"/>
                      </div>
                      <div class="comment-content clearfix">
                        <div class="comment-author font-alt"><a href="{{ $comment->url != '' ? $comment->url : '#' }}">{{ $comment->name }}</a></div>
                        <div class="comment-body">
                          <p>{{ $comment->comment }}</p>
                        </div>
                        <div class="comment-meta font-alt"> {{ $comment->created_at->format('M d h:i') }} </div>
                      </div>
                    </div>
                  @empty
                    <p>No comments found</p>
                  @endforelse

                </div>
                <div class="comment-form">
                  <h4 class="comment-form-title font-alt">Add your comment</h4>
                  {!! Form::open(['route' => ['posts.add_comment', $post->slug], 'method' => 'post']) !!}
                    <div class="form-group">
                      {!! Form::label('name', 'Name', ['class' => 'sr-only']) !!}
                      {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name']) !!}
                      @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                      {!! Form::label('email', 'Email', ['class' => 'sr-only']) !!}
                      {!! Form::email('email', old('email'), ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'E-mail']) !!}
                      @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                      {!! Form::label('url', 'Website', ['class' => 'sr-only']) !!}
                      {!! Form::text('url', old('url'), ['class' => 'form-control', 'id' => 'url', 'placeholder' => 'Website']) !!}
                      @error('url')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                      {!! Form::textarea('comment', old('comment'), ['class' => 'form-control','id' => 'comment','placeholder' => 'Comment', 'rows' => 4]) !!}
                    </div>
                    {!! Form::button('Post comment', ['type' => 'submit','class' => 'btn btn-round btn-d']) !!}
                    {!! Form::close() !!}
                </div>
              </div>

              <div class="col-sm-4 col-md-3 col-md-offset-1 sidebar">
                @include('partial.user.sidebar')
              </div>
            </div>
          </div>
        </section>
@endsection