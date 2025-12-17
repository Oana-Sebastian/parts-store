@extends('layouts.app')

@section('title', 'All Parts - AutoParts Store')

@section('content')
    <div class="container">
        <div class="hero-section">
            <div class="carousel-container">
                <div class="carousel-slides" id="heroCarousel">
                    <div class="carousel-slide">
                        <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1200" alt="Auto parts">
                        <div class="carousel-overlay">
                            <h1>Quality Auto Parts</h1>
                            <p>Find the perfect part for your car</p>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=1200" alt="Auto service">
                        <div class="carousel-overlay">
                            <h1>Fast Delivery</h1>
                            <p>Over 1000 parts in stock</p>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=1200" alt="Warranty">
                        <div class="carousel-overlay">
                            <h1>Extended Warranty</h1>
                            <p>All products come with a 2-year warranty</p>
                        </div>
                    </div>
                </div>

                <button class="carousel-btn carousel-btn-prev" onclick="moveCarousel(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="carousel-btn carousel-btn-next" onclick="moveCarousel(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>

                <div class="carousel-indicators">
                    <span class="carousel-indicator active" onclick="goToSlide(0)"></span>
                    <span class="carousel-indicator" onclick="goToSlide(1)"></span>
                    <span class="carousel-indicator" onclick="goToSlide(2)"></span>
                </div>
            </div>
        </div>

        <div class="filters-section">
            <form method="GET" action="{{ route('parts.index') }}" class="filters-form">
                <div class="filter-group">
                    <input type="text" name="search" class="form-control" placeholder="Search for a part..."
                        value="{{ request('search') }}">
                </div>

                <div class="filter-group">
                    <select name="category" class="form-control">
                        <option value="all">All categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>

        <div class="grid">
            @forelse($parts as $part)
                <div class="card part-card">
                    <div class="mini-carousel" data-part-id="{{ $part->id }}">
                        @if($part->images && count($part->images) > 0)
                            @foreach($part->images as $index => $image)
                                <img src="{{ $image }}" alt="{{ $part->name }}"
                                    class="carousel-image {{ $index === 0 ? 'active' : '' }}"
                                    style="display: {{ $index === 0 ? 'block' : 'none' }}">
                            @endforeach

                            @if(count($part->images) > 1)
                                <div class="mini-carousel-dots">
                                    @foreach($part->images as $index => $image)
                                        <span class="mini-carousel-dot {{ $index === 0 ? 'active' : '' }}"
                                            onclick="changeMiniCarousel({{ $part->id }}, {{ $index }})"></span>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=400" alt="No image">
                        @endif
                    </div>

                    <div class="card-body">
                        <h3>{{ $part->name }}</h3>
                        <p class="part-code">Code: <strong>{{ $part->code }}</strong></p>
                        <p class="part-manufacturer">{{ $part->manufacturer }}</p>
                        <p class="part-category">
                            <span class="badge badge-primary">{{ $part->category }}</span>
                        </p>

                        <div class="part-footer">
                            <div class="part-price">
                                <strong>{{ number_format($part->price, 2) }} EUR</strong>
                            </div>
                            <div class="part-stock">
                                @if($part->stock > 10)
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i> In stock
                                    </span>
                                @elseif($part->stock > 0)
                                    <span class="badge badge-warning">
                                        <i class="fas fa-exclamation"></i> Limited stock ({{ $part->stock }})
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="fas fa-times"></i> Out of stock
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="part-actions">
                            <a href="{{ route('parts.show', $part->id) }}" class="btn btn-primary btn-block">
                                <i class="fas fa-info-circle"></i> Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="no-results">
                    <i class="fas fa-search"></i>
                    <h3>No parts found</h3>
                    <p>Try changing the search filters.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrapper">
            {{ $parts->links() }}
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/parts/index.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('js/parts/index.js') }}"></script>
    @endpush
@endsection