@extends('layouts.app')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))

@section('content')
    <section class="home-section home-parallax home-fade home-full-height bg-dark bg-dark-30" id="home" data-background="{{ asset('user/assets/images/section-4.jpg') }}">
        <div class="titan-caption">
        <div class="caption-content">
            <div class="font-alt mb-30 titan-title-size-4">Error 404</div>
            <div class="font-alt">The requested URL was not found on this server.<br/>That is all we know.
            </div>
            <div class="font-alt mt-30"><a class="btn btn-border-w btn-round" href="index.html">Back to home page</a></div>
        </div>
        </div>
    </section>
@endsection
