@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-fileinput/css/fileinput.min.css') }}" media="all" type="text/css">
@endsection
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
                <h3>Edit Post {{ $post->title }}</h3>
                {!! Form::model(['route' => ['user.post.update', $post->id] , 'method' => 'put', 'files' => true]) !!}
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            {!! Form::label('title', 'Title') !!}
                            {!! Form::text('title', old('title', $post->title), ['class' => 'form-control']) !!}
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            {!! Form::label('description', 'Description') !!}
                            {!! Form::textarea('description', old('description', $post->description), ['class' => 'form-control summernote']) !!}
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            {!! Form::label('category_id', 'Category id') !!}
                            {!! Form::select('category_id', ['' => '---'] + $categories->toArray(), old('category_id', $post->category_id), ['class' => 'form-control']) !!}
                            @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            {!! Form::label('comment_able', 'Commentable') !!}
                            {!! Form::select('comment_able', ['1' => 'Yes', '0' => 'No'], old('comment_able', $post->comment_able), ['class' => 'form-control']) !!}
                            @error('comment_able') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            {!! Form::label('status', 'Status') !!}
                            {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], old('status', $post->status), ['class' => 'form-control']) !!}
                            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-12">
                        <div class="form-group file-loading">
                            {!! Form::file('images[]', ['id' => 'post-images', 'multiple' => 'multiple']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            {!! Form::submit('Publish', ['class' => 'btn btn-block btn-round btn-d mt-20']) !!}
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
@section('script')
<script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script>

<script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/buffer.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/filetype.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/piexif.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>

<script>
    $(function(){
        $('.summernote').summernote({
            tabsize: 2,
            height: 200,
            toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
        $('#post-images').fileinput({
                theme: "fa",
                maxFileCount: 5,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if($post->media->count() > 0)
                        @foreach($post->media as $media)
                            "{{ asset('assets/posts/' . $media->file_name) }}",
                        @endforeach
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if($post->media->count() > 0)
                        @foreach($post->media as $media)
                            {caption: "{{ $media->file_name }}", size: {{ $media->file_size }}, width: "120px", url: "{{ route('user.post.media.destroy', [$media->id, '_token' => csrf_token()]) }}", key: "{{ $media->id }}"},
                        @endforeach
                    @endif
                ],
            })
        
    });
</script>
@endsection