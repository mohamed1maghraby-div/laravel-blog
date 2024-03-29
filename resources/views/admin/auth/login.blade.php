@extends('layouts.admin-auth')
@section('content')
<div class="bg-gradient-primary" style="height: 100vh;">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    {!! Form::open(['route' => 'admin.submitLogin', 'method' => 'post', 'class' => 'user']) !!}
                                        <div class="form-group">
                                            {!! Form::text('username', old('username'), ['aria-describedby' => 'emailHelp', 'id' => 'exampleInputEmail', 'class' => 'form-control form-control-user', 'placeholder' => 'Enter Email Address...']) !!}
                                            @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group">
                                            {!! Form::password('password', ['id' => 'exampleInputPassword', 'placeholder' => 'Password','class' => 'form-control form-control-user']) !!}
                                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="remember">Remember Me</label>
                                            </div>
                                        </div>
                                        {!! Form::button('Login', ['type' => 'submit', 'class' => 'btn btn-primary btn-user btn-block']) !!}
                                        <hr>
                                    {!! Form::close() !!}
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('admin.password.request') }}">Forgot Password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
