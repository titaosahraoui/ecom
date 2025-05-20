@extends('layouts.app') @section('title', 'Edit Gallery Item')
@section('content')
<div class="gallery-edit-container">
    <div class="gallery-edit-card">
        <div class="card-header">
            <h1><i class="fas fa-edit"></i> Edit Gallery Item</h1>
            <p class="subtitle">Update the details of your gallery item</p>
        </div>

        <form
            action="{{ route('gallery.update', $gallery) }}"
            method="POST"
            enctype="multipart/form-data"
            id="gallery-edit-form"
        >
            @csrf @method('PUT')

            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle"></i> Basic Information
                </h3>
                <div class="form-group">
                    <label for="title"
                        >Title <span class="required">*</span></label
                    >
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $gallery->title) }}"
                        required
                        class="@error('title') is-invalid @enderror"
                    />
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description"
                        >Description <span class="required">*</span></label
                    >
                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        required
                        class="@error('description') is-invalid @enderror"
                        >{{ old('description', $gallery->description) }}</textarea
                    >
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-image"></i> Image
                </h3>
                <div class="image-upload-container">
                    <div class="current-image-preview">
                        <label>Current Image</label>
                        <img
                            src="{{ asset('storage/' . $gallery->image) }}"
                            alt="{{ $gallery->title }}"
                            id="current-image"
                        />
                        <div class="image-info">
                            <span
                                class="image-name"
                                >{{ basename($gallery->image) }}</span
                            >
                            <span class="image-size"
                                >{{ round(Storage::disk('public')->size($gallery->image) / 1024) }}
                                KB</span
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image">Change Image</label>
                        <div class="file-upload-wrapper">
                            <input
                                type="file"
                                id="image"
                                name="image"
                                accept="image/*"
                                class="file-upload-input @error('image') is-invalid @enderror"
                            />
                            <label for="image" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Choose a new image</span>
                            </label>
                            <div
                                class="file-upload-preview"
                                id="image-preview"
                            ></div>
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="file-upload-hint"
                                >Max size: 2MB | Formats: JPEG, PNG, JPG,
                                GIF</small
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update & Submit for Re-approval
                </button>
                <a
                    href="{{ route('gallery.show', $gallery) }}"
                    class="btn btn-secondary"
                >
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    :root {
        --primary-color: #6d28d9;
        --primary-light: #8b5cf6;
        --danger-color: #ef4444;
        --gray-light: #f3f4f6;
        --gray-medium: #e5e7eb;
        --gray-dark: #6b7280;
        --text-color: #374151;
    }

    .gallery-edit-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    .gallery-edit-card {
        background: white;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
            0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .card-header {
        background-color: var(--primary-color);
        color: white;
        padding: 1.5rem;
    }

    .card-header h1 {
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-header .subtitle {
        font-size: 0.95rem;
        opacity: 0.9;
    }

    .form-section {
        padding: 1.5rem;
        border-bottom: 1px solid var(--gray-medium);
    }

    .form-section:last-child {
        border-bottom: none;
    }

    .section-title {
        font-size: 1.25rem;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-color);
    }

    .required {
        color: var(--danger-color);
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--gray-medium);
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.2s;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .invalid-feedback {
        color: var(--danger-color);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .is-invalid {
        border-color: var(--danger-color) !important;
    }

    /* Image Upload Styles */
    .image-upload-container {
        display: grid;
        gap: 2rem;
    }

    .current-image-preview {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    #current-image {
        max-width: 100%;
        max-height: 300px;
        border-radius: 0.5rem;
        border: 1px solid var(--gray-medium);
    }

    .image-info {
        display: flex;
        gap: 1rem;
        font-size: 0.875rem;
        color: var(--gray-dark);
    }

    .file-upload-wrapper {
        margin-top: 1rem;
    }

    .file-upload-input {
        display: none;
    }

    .file-upload-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        border: 2px dashed var(--gray-medium);
        border-radius: 0.75rem;
        background-color: var(--gray-light);
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }

    .file-upload-label:hover {
        border-color: var(--primary-light);
        background-color: rgba(109, 40, 217, 0.05);
    }

    .file-upload-label i {
        font-size: 2.5rem;
        color: var(--primary-light);
        margin-bottom: 1rem;
    }

    .file-upload-preview {
        margin-top: 1rem;
        display: none;
    }

    .file-upload-preview img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 0.5rem;
        border: 1px solid var(--gray-medium);
    }

    .file-upload-hint {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: var(--gray-dark);
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        padding: 1.5rem;
        background-color: var(--gray-light);
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background-color: var(--primary-light);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: white;
        color: var(--text-color);
        border: 1px solid var(--gray-medium);
    }

    .btn-secondary:hover {
        background-color: var(--gray-light);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .gallery-edit-container {
            padding: 0 1rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Image preview functionality
        const imageInput = document.getElementById("image");
        const imagePreview = document.getElementById("image-preview");
        const currentImage = document.getElementById("current-image");

        imageInput.addEventListener("change", function () {
            const file = this.files[0];
            if (file) {
                // Validate file size
                if (file.size > 2 * 1024 * 1024) {
                    alert("File size must be less than 2MB");
                    this.value = "";
                    return;
                }

                // Validate file type
                const validTypes = [
                    "image/jpeg",
                    "image/png",
                    "image/jpg",
                    "image/gif",
                ];
                if (!validTypes.includes(file.type)) {
                    alert("Only JPEG, PNG, JPG, and GIF files are allowed");
                    this.value = "";
                    return;
                }

                const reader = new FileReader();

                reader.addEventListener("load", function () {
                    imagePreview.innerHTML = `
                    <img src="${this.result}" alt="Preview">
                    <button type="button" class="btn-remove-image">
                        <i class="fas fa-times"></i> Remove
                    </button>
                `;

                    // Show preview container
                    imagePreview.style.display = "block";

                    // Add click handler for remove button
                    document
                        .querySelector(".btn-remove-image")
                        .addEventListener("click", function (e) {
                            e.stopPropagation();
                            imageInput.value = "";
                            imagePreview.style.display = "none";
                            imagePreview.innerHTML = "";
                        });
                });

                reader.readAsDataURL(file);
            }
        });

        // Form validation
        const form = document.getElementById("gallery-edit-form");
        form.addEventListener("submit", function (e) {
            let valid = true;

            // Check required fields
            const requiredFields = form.querySelectorAll("[required]");
            requiredFields.forEach((field) => {
                if (!field.value.trim()) {
                    field.classList.add("is-invalid");
                    valid = false;
                }
            });

            if (!valid) {
                e.preventDefault();
                // Scroll to first error
                const firstError = form.querySelector(".is-invalid");
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: "smooth",
                        block: "center",
                    });
                }
            }
        });

        // Remove error class when user starts typing
        form.querySelectorAll("input, textarea").forEach((element) => {
            element.addEventListener("input", function () {
                this.classList.remove("is-invalid");
            });
        });
    });
</script>
@endsection
