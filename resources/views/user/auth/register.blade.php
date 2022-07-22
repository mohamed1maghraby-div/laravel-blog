@extends('layouts.app')

@section('content')
<section class="module bg-dark-30" data-background="{{ asset('user/assets/images/section-4.jpg') }}">
          <div class="container">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <h1 class="module-title font-alt mb-0">Register</h1>
              </div>
            </div>
          </div>
        </section>
        <section class="module">
          <div class="container">
            <div class="row">
              <div class="col-sm-5 col-sm-offset-4 mb-sm-40">
                <h4 class="font-alt">Register</h4>
                <hr class="divider-w mb-10">
                {!! Form::open(['route' => 'register', 'method' => 'post', 'class' => 'form', 'files' => 'true']) !!}
                  <div class="form-group">
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Email *']) !!}
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                  </div>
                  <div class="form-group">
                    {!! Form::text('username', old('username'), ['class' => 'form-control', 'id' => 'username', 'placeholder' => 'Username *']) !!}
                    @error('username')<span class="text-danger">{{ $message }}</span>@enderror
                  </div>
                  <div class="form-group">
                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'E-mail *']) !!}
                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                  </div>
                  <div class="form-group">
                    {!! Form::text('mobile', old('mobile'), ['class' => 'form-control', 'id' => 'mobile', 'placeholder' => 'Mobile']) !!}
                    @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                  </div>
                  <div class="form-group">
                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation', 'placeholder' => 'Re-Password *']) !!}
                    @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
                  </div>
                  <div class="form-group">
                    {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => 'Password *']) !!}
                    @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                  </div>
                  <div class="form-group">
                    {!! Form::file('user_image', ['class' => 'form-control', 'id' => 'user_image']) !!}
                    @error('user_image')<span class="text-danger">{{ $message }}</span>@enderror
                  </div>
                  <div class="form-group">
                    {!! Form::button('Register', ['type' => 'submit', 'class' => 'btn btn-block btn-round btn-b']) !!}
                  </div>
                  <div class="form-group"><a href="{{ route('login') }}">Login?</a></div>
                </form>
              </div>
            </div>
          </div>
        </section>
@endsection
