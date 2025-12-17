<x-guest-layout>
    <x-slot name="title">Register - AutoParts Store</x-slot>
    
    <h2 class="auth-header">
        <i class="fas fa-user-plus"></i> Register
    </h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">
                <i class="fas fa-user"></i> Name
            </label>
            <input id="name" 
                   class="form-control" 
                   type="text" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required 
                   autofocus 
                   autocomplete="name">
            @error('name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">
                <i class="fas fa-envelope"></i> Email
            </label>
            <input id="email" 
                   class="form-control" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autocomplete="username">
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">
                <i class="fas fa-lock"></i> Password
            </label>
            <input id="password" 
                   class="form-control"
                   type="password"
                   name="password"
                   required 
                   autocomplete="new-password">
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="form-label">
                <i class="fas fa-lock"></i> Confirm Password
            </label>
            <input id="password_confirmation" 
                   class="form-control"
                   type="password"
                   name="password_confirmation"
                   required 
                   autocomplete="new-password">
            @error('password_confirmation')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn-auth">
            <i class="fas fa-user-plus"></i> Create Account
        </button>

        <div class="auth-links">
            <p>Already have an account? <a href="{{ route('login') }}">Log in here</a></p>
        </div>
    </form>
</x-guest-layout>