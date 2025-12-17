@extends('layouts.app')

@section('title', 'My Orders - AutoParts Store')

@section('content')
<div class="container">
    <div class="page-header">
        <h1><i class="fas fa-shopping-cart"></i> My Orders</h1>
    </div>

    @if($orders->isEmpty())
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h2>You have no orders</h2>
            <p>Explore the store and order the parts you need</p>
            <a href="{{ route('parts.index') }}" class="btn btn-primary">
                <i class="fas fa-shopping-bag"></i> Back To Store
            </a>
        </div>
    @else
        <div class="orders-table-container">
            <table class="table orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Part</th>
                        <th>Image</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="order-row">
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>
                                <a href="{{ route('parts.show', $order->part->id) }}" class="part-link">
                                    {{ $order->part->name }}
                                </a>
                                <div class="part-code">{{ $order->part->code }}</div>
                            </td>
                            <td>
                                @if($order->part->images && count($order->part->images) > 0)
                                    <img src="{{ $order->part->images[0] }}" 
                                         alt="{{ $order->part->name }}" 
                                         class="order-thumbnail">
                                @else
                                    <div class="no-image">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $order->quantity }} pcs</td>
                            <td><strong>{{ number_format($order->total_price, 2) }} EUR</strong></td>
                            <td>
                                @switch($order->status)
                                    @case('pending')
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                        @break
                                    @case('processing')
                                        <span class="badge badge-info">
                                            <i class="fas fa-cog"></i> Processing
                                        </span>
                                        @break
                                    @case('completed')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i> Completed
                                        </span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times-circle"></i> Cancelled
                                        </span>
                                        @break
                                @endswitch
                            </td>
                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                @if($order->canBeCancelled())
                                    <form method="POST" action="{{ route('orders.cancel', $order->id) }}" class="inline-form">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to cancel this order?')">
                                            <i class="fas fa-ban"></i> Cancel
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="orders-stats">
            <div class="stat-card">
                <i class="fas fa-shopping-bag"></i>
                <div class="stat-info">
                    <h3>{{ $orders->count() }}</h3>
                    <p>Total orders</p>
                </div>
            </div>
            <div class="stat-card">
                <i class="fas fa-clock"></i>
                <div class="stat-info">
                    <h3>{{ $orders->where('status', 'pending')->count() }}</h3>
                    <p>Pending</p>
                </div>
            </div>
            <div class="stat-card">
                <i class="fas fa-check-circle"></i>
                <div class="stat-info">
                    <h3>{{ $orders->where('status', 'completed')->count() }}</h3>
                    <p>Completed</p>
                </div>
            </div>
            <div class="stat-card">
                <i class="fas fa-money-bill-wave"></i>
                <div class="stat-info">
                    <h3>{{ number_format($orders->where('status', '!=', 'cancelled')->sum('total_price'), 2) }} EUR</h3>
                    <p>Total value</p>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orders/index.css') }}">
@endpush

@endsection