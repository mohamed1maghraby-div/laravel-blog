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
            <div class="col-lg-9 col-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Comments</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td><a href="{{ route('user.comments', ['post' => $post->id]) }}">{{ $post->comments_count }}</a></td>
                                    <td>{{ $post->status }}</td>
                                    <td>
                                        <a href="{{ route('user.post.edit', $post->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0);" onclick="if(confirm('Are you sure to delete this post?')){ document.getElementById('post-delete-{{ $post->id }}').submit(); }else{return false;}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                        <form action="{{ route('user.post.destroy', $post->id) }}" method="post" id="post-delete-{{ $post->id }}" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No post found</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">{!! $posts->links() !!}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                @include('partial.user.dashboard.sidebar')
            </div>
          </div>
        </div>
    </section>
@endsection
