@extends('layouts.app')

@section('title', 'Admin Dashboard - AutoParts Store')

@section('content')
<div class="container">
    <div class="dashboard-header">
        <h1><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon is-users">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['total_users'] }}</h3>
                <p>Active Users</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon is-parts">
                <i class="fas fa-cogs"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['total_parts'] }}</h3>
                <p>Total Parts</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon is-orders">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['total_orders'] }}</h3>
                <p>Total Orders</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon is-pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['pending_orders'] }}</h3>
                <p>Pending Orders</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon is-low-stock">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['low_stock_parts'] }}</h3>
                <p>Low Stock Parts</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon is-revenue">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($stats['total_revenue'], 2) }} EUR</h3>
                <p>Total Revenue</p>
            </div>
        </div>
    </div>

    <div class="quick-actions">
        <h2><i class="fas fa-bolt"></i> Quick Actions</h2>
        <div class="actions-grid">
            <a href="{{ route('admin.orders') }}" class="action-card">
                <i class="fas fa-tasks"></i>
                <h3>Manage Orders</h3>
                <p>View and update order statuses</p>
            </a>
            
            <a href="{{ route('parts.create') }}" class="action-card">
                <i class="fas fa-plus-circle"></i>
                <h3>Add Part</h3>
                <p>Add new parts to the catalog</p>
            </a>
            
            <a href="{{ route('parts.index') }}" class="action-card">
                <i class="fas fa-list"></i>
                <h3>View All Parts</h3>
                <p>Manage the parts catalog</p>
            </a>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="dashboard-card">
            <div class="card-header">
                <h3><i class="fas fa-shopping-cart"></i> Recent Orders</h3>
                <a href="{{ route('admin.orders') }}" class="view-all">View All →</a>
            </div>
            <div class="card-body">
                @forelse($stats['recent_orders'] as $order)
                    <div class="order-item">
                        <div class="order-info">
                            <strong>#{{ $order->id }} - {{ $order->user->name }}</strong>
                            <p>{{ $order->part->name }} ({{ $order->quantity }} buc)</p>
                            <small>{{ $order->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="order-status">
                            @switch($order->status)
                                @case('pending')
                                    <span class="badge badge-warning">Pending</span>
                                    @break
                                @case('processing')
                                    <span class="badge badge-info">Processing</span>
                                    @break
                                @case('completed')
                                    <span class="badge badge-success">Completed</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge badge-danger">Cancelled</span>
                                    @break
                            @endswitch
                            <strong>{{ number_format($order->total_price, 2) }} EUR</strong>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No recent orders</p>
                @endforelse
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                <h3><i class="fas fa-exclamation-triangle"></i> Low Stock</h3>
                <a href="{{ route('parts.index') }}" class="view-all">View All →</a>
            </div>
            <div class="card-body">
                @forelse($stats['low_stock'] as $part)
                    <div class="stock-item">
                        <div class="stock-info">
                            <strong>{{ $part->name }}</strong>
                            <p>Code: {{ $part->code }}</p>
                        </div>
                        <div class="stock-level">
                            <span class="badge {{ $part->stock <= 2 ? 'badge-danger' : 'badge-warning' }}">
                                {{ $part->stock }} pcs
                            </span>
                            <a href="{{ route('parts.edit', $part->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">All parts have sufficient stock</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endpush
@endsection