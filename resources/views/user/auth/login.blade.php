@extends('layouts.app')

@section('content')
<section class="module bg-dark-30" data-background="{{ asset('user/assets/images/section-4.jpg') }}">
    <div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
        <h1 class="module-title font-alt mb-0">Login</h1>
        </div>
    </div>
    </div>
</section>
<section class="module">
    <div class="container">
    <div class="row">
        <div class="col-sm-5 col-sm-offset-4 mb-sm-40">
        <h4 class="font-alt">Login</h4>
        <hr class="divider-w mb-10">
        {!! Form::open(['route' => 'login', 'method' => 'post', 'class' => 'form']) !!}
            <div class="form-group">
            {!! Form::text('username', old('username'), ['class' => 'form-control', 'id' => 'username','placeholder' => 'Username']) !!}
            @error('username') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
            {!! Form::password('password', ['id' => 'password', 'class' => 'form-control', 'placeholder' => 'Password']) !!}
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">Remember Me</label>
            </div>
            <div class="form-group">
            {!! Form::button('Login', ['type' => 'submit', 'class' => 'btn btn-round btn-b']) !!}
            </div>
            <div class="form-group"><a href="{{ route('password.request') }}">Forgot Password?</a></div>
        {!! Form::close() !!}
        </div>
    </div>
    </div>
</section>
@endsection
