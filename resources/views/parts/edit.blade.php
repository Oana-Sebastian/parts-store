@extends('layouts.app')

@section('title', 'Edit ' . $part->name . ' - AutoParts Store')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-edit"></i> Edit Part</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('parts.update', $part->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name" class="form-label">Part Name *</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $part->name) }}" required>
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="code" class="form-label">Part Code *</label>
                            <input type="text" name="code" id="code"
                                class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code', $part->code) }}" required>
                            @error('code')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description *</label>
                        <textarea name="description" id="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror"
                            required>{{ old('description', $part->description) }}</textarea>
                        @error('description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="price" class="form-label">Price (EUR) *</label>
                            <input type="number" name="price" id="price" step="0.01" min="0"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', $part->price) }}" required>
                            @error('price')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stock" class="form-label">Stock *</label>
                            <input type="number" name="stock" id="stock" min="0"
                                class="form-control @error('stock') is-invalid @enderror"
                                value="{{ old('stock', $part->stock) }}" required>
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
                        </div>
                        <div class="form-group">
                            <label for="manufacturer" class="form-label">Manufacturer *</label>
                            <input type="text" name="manufacturer" id="manufacturer" class="form-control"
                                value="{{ old('manufacturer', $part->manufacturer) }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Image Management</label>

                        @if($part->images && count($part->images) > 0)
                            <div class="existing-images-section">
                                <h4>Current images (check to delete):</h4>
                                <div class="existing-images-grid">
                                    @foreach($part->images as $index => $image)
                                        <div class="existing-image-item">
                                            <img src="{{ $image }}" alt="Part image {{ $index + 1 }}">
                                            <label class="delete-checkbox">
                                                <input type="checkbox" name="delete_images[]" value="{{ $image }}"
                                                    onchange="toggleImageDelete(this)">
                                                <span><i class="fas fa-trash"></i> Delete</span>
                                            </label>
                                            <input type="hidden" name="existing_images[]" value="{{ $image }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-muted">This part has no images.</p>
                        @endif

                        <div class="add-images-section">
                            <h4>Add new images:</h4>

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
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update Part
                        </button>
                        <a href="{{ route('parts.show', $part->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/parts/edit.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('js/parts/edit.js') }}"></script>
    @endpush
@endsection