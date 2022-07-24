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
                                <th>Name</th>
                                <th>post</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($comments as $comment)
                                <tr>
                                    <td>{{ $comment->name }}</td>
                                    <td>{{ $comment->post->title }}</td>
                                    <td>{{ $comment->status }}</td>
                                    <td>
                                        <a href="{{ route('user.comment.edit', $comment->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0);" onclick="if(confirm('Are you sure to delete this comment?')){ document.getElementById('comment-delete-{{ $comment->id }}').submit(); }else{return false;}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                        <form action="{{ route('user.comment.destroy', $comment->id) }}" method="post" id="comment-delete-{{ $comment->id }}" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No post comment</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">{!! $comments->links() !!}</td>
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
