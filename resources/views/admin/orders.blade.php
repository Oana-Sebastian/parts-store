@extends('layouts.app')

@section('title', 'Order Management - Admin')

@section('content')
    <div class="container">
        <div class="admin-header">
            <h1><i class="fas fa-tasks"></i> Order Management</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon is-total">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['total'] }}</h3>
                    <p>Total Orders</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon is-pending">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['pending'] }}</h3>
                    <p>Pending</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon is-processing">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['processing'] }}</h3>
                    <p>Processing</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon is-completed">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['completed'] }}</h3>
                    <p>Completed</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon is-cancelled">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['cancelled'] }}</h3>
                    <p>Cancelled</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon is-revenue">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ number_format($stats['total_revenue'], 2) }} EUR</h3>
                    <p>Total Revenue</p>
                </div>
            </div>
        </div>

        <div class="filters-card">
            <h3><i class="fas fa-filter"></i> Filter Orders</h3>
            <form method="GET" action="{{ route('admin.orders') }}" class="filters-form">
                <div class="filter-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing
                        </option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>User</label>
                    <select name="user_id" class="form-control">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label>Sort</label>
                    <select name="sort" class="form-control">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Order Date</option>
                        <option value="total_price" {{ request('sort') == 'total_price' ? 'selected' : '' }}>Price</option>
                        <option value="status" {{ request('sort') == 'status' ? 'selected' : '' }}>Status</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Order</label>
                    <select name="order" class="form-control">
                        <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Descending</option>
                        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Filter
                </button>

                <a href="{{ route('admin.orders') }}" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </form>
        </div>

        <div class="orders-table-card">
            <table class="table admin-orders-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Part</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>
                                <div class="user-info">
                                    <i class="fas fa-user"></i>
                                    <div>
                                        <strong>{{ $order->user->name }}</strong><br>
                                        <small>{{ $order->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="part-info">
                                    <strong>{{ $order->part->name }}</strong><br>
                                    <small>Code: {{ $order->part->code }}</small>
                                </div>
                            </td>
                            <td>{{ $order->quantity }} pcs</td>
                            <td><strong>{{ number_format($order->total_price, 2) }} EUR</strong></td>
                            <td>
                                <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}"
                                    class="status-form">
                                    @csrf
                                    @method('PATCH')

                                    <select name="status" class="form-control status-select status-{{ $order->status }}"
                                        onchange="this.form.submit()" {{ in_array($order->status, ['cancelled', 'completed']) ? 'disabled' : '' }}>
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                            Processing</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed
                                        </option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                        </option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                {{ $order->created_at->format('d.m.Y H:i') }}<br>
                                <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('parts.show', $order->part->id) }}" class="btn btn-sm btn-info"
                                        title="See Part Details">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <form method="POST" action="{{ route('admin.orders.delete', $order->id) }}"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this order?')"
                                            title="Delete Order">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>No orders found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination-wrapper">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/orders.css') }}">
    @endpush
@endsection