@extends('layouts.app')

@section('title', 'Add New Product')
@section('content')
<div class="product-create-container">
    <div class="product-create-card">
        <div class="card-header">
            <div class="header-content">
                <h1><i class="fas fa-plus-circle me-2"></i>Add New Product</h1>
                <p class="subtitle">Fill in the details to add a new product to your catalog</p>
            </div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" id="product-form">
                @csrf

                <!-- Product Basic Info Section -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-info-circle me-2"></i>Basic Information</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Product Name <span class="required">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required
                                       placeholder="Enter product name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status" class="form-label">Status <span class="required">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                    <option value="coming_soon" {{ old('status') == 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description <span class="required">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" required
                                  placeholder="Enter detailed product description">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Pricing & Inventory Section -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-tag me-2"></i>Pricing & Inventory</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price" class="form-label">Price (€) <span class="required">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">€</span>
                                    <input type="number" step="0.01" min="0" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price') }}" required
                                           placeholder="0.00">
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stock" class="form-label">Stock Quantity <span class="required">*</span></label>
                                <input type="number" min="0" class="form-control @error('stock') is-invalid @enderror" 
                                       id="stock" name="stock" value="{{ old('stock') }}" required
                                       placeholder="Enter quantity">
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Upload Section -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-image me-2"></i>Product Image</h3>
                    <div class="form-group">
                        <div class="image-upload-container">
                            <label for="image" class="upload-label">
                                <div class="upload-preview" id="image-preview">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Click to upload product image</p>
                                    <span class="upload-requirements">Max 2MB (JPEG, PNG, JPG)</span>
                                </div>
                                <input type="file" class="d-none @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*" required>
                            </label>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Categories Section -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-tags me-2"></i>Categories</h3>
                    <div class="form-group">
                        <div class="categories-container">
                            @foreach($categories as $category)
                            <div class="category-checkbox">
                                <input type="checkbox" class="category-input" 
                                       id="category-{{ $category->id }}" 
                                       name="categories[]" 
                                       value="{{ $category->id }}"
                                       {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                <label for="category-{{ $category->id }}" class="category-label">
                                    <span class="category-name">{{ $category->name }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @error('categories')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save me-2"></i> Create Product
                    </button>
                    <a href="{{ route('products.index') }}" class="btn-cancel">
                        <i class="fas fa-times me-2"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Base Styles */
    :root {
        --primary-color: #6d28d9;
        --primary-light: #8b5cf6;
        --danger-color: #ef4444;
        --gray-light: #f3f4f6;
        --gray-medium: #e5e7eb;
        --gray-dark: #6b7280;
        --text-color: #374151;
    }

    .product-create-container {
        max-width: 1000px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    .product-create-card {
        background: white;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .card-header {
        background-color: var(--primary-color);
        color: white;
        padding: 1.5rem;
    }

    .header-content h1 {
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .header-content .subtitle {
        font-size: 0.95rem;
        opacity: 0.9;
    }

    .card-body {
        padding: 2rem;
    }

    /* Form Sections */
    .form-section {
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--gray-medium);
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.25rem;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-color);
    }

    .required {
        color: var(--danger-color);
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--gray-medium);
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        outline: none;
        border-color: var(--primary-light);
        box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
    }

    .input-group {
        display: flex;
    }

    .input-group-text {
        background-color: var(--gray-light);
        border: 1px solid var(--gray-medium);
        border-right: none;
        border-radius: 0.5rem 0 0 0.5rem;
        padding: 0.75rem 1rem;
        color: var(--gray-dark);
    }

    .input-group .form-control {
        border-radius: 0 0.5rem 0.5rem 0;
    }

    /* Image Upload */
    .image-upload-container {
        margin-top: 1rem;
    }

    .upload-label {
        display: block;
        cursor: pointer;
    }

    .upload-preview {
        border: 2px dashed var(--gray-medium);
        border-radius: 0.75rem;
        padding: 2rem;
        text-align: center;
        transition: all 0.2s;
        background-color: var(--gray-light);
    }

    .upload-preview:hover {
        border-color: var(--primary-light);
        background-color: rgba(109, 40, 217, 0.05);
    }

    .upload-preview i {
        font-size: 2.5rem;
        color: var(--primary-light);
        margin-bottom: 1rem;
    }

    .upload-preview p {
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-color);
    }

    .upload-requirements {
        font-size: 0.85rem;
        color: var(--gray-dark);
    }

    /* Categories */
    .categories-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 0.75rem;
    }

    .category-checkbox {
        position: relative;
    }

    .category-input {
        position: absolute;
        opacity: 0;
    }

    .category-label {
        display: block;
        padding: 0.75rem 1rem;
        background-color: var(--gray-light);
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
        border: 1px solid var(--gray-medium);
    }

    .category-input:checked + .category-label {
        background-color: rgba(109, 40, 217, 0.1);
        border-color: var(--primary-light);
        color: var(--primary-color);
    }

    .category-name {
        font-weight: 500;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-submit {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
    }

    .btn-submit:hover {
        background-color: var(--primary-light);
        transform: translateY(-1px);
    }

    .btn-cancel {
        background-color: white;
        color: var(--text-color);
        border: 1px solid var(--gray-medium);
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-cancel:hover {
        background-color: var(--gray-light);
        transform: translateY(-1px);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .product-create-container {
            padding: 0 1rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .categories-container {
            grid-template-columns: 1fr 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn-submit,
        .btn-cancel {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .categories-container {
            grid-template-columns: 1fr;
        }
        
        .row > div {
            margin-bottom: 1rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview functionality
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.addEventListener('load', function() {
                    imagePreview.innerHTML = `
                        <img src="${this.result}" alt="Preview" class="preview-image">
                        <button type="button" class="btn-remove-image">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    
                    // Add click handler for remove button
                    document.querySelector('.btn-remove-image').addEventListener('click', function(e) {
                        e.stopPropagation();
                        imageInput.value = '';
                        imagePreview.innerHTML = `
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Click to upload product image</p>
                            <span class="upload-requirements">Max 2MB (JPEG, PNG, JPG)</span>
                        `;
                    });
                });
                
                reader.readAsDataURL(file);
            }
        });
        
        // Form validation
        const form = document.getElementById('product-form');
        form.addEventListener('submit', function(e) {
            let valid = true;
            
            // Check required fields
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    valid = false;
                }
            });
            
            // Check at least one category is selected
            const categories = form.querySelectorAll('input[name="categories[]"]:checked');
            if (categories.length === 0) {
                const categoryError = document.createElement('div');
                categoryError.className = 'text-danger small';
                categoryError.textContent = 'Please select at least one category';
                document.querySelector('.categories-container').after(categoryError);
                valid = false;
            }
            
            if (!valid) {
                e.preventDefault();
                // Scroll to first error
                const firstError = form.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
        
        // Remove error class when user starts typing
        form.querySelectorAll('input, textarea, select').forEach(element => {
            element.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
        });
    });
</script>
@endsection