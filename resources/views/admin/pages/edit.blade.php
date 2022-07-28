@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-fileinput/css/fileinput.min.css') }}" media="all" type="text/css">
@endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Create Page</h6>
        <div class="ml-auto">
            <a class="btn btn-primary" href="{{ route('admin.pages.index') }}">
                <span class="icon text-white-50">
                    <i class="fa fa-home"></i>
                </span>
                <span class="text">Pages</span>
            </a>
        </div>
    </div>
</div>
<div class="card-body">
    <h3>Create Page</h3>
    {!! Form::model($page, ['route' => ['admin.pages.update', $page->id] , 'method' => 'patch', 'files' => true]) !!}
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {!! Form::label('title', 'Title') !!}
                {!! Form::text('title', old('title', $page->title), ['class' => 'form-control']) !!}
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {!! Form::label('description', 'Description') !!}
                {!! Form::textarea('description', old('description', $page->description), ['class' => 'form-control summernote']) !!}
                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="form-group">
                {!! Form::label('category_id', 'Category id') !!}
                {!! Form::select('category_id', ['' => '---'] + $categories->toArray(), old('category_id', $page->category_id), ['class' => 'form-control']) !!}
                @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="form-group">
                {!! Form::label('status', 'Status') !!}
                {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], old('status', $page->status), ['class' => 'form-control']) !!}
                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="row pt-4">
        <div class="col-12">
            <div class="form-group file-loading">
                {!! Form::file('images[]', ['id' => 'page-images', 'multiple' => 'multiple']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group pt-4">
            {!! Form::submit('Publish', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
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
        $('#page-images').fileinput({
                theme: "fa",
                maxFileCount: 5,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if($page->media->count() > 0)
                        @foreach($page->media as $media)
                            "{{ asset('assets/posts/' . $media->file_name) }}",
                        @endforeach
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if($page->media->count() > 0)
                        @foreach($page->media as $media)
                            {caption: "{{ $media->file_name }}", size: {{ $media->file_size }}, width: "120px", url: "{{ route('admin.pages.media.destroy', [$media->id, '_token' => csrf_token()]) }}", key: "{{ $media->id }}"},
                        @endforeach
                    @endif
                ],
            })
        
    });
</script>
@endsection