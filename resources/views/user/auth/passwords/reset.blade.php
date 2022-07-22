@extends('layouts.app')

@section('content')
<section class="module bg-dark-30" data-background="{{ asset('user/assets/images/section-4.jpg') }}">
    <div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
        <h1 class="module-title font-alt mb-0">Reset Password</h1>
        </div>
    </div>
    </div>
</section>
<section class="module">
    <div class="container">
    <div class="row">
        <div class="col-sm-5 col-sm-offset-4 mb-sm-40">
        <h4 class="font-alt">Reset Password</h4>
        <hr class="divider-w mb-10">
        {!! Form::open(['route' => 'password.update', 'method' => 'post', 'class' => 'form']) !!}
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                {!! Form::label('email', 'Email Address', ['class' => 'col-md-4 col-form-label text-md-end']) !!}
                {!! Form::email('email', old('email'), ['class' => 'form-control', 'id' => 'email','placeholder' => 'Your E-mail']) !!}
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                {!! Form::label('password', 'Password *', ['class' => 'col-md-4 col-form-label text-md-end']) !!}
                {!! Form::password('password', ['class' => 'form-control', 'id' => 'password','placeholder' => 'Password *']) !!}
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                {!! Form::label('password_confirmation', 'Re-Password *', ['class' => 'col-md-4 col-form-label text-md-end']) !!}
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation','placeholder' => 'Re-Password *']) !!}
                @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
            {!! Form::button('Reset Password', ['type' => 'submit', 'class' => 'btn btn-round btn-b']) !!}
            </div>
        {!! Form::close() !!}
        </div>
    </div>
    </div>
</section>


{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
