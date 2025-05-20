@extends('layouts.app') @section('title', $gallery->title . ' - Event Gallery')
@section('content')
<div class="gallery-detail-container">
    <div class="gallery-detail-nav">
        @if($previous)
        <a
            href="{{ route('gallery.show', $previous) }}"
            class="nav-button prev-button"
        >
            <i class="fas fa-arrow-left"></i> Previous
        </a>
        @endif

        <a href="{{ route('gallery.index') }}" class="back-button">
            <i class="fas fa-th"></i> Back to Gallery
        </a>

        @if($next)
        <a
            href="{{ route('gallery.show', $next) }}"
            class="nav-button next-button"
        >
            Next <i class="fas fa-arrow-right"></i>
        </a>
        @endif
    </div>

    <div class="gallery-detail-content">
        <div class="gallery-detail-image-container">
            <img
                src="{{ asset('storage/' . $gallery->image) }}"
                alt="{{ $gallery->title }}"
                class="gallery-detail-image"
            />
        </div>

        <div class="gallery-detail-info">
            <h1 class="gallery-detail-title">{{ $gallery->title }}</h1>
            <p class="gallery-detail-author">
                Posted by {{ $gallery->user->name }}
            </p>
            <p class="gallery-detail-date">
                {{ $gallery->created_at->format('F j, Y') }}
            </p>
            <div class="gallery-detail-description">
                {{ $gallery->description }}
            </div>
        </div>
    </div>
</div>

<style>
    .gallery-detail-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .gallery-detail-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .nav-button,
    .back-button {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        color: #4a5568;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        border: 1px solid #e2e8f0;
    }

    .nav-button:hover,
    .back-button:hover {
        background-color: #f7fafc;
        color: #4f46e5;
    }

    .back-button {
        background-color: #4f46e5;
        color: white;
        border-color: #4f46e5;
    }

    .back-button:hover {
        background-color: #4338ca;
        color: white;
    }

    .gallery-detail-content {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .gallery-detail-image-container {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    .gallery-detail-image {
        width: 100%;
        height: auto;
        display: block;
        max-height: 70vh;
        object-fit: contain;
    }

    .gallery-detail-info {
        padding: 1rem;
    }

    .gallery-detail-title {
        font-size: 2rem;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .gallery-detail-author {
        color: #4a5568;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .gallery-detail-date {
        color: #718096;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    .gallery-detail-description {
        color: #4a5568;
        line-height: 1.6;
        white-space: pre-line;
    }

    @media (min-width: 768px) {
        .gallery-detail-content {
            grid-template-columns: 2fr 1fr;
        }
    }

    @media (max-width: 480px) {
        .gallery-detail-nav {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .gallery-detail-title {
            font-size: 1.5rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (@json($previous) && e.key === 'ArrowLeft') {
                window.location.href = "{{ route('gallery.show', $previous) }}";
            }

            if (@json($next) && e.key === 'ArrowRight') {
                window.location.href = "{{ route('gallery.show', $next) }}";
            }
        });
    });
</script>
@endsection
