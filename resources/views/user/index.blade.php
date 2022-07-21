@extends('layouts.app')

@section('content')
        <section class="module bg-dark-60 blog-page-header" data-background="{{ asset('user/assets/images/blog_bg.jpg') }}">
          <div class="container">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <h2 class="module-title font-alt">Blog Standard</h2>
                <div class="module-subtitle font-serif">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</div>
              </div>
            </div>
          </div>
        </section>
        <section class="module">
          <div class="container">
            <div class="row">
              <div class="col-sm-8">
                @forelse ($posts as $post)
                  <div class="post">
                    <div class="post-thumbnail">
                      <a href="{{ route('posts.show', $post->slug) }}">
                      @if ($post->media->count() > 0)
                        <img src="{{ asset('assets/posts/' . $post->media->first()->file_name) }}" alt="{{ $post->title }} Thumbnail"/>
                        @else
                        <img src="{{ asset('assets/posts/default.jpg') }}" alt="Blog-post Thumbnail"/>
                      @endif
                      </a>
                    </div>
                    <div class="post-header font-alt">
                      <h2 class="post-title"><a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a></h2>
                      <div class="post-meta">By&nbsp;<a href="{{ route('user.author', $post->user->username) }}">{{ $post->user->username }}</a>| {{ $post->created_at->format('d M') }} | {{ $post->comments->count() }} Comment{{ $post->comments->count() > 0 ? 's' : '' }} | <a href="#">{{ $post->category->name }} </a>
                      </div>
                    </div>
                    <div class="post-entry">
                      <p>{{ Str::limit($post->description, 241, '...') }}</p>
                    </div>
                    <div class="post-more"><a class="more-link" href="{{ route('posts.show', $post->slug) }}">Read more</a></div>
                  </div>
                @empty
                  <p>No posts Found ...</p>
                @endforelse

                {!! $posts->appends(request()->input())->links() !!}

              </div>
              <div class="col-sm-4 col-md-3 col-md-offset-1 sidebar">
                @include('partial.user.sidebar')
              </div>
            </div>
          </div>
        </section>
        <div class="module-small bg-dark">
          <div class="container">
            <div class="row">
              <div class="col-sm-3">
                <div class="widget">
                  <h5 class="widget-title font-alt">About Titan</h5>
                  <p>The languages only differ in their grammar, their pronunciation and their most common words.</p>
                  <p>Phone: +1 234 567 89 10</p>Fax: +1 234 567 89 10
                  <p>Email:<a href="#">somecompany@example.com</a></p>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="widget">
                  <h5 class="widget-title font-alt">Recent Comments</h5>
                  <ul class="icon-list">
                    <li>Maria on <a href="#">Designer Desk Essentials</a></li>
                    <li>John on <a href="#">Realistic Business Card Mockup</a></li>
                    <li>Andy on <a href="#">Eco bag Mockup</a></li>
                    <li>Jack on <a href="#">Bottle Mockup</a></li>
                    <li>Mark on <a href="#">Our trip to the Alps</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="widget">
                  <h5 class="widget-title font-alt">Blog Categories</h5>
                  <ul class="icon-list">
                    <li><a href="#">Photography - 7</a></li>
                    <li><a href="#">Web Design - 3</a></li>
                    <li><a href="#">Illustration - 12</a></li>
                    <li><a href="#">Marketing - 1</a></li>
                    <li><a href="#">Wordpress - 16</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="widget">
                  <h5 class="widget-title font-alt">Popular Posts</h5>
                  <ul class="widget-posts">
                    <li class="clearfix">
                      <div class="widget-posts-image"><a href="#"><img src="{{ asset('user/assets/images/rp-1.jpg') }}" alt="Post Thumbnail"/></a></div>
                      <div class="widget-posts-body">
                        <div class="widget-posts-title"><a href="#">Designer Desk Essentials</a></div>
                        <div class="widget-posts-meta">23 january</div>
                      </div>
                    </li>
                    <li class="clearfix">
                      <div class="widget-posts-image"><a href="#"><img src="{{ asset('user/assets/images/rp-2.jpg') }}" alt="Post Thumbnail"/></a></div>
                      <div class="widget-posts-body">
                        <div class="widget-posts-title"><a href="#">Realistic Business Card Mockup</a></div>
                        <div class="widget-posts-meta">15 February</div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr class="divider-d">
@endsection
