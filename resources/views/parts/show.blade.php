@extends('layouts.app')

@section('title', $part->name . ' - AutoParts Store')

@section('content')
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('parts.index') }}">
                <i class="fas fa-home"></i> Home
            </a>
            <span>/</span>
            <span>{{ $part->name }}</span>
        </div>

        <div class="part-detail">
            <div class="part-gallery">
                <div class="carousel-container">
                    <div class="carousel-slides" id="partCarousel">
                        @if($part->images && count($part->images) > 0)
                            @foreach($part->images as $image)
                                <div class="carousel-slide">
                                    <img src="{{ $image }}" alt="{{ $part->name }}">
                                </div>
                            @endforeach
                        @else
                            <div class="carousel-slide">
                                <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=800" alt="No image">
                            </div>
                        @endif
                    </div>

                    @if($part->images && count($part->images) > 1)
                        <button class="carousel-btn carousel-btn-prev" onclick="moveDetailCarousel(-1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="carousel-btn carousel-btn-next" onclick="moveDetailCarousel(1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>

                        <div class="carousel-indicators">
                            @foreach($part->images as $index => $image)
                                <span class="carousel-indicator {{ $index === 0 ? 'active' : '' }}"
                                    onclick="goToDetailSlide({{ $index }})"></span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="part-info">
                <h1>{{ $part->name }}</h1>

                <div class="part-meta">
                    <span class="badge badge-primary">{{ $part->category }}</span>
                    <span class="part-code">Code: <strong>{{ $part->code }}</strong></span>
                </div>

                <div class="part-price-box">
                    <div class="price">{{ number_format($part->price, 2) }} EUR</div>
                    <div class="stock-info">
                        @if($part->stock > 10)
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle"></i> In stock ({{ $part->stock }} pcs)
                            </span>
                        @elseif($part->stock > 0)
                            <span class="badge badge-warning">
                                <i class="fas fa-exclamation-triangle"></i> Limited stock ({{ $part->stock }} pcs)
                            </span>
                        @else
                            <span class="badge badge-danger">
                                <i class="fas fa-times-circle"></i> Out of stock
                            </span>
                        @endif
                    </div>
                </div>

                <div class="part-details-table">
                    <table class="table">
                        <tr>
                            <th>Manufacturer</th>
                            <td>{{ $part->manufacturer }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>{{ $part->category }}</td>
                        </tr>
                        <tr>
                            <th>Product Code</th>
                            <td>{{ $part->code }}</td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td><strong>{{ number_format($part->price, 2) }} EUR</strong></td>
                        </tr>
                    </table>
                </div>

                <div class="part-description">
                    <h3>Description</h3>
                    <p>{{ $part->description }}</p>
                </div>

                @auth
                    @if($part->stock > 0)
                        <form method="POST" action="{{ route('orders.store') }}" class="order-form" id="orderForm">
                            @csrf
                            <input type="hidden" name="part_id" value="{{ $part->id }}">

                            <div class="quantity-selector">
                                <label for="quantity">Quantity:</label>
                                <div class="quantity-input">
                                    <button type="button" onclick="decreaseQuantity()" class="qty-btn">-</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $part->stock }}"
                                        class="form-control">
                                    <button type="button" onclick="increaseQuantity()" class="qty-btn">+</button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success btn-large">
                                <i class="fas fa-shopping-cart"></i> Order Now
                            </button>
                        </form>
                    @else
                        <div class="out-of-stock-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <p>The product is currently unavailable</p>
                        </div>
                    @endif
                @else
                    <div class="login-message">
                        <i class="fas fa-user-lock"></i>
                        <p>
                            <a href="{{ route('login') }}">Log in</a> to order
                        </p>
                    </div>
                @endauth

                @can('update', $part)
                    <div class="admin-actions">
                        <a href="{{ route('parts.edit', $part->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('parts.destroy', $part->id) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this part?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                @endcan
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/parts/show.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('js/parts/show.js') }}"></script>
    @endpush
@endsection