@extends('layouts.app')

@section('title', 'Add Part - AutoParts Store')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-plus-circle"></i> Add New Part</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('parts.store') }}" id="partForm" enctype="multipart/form-data">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name" class="form-label">Part Name *</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="code" class="form-label">Part Code *</label>
                            <input type="text" name="code" id="code"
                                class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" required>
                            @error('code')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description *</label>
                        <textarea name="description" id="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror"
                            required>{{ old('description') }}</textarea>
                        @error('description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="price" class="form-label">Price (EUR) *</label>
                            <input type="number" name="price" id="price" step="0.01" min="0"
                                class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}"
                                required>
                            @error('price')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stock" class="form-label">Stock *</label>
                            <input type="number" name="stock" id="stock" min="0"
                                class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}"
                                required>
                            @error('stock')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="category" class="form-label">Category *</label>
                            <select name="category" id="category"
                                class="form-control @error('category') is-invalid @enderror" required>
                                <option value="">Select category</option>
                                <option value="Engine" {{ old('category') == 'Engine' ? 'selected' : '' }}>Engine</option>
                                <option value="Braking" {{ old('category') == 'Braking' ? 'selected' : '' }}>Braking</option>
                                <option value="Suspension" {{ old('category') == 'Suspension' ? 'selected' : '' }}>Suspension
                                </option>
                                <option value="Electrical System" {{ old('category') == 'Electrical System' ? 'selected' : '' }}>Electrical System</option>
                                <option value="Wheels" {{ old('category') == 'Wheels' ? 'selected' : '' }}>Wheels</option>
                                <option value="Body" {{ old('category') == 'Body' ? 'selected' : '' }}>Body</option>
                                <option value="Interior" {{ old('category') == 'Interior' ? 'selected' : '' }}>Interior
                                </option>
                            </select>
                            @error('category')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div id="newCategoryContainer" style="display: none; margin-top: 10px;">
                                <input type="text" name="new_category" id="new_category" class="form-control"
                                    placeholder="Enter new category name" value="{{ old('new_category') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="manufacturer" class="form-label">Manufacturer *</label>
                            <input type="text" name="manufacturer" id="manufacturer"
                                class="form-control @error('manufacturer') is-invalid @enderror"
                                value="{{ old('manufacturer') }}" required>
                            @error('manufacturer')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Part Images</label>

                        <div class="url-section">
                            <label class="form-label">Add image URLs:</label>
                            <div id="urlContainer">
                                <div class="url-input-group">
                                    <input type="url" name="image_urls[]" class="form-control"
                                        placeholder="https://example.com/image.jpg">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeUrlInput(this)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="addUrlInput()">
                                <i class="fas fa-plus"></i> Add URL
                            </button>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Save Part
                        </button>
                        <a href="{{ route('parts.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/parts/create.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('js/parts/edit.js') }}"></script>
    @endpush
@endsection