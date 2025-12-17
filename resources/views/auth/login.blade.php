<x-guest-layout>
    <x-slot name="title">Login - AutoParts Store</x-slot>

    <h2 class="auth-header">
        <i class="fas fa-sign-in-alt"></i> Authentication
    </h2>

    @if (session('status'))
        <div class="auth-alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">
                <i class="fas fa-envelope"></i> Email
            </label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required
                autofocus autocomplete="username">
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">
                <i class="fas fa-lock"></i> Password
            </label>
            <input id="password" class="form-control" type="password" name="password" required
                autocomplete="current-password">
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>


        <div class="form-group">
            <label class="remember-me">
                <input type="checkbox" name="remember">
                <span>Remember Me</span>
            </label>
        </div>

        <button type="submit" class="btn-auth">
            <i class="fas fa-sign-in-alt"></i> Log In
        </button>

        <div class="auth-links">
            <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
        </div>
    </form>

    <div class="demo-accounts-box">
        <strong>Demo Accounts:</strong><br>
        <strong>Admin:</strong> admin@parts.com / password123<br>
        <strong>User:</strong> user@parts.com / password123
    </div>
</x-guest-layout>