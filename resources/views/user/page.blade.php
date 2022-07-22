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
                    <div class="post-meta">By&nbsp;<a href="{{ route('user.author', $post->user->username) }}">{{ $post->user->username }} </a>| {{ $post->created_at->format('d M') }}</a>
                    </div>
                  </div>
                  <div class="post-entry">
                    {!! $post->description !!}
                  </div>
                </div>
              </div>

              <div class="col-sm-4 col-md-3 col-md-offset-1 sidebar">
                @include('partial.user.sidebar')
              </div>
            </div>
          </div>
        </section>
@endsection