<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AutoParts Store')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carousel.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('parts.index') }}" class="navbar-brand">
                <i class="fas fa-car"></i> AutoParts Store
            </a>

            <div class="navbar-menu">

                @auth

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard')}}" class="nav-link admin-link">
                            <i class="fas fa-tachometer-alt"></i> Admin Dashboard
                        </a>

                        <a href="{{ route('admin.orders')}}" class="nav-link admin-link">
                            <i class="fas fa-tasks"></i> Manage Orders
                        </a>

                        <a href="{{ route('parts.create') }}" class="nav-link admin-link">
                            <i class="fas fa-plus-circle"></i> Add Part
                        </a>
                    @else
                        <a href="{{ route('orders.index')}}" class="nav-link">
                            <i class="fas fa-shopping-cart"></i> My Orders
                        </a>
                    @endif

                    <div class="nav-dropdown">
                        <button class="nav-link dropdown-toggle">
                            <i class="fas fa-user"></i> {{ auth()->user()->name }}
                        </button>
                        <div class="dropdown-menu">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="nav-link">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="nav-link">
                        <i class="fas fa-user-plus"></i> Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>AutoParts Store</h3>
                    <p>Your trusted store for quality auto parts</p>
                </div>
                <div class="footer-section">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="{{ route('parts.index') }}">All Parts</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <p><i class="fas fa-phone"></i> +40 123 456 789</p>
                    <p><i class="fas fa-envelope"></i> contact@autoparts.ro</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 AutoParts Store. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>