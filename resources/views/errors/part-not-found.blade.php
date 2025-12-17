@extends('layouts.app')

@section('title', 'Part not found')

@section('content')
    <div class="container">
        <div class="error-page">
            <div class="error-icon">
                <i class="fas fa-search"></i>
            </div>
            <h1>404</h1>
            <h2>Part not found</h2>
            <p>{{ $message ?? 'Sorry, but the part you are looking for does not exist or has been deleted.' }}</p>
            <div class="error-actions">
                <a href="{{ route('parts.index') }}" class="btn btn-primary">
                    <i class="fas fa-home"></i> Back to Store
                </a>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/errors/part_not_found.css') }}">
    @endpush
@endsection