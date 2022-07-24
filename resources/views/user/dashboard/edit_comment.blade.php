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
                <h3>Edit Comment on: ({{ $comment->post->title }})</h3>
                {!! Form::model(['route' => ['user.comment.update', $comment->id] , 'method' => 'post']) !!}
                @method('put')
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::text('name', old('name', $comment->name), ['class' => 'form-control']) !!}
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            {!! Form::label('email', 'Email') !!}
                            {!! Form::email('email', old('email', $comment->email), ['class' => 'form-control']) !!}
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            {!! Form::label('url', 'Website') !!}
                            {!! Form::text('url', old('url', $comment->url), ['class' => 'form-control']) !!}
                            @error('url') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            {!! Form::label('status', 'Status') !!}
                            {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], old('status', $comment->status), ['class' => 'form-control']) !!}
                            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            {!! Form::label('comment', 'Description') !!}
                            {!! Form::textarea('comment', old('comment', $comment->comment), ['class' => 'form-control summernote']) !!}
                            @error('comment') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            {!! Form::submit('Submit', ['class' => 'btn btn-block btn-round btn-d mt-20']) !!}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                @include('partial.user.dashboard.sidebar')
            </div>
          </div>
        </div>
    </section>
@endsection