@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-fileinput/css/fileinput.min.css') }}" media="all" type="text/css">
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
@endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Create supervisors</h6>
        <div class="ml-auto">
            <a class="btn btn-primary" href="{{ route('admin.supervisors.index') }}">
                <span class="icon text-white-50">
                    <i class="fa fa-home"></i>
                </span>
                <span class="text">Supervisors</span>
            </a>
        </div>
    </div>
</div>
<div class="card-body">
    {!! Form::open(['route' => 'admin.supervisors.store' , 'method' => 'post', 'files' => true]) !!}
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                {!! Form::label('name', 'Name') !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
                {!! Form::label('username', 'Username') !!}
                {!! Form::text('username', old('username'), ['class' => 'form-control']) !!}
                @error('username') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
                {!! Form::label('email', 'Email') !!}
                {!! Form::email('email', old('email'), ['class' => 'form-control']) !!}
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
                {!! Form::label('mobile', 'Mobile') !!}
                {!! Form::text('mobile', old('mobile'), ['class' => 'form-control']) !!}
                @error('mobile') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-3">
            <div class="form-group">
                {!! Form::label('password', 'Password') !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                {!! Form::label('status', 'status') !!}
                {!! Form::select('status', ['' => '---', '1' => 'Active', '0' => 'Inactive'], old('status'), ['class' => 'form-control']) !!}
                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                {!! Form::label('receive_email', 'Receive email') !!}
                {!! Form::select('receive_email', ['' => '---', '1' => 'Yes', '0' => 'No'], old('receive_email'), ['class' => 'form-control']) !!}
                @error('receive_email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {!! Form::label('bio', 'Bio') !!}
                {!! Form::textarea('bio', old('bio'), ['class' => 'form-control']) !!}
                @error('bio') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {!! Form::label('permissions', 'Permissions') !!}
                {!! Form::select('permissions[]', [] + $permissions->toArray(), old('permissions'), ['class' => 'form-control select-multiple-tage', 'multiple' => 'multiple']) !!}
                @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <div class="row pt-4">
        <div class="col-12">
            {!! Form::label('user_image', 'User Image') !!}
            <br/>
            <div class="file-loading">
                {!! Form::file('user_image', ['id' => 'user-image', 'class' => 'file-input-overview' ]) !!}
                <span class="form-text text-muted">Image width should be 300px x 300px</span>
                @error('user_image') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group pt-4">
            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection
@section('script')
<script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/buffer.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/filetype.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/piexif.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function(){
        $('.select-multiple-tage').select2({
            minimumResultsForSearch: Infinity,
            tags: true,
            closeInSelect: false
        });
        $('#user-image').fileinput({
                theme: "fas",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false
            });
    });
</script>
@endsection