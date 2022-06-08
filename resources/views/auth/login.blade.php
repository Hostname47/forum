@extends('layouts.app')

@section('header')
    @include('partials.header')
@endsection

@push('styles')
    <link href="{{ asset('css/auth/login.css') }}" rel="stylesheet">
@endpush

@section('content')
<div id="login-section" class="full-center">
    <div id="auth-viewer-box" class="viewer-box-style-1">
        @include('partials.auth.login-form')
    </div>
</div>
@endsection
