@extends('layouts.admin')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Create category</h6>
        <div class="ml-auto">
            <a class="btn btn-primary" href="{{ route('admin.post_categories.index') }}">
                <span class="icon text-white-50">
                    <i class="fa fa-home"></i>
                </span>
                <span class="text">Categories</span>
            </a>
        </div>
    </div>
</div>
<div class="card-body">
    <h3>Edit category</h3>
    {!! Form::model($category, ['route' => ['admin.post_categories.update', $category->id] , 'method' => 'patch']) !!}
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {!! Form::label('name', 'Name') !!}
                {!! Form::text('name', old('name', $category->name), ['class' => 'form-control']) !!}
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="form-group">
                {!! Form::label('status', 'Status') !!}
                {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], old('status', $category->status), ['class' => 'form-control']) !!}
                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group pt-4">
            {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection