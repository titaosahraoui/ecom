@extends('layouts.app') @section('content')
<div class="gallery-container">
    <div class="gallery-header">
        <h1>Gallery</h1>

        @can('create', App\Models\Gallery::class)
        <button id="openCreateModal" class="btn-create-gallery">
            <i class="fas fa-plus"></i> Create Gallery
        </button>
        @endcan
    </div>

    <!-- Create Gallery Modal -->
    <div id="createGalleryModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Create New Gallery</h3>
                <button class="modal-close">&times;</button>
            </div>
            <form
                id="galleryForm"
                action="{{ route('gallery.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="form-group">
                    <label for="title">Title *</label>
                    <input type="text" id="title" name="title" required />
                </div>
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        required
                    ></textarea>
                </div>
                <div class="form-group">
                    <label for="images">Images * (Select multiple)</label>
                    <input
                        type="file"
                        id="images"
                        name="images[]"
                        multiple
                        accept="image/*"
                        required
                    />
                    <div
                        id="imagePreview"
                        class="image-preview-container"
                    ></div>
                    <small class="form-text text-muted"
                        >Max 2MB per image. Allowed: JPEG, PNG, JPG, GIF</small
                    >
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Submit Gallery
                </button>
            </form>
        </div>
    </div>

    <!-- Pending Approval Section (Admin Only) -->
    @can('approve', App\Models\Gallery::class) @if($pendingGalleries->count() >
    0)
    <div class="pending-galleries">
        <h2>
            <i class="fas fa-clock"></i> Pending Approval ({{ $pendingGalleries->count()



            }})
        </h2>
        <div class="gallery-grid">
            @foreach($pendingGalleries as $gallery)
            <div class="gallery-card pending">
                <div class="gallery-image-container">
                    @if($gallery->primaryImage)
                    <img
                        src="{{ Storage::url($gallery->primaryImage->image_path) }}"
                        alt="{{ $gallery->title }}"
                    />
                    @endif
                    <div class="gallery-actions">
                        <form
                            action="{{ route('gallery.approve', $gallery) }}"
                            method="POST"
                        >
                            @csrf
                            <button
                                type="submit"
                                class="btn-action btn-approve"
                                title="Approve"
                            >
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        <form
                            action="{{ route('gallery.reject', $gallery) }}"
                            method="POST"
                        >
                            @csrf @method('PATCH')
                            <button
                                type="submit"
                                class="btn-action btn-reject"
                                title="Reject"
                            >
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                        @if($gallery->exists)
                        <a
                            href="{{ route('gallery.show', $gallery) }}"
                            class="gallery-card"
                        >
                            <!-- Content -->
                        </a>
                        @else
                        <div class="alert alert-warning">
                            Gallery ID missing for {{ $gallery->title }}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <h3>{{ $gallery->title }}</h3>
                    <p>{{ Str::limit($gallery->description, 100) }}</p>
                    <div class="card-footer">
                        <span class="author"
                            >By {{ $gallery->user->name }}</span
                        >
                        <span
                            class="date"
                            >{{ $gallery->created_at->format('M d, Y') }}</span
                        >
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif @endcan

    <!-- Approved Galleries Section -->
    <div class="approved-galleries">
        <h2>
            <i class="fas fa-check-circle"></i> Approved Galleries ({{ $galleries->total()



            }})
        </h2>
        @if($galleries->count() > 0)
        <div class="gallery-grid">
            @foreach($galleries as $gallery)
            <a
                href="{{ route('gallery.show', $gallery) }}"
                class="gallery-card"
            >
                <div class="gallery-image-container">
                    @if($gallery->primaryImage)
                    <img
                        src="{{ Storage::url($gallery->primaryImage->image_path) }}"
                        alt="{{ $gallery->title }}"
                    />
                    <div class="image-count">
                        <i class="fas fa-images"></i>
                        {{ $gallery->images->count() }}
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <h3>{{ $gallery->title }}</h3>
                    <p>{{ Str::limit($gallery->description, 100) }}</p>
                    <div class="card-footer">
                        <span class="author"
                            >By {{ $gallery->user->name }}</span
                        >
                        <span
                            class="date"
                            >{{ $gallery->created_at->format('M d, Y') }}</span
                        >
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        {{ $galleries->links() }}
        @else
        <div class="empty-state">
            <i class="fas fa-images"></i>
            <p>No approved galleries yet.</p>
        </div>
        @endif
    </div>
</div>
<style>
    /* Gallery Container */
    .gallery-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Gallery Header */
    .gallery-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .gallery-header h1 {
        margin: 0;
        font-size: 2rem;
        color: #333;
    }

    .btn-create-gallery {
        background-color: #4e73df;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-create-gallery:hover {
        background-color: #3a5bc7;
        transform: translateY(-2px);
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background: white;
        border-radius: 8px;
        width: 100%;
        max-width: 600px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.5rem;
        color: #333;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6c757d;
        transition: all 0.2s;
    }

    .modal-close:hover {
        color: #333;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
        transition: all 0.2s;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #4e73df;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.2);
    }

    .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .image-preview {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .btn-submit {
        background-color: #4e73df;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-submit:hover {
        background-color: #3a5bc7;
    }

    /* Gallery Grid */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }

    /* Gallery Card */
    .gallery-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        text-decoration: none;
        color: inherit;
        background: white;
    }

    .gallery-card.pending {
        border-left: 4px solid #ffc107;
    }

    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .gallery-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .gallery-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .gallery-card:hover .gallery-image-container img {
        transform: scale(1.05);
    }

    .image-count {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .gallery-actions {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        gap: 5px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .gallery-card:hover .gallery-actions {
        opacity: 1;
    }

    .btn-action {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-approve {
        background-color: #28a745;
        color: white;
    }

    .btn-reject {
        background-color: #dc3545;
        color: white;
    }

    .btn-view {
        background-color: #17a2b8;
        color: white;
        text-decoration: none;
    }

    .btn-action:hover {
        transform: scale(1.1);
    }

    /* Card Body */
    .card-body {
        padding: 15px;
    }

    .card-body h3 {
        margin: 0 0 10px;
        font-size: 1.2rem;
        color: #333;
    }

    .card-body p {
        margin: 0;
        color: #666;
        font-size: 0.9rem;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        font-size: 0.8rem;
        color: #888;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .empty-state i {
        font-size: 3rem;
        color: #6c757d;
        margin-bottom: 15px;
    }

    .empty-state p {
        margin: 0;
        color: #6c757d;
        font-size: 1.1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .gallery-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        }

        .modal-content {
            width: 95%;
            padding: 15px;
        }
    }

    @media (max-width: 480px) {
        .gallery-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Modal functionality
        const modal = document.getElementById("createGalleryModal");
        const openBtn = document.getElementById("openCreateModal");
        const closeBtn = document.querySelector(".modal-close");

        if (openBtn) {
            openBtn.addEventListener("click", () => {
                modal.style.display = "flex";
                document.body.style.overflow = "hidden";
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener("click", () => {
                modal.style.display = "none";
                document.body.style.overflow = "auto";
            });
        }

        window.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.style.display = "none";
                document.body.style.overflow = "auto";
            }
        });

        // Image preview functionality
        const imageInput = document.getElementById("images");
        const previewContainer = document.getElementById("imagePreview");

        if (imageInput && previewContainer) {
            imageInput.addEventListener("change", function () {
                previewContainer.innerHTML = "";

                if (this.files) {
                    Array.from(this.files).forEach((file) => {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            const img = document.createElement("img");
                            img.src = e.target.result;
                            img.classList.add("image-preview");
                            previewContainer.appendChild(img);
                        };

                        reader.readAsDataURL(file);
                    });
                }
            });
        }

        // Form submission handling
        const galleryForm = document.getElementById("galleryForm");
        if (galleryForm) {
            galleryForm.addEventListener("submit", function (e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<i class="fas fa-spinner fa-spin"></i> Submitting...';
            });
        }
    });
</script>
@endsection
