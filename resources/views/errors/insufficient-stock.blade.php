@extends('layouts.app')

@section('title', 'Insufficient Stock')

@section('content')
    <div class="container">
        <div class="error-page">
            <div class="error-icon warning">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h1>Insufficient Stock</h1>
            <h2>We do not have enough parts available</h2>
            <p>{{ $message ?? 'Sorry, but we do not have the requested quantity in stock for this part.' }}</p>
            <div class="error-actions">
                <a href="javascript:history.back()" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Try Again
                </a>
                <a href="{{ route('parts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-shopping-bag"></i> Explore other parts
                </a>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/errors/insufficient_stock.css') }}">
    @endpush
@endsection