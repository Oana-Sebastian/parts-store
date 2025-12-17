@extends('layouts.app')

@section('title', 'Page not found')

@section('content')
<div class="container">
    <div class="error-page">
        <div class="error-icon">
            <i class="fas fa-map-signs"></i>
        </div>
        <h1>404</h1>
        <h2>Page not found</h2>
        <p>Sorry, but the page you are looking for does not exist.</p>
        <div class="error-actions">
            <a href="{{ route('parts.index') }}" class="btn btn-primary">
                <i class="fas fa-home"></i> Home
            </a>
        </div>
    </div>
</div>
@endsection