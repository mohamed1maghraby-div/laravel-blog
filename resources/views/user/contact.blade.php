@extends('layouts.app')
@section('content')
        <section class="module" id="contact">
          <div class="container">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <h2 class="module-title font-alt">Contact us</h2>
                <div class="module-subtitle font-serif"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-8">
                {!! Form::open(['route' => 'user.do_contact', 'method' => 'post',  'role' => 'form']) !!}
                
                  <div class="form-group">
                    {!! Form::label('name', 'Name', ['class' => 'sr-only']) !!}
                    {!! Form::text('name', old('name'), ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Your Name*']) !!}
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                  </div>
                  <div class="form-group">
                    {!! Form::label('email', 'Email', ['class' => 'sr-only']) !!}
                    {!! Form::email('email', old('email'), ['id' => 'email', 'class' => 'form-control', 'placeholder' => 'Your Email*']) !!}
                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                  </div>
                  <div class="form-group">
                    {!! Form::label('mobile', 'Mobile', ['class' => 'sr-only']) !!}
                    {!! Form::text('mobile', old('mobile'), ['id' => 'mobile', 'class' => 'form-control', 'placeholder' => 'Your Mobile*']) !!}
                    @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                  </div>
                  <div class="form-group">
                    {!! Form::label('title', 'Title', ['class' => 'sr-only']) !!}
                    {!! Form::text('title', old('title'), ['id' => 'title', 'class' => 'form-control', 'placeholder' => 'Your Subject*']) !!}
                    @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                  </div>
                  <div class="form-group">
                    {!! Form::label('message', 'Message', ['class' => 'sr-only']) !!}
                    {!! Form::textarea('message', old('message'), ['class' => 'form-control','id' => 'message', 'placeholder' => 'Your Message', 'rows' => '7']) !!}
                    @error('message')<span class="text-danger">{{ $message }}</span>@enderror
                  </div>
                  <div class="text-center">
                    {!! Form::button('Submit', ['class' => 'btn btn-block btn-round btn-d','id' => 'cfsubmit','type' => 'submit']) !!}
                  </div>
                {!! Form::close() !!}
              </div>
              <div class="col-sm-4">
                <div class="alt-features-item mt-0">
                  <div class="alt-features-icon"><span class="icon-megaphone"></span></div>
                  <h3 class="alt-features-title font-alt">Where to meet</h3>Titan Company<br/>23 Greate Street<br/>Los Angeles, 12345 LS
                </div>
                <div class="alt-features-item mt-xs-60">
                  <div class="alt-features-icon"><span class="icon-map"></span></div>
                  <h3 class="alt-features-title font-alt">Say Hello</h3>Email: somecompany@example.com<br/>Phone: +1 234 567 89 10
                </div>
              </div>
            </div>
          </div>
        </section>
@endsection
