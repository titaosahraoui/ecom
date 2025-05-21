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
        <div class="gallery-images-slider">
            @foreach ($gallery->images as $image)
            <div class="gallery-image-item">
                <img
                    src="{{ asset('storage/' . $image->image_path) }}"
                    alt="{{ $gallery->title }} - Image {{ $loop->iteration }}"
                    class="gallery-detail-image"
                />
            </div>
            @endforeach
        </div>

        <div class="gallery-detail-info">
            <h1 class="gallery-detail-title">{{ $gallery->title }}</h1>
            <p class="gallery-detail-author">
                By {{ $gallery->user?->name ?? 'Unknown Author' }}
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
    /* Gallery Slider Styles */
    .gallery-images-slider {
        position: relative;
        max-width: 100%;
        margin: 0 auto;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .gallery-slider-track {
        display: flex;
        transition: transform 0.5s ease;
        height: 500px; /* Adjust based on your needs */
    }

    .gallery-image-item {
        min-width: 100%;
        position: relative;
    }

    .gallery-detail-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: #f5f5f5;
    }

    /* Navigation Buttons */
    .slider-nav {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
        z-index: 1;
    }

    .slider-nav button {
        background: rgba(255, 255, 255, 0.7);
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1.2rem;
        color: #333;
        transition: all 0.3s ease;
        margin: 0 15px;
    }

    .slider-nav button:hover {
        background: rgba(255, 255, 255, 0.9);
    }

    /* Dots Indicator */
    .slider-dots {
        position: absolute;
        bottom: 20px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .slider-dots .dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .slider-dots .dot.active {
        background: rgba(255, 255, 255, 0.9);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .gallery-slider-track {
            height: 300px;
        }

        .slider-nav button {
            width: 30px;
            height: 30px;
            margin: 0 5px;
        }
    }
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
    document.addEventListener("DOMContentLoaded", function () {
        const slider = document.querySelector(".gallery-images-slider");
        const track = document.createElement("div");
        track.className = "gallery-slider-track";

        // Wrap all images in the track
        const items = document.querySelectorAll(".gallery-image-item");
        items.forEach((item) => track.appendChild(item));
        slider.prepend(track);

        // Create navigation
        const navHTML = `
            <div class="slider-nav">
                <button class="prev-slide">&lt;</button>
                <button class="next-slide">&gt;</button>
            </div>
            <div class="slider-dots"></div>
        `;
        slider.insertAdjacentHTML("beforeend", navHTML);

        // Slider functionality
        let currentIndex = 0;
        const itemCount = items.length;
        const dotsContainer = document.querySelector(".slider-dots");

        // Create dots
        for (let i = 0; i < itemCount; i++) {
            const dot = document.createElement("div");
            dot.className = "dot" + (i === 0 ? " active" : "");
            dot.dataset.index = i;
            dotsContainer.appendChild(dot);
        }

        // Update slider position
        function updateSlider() {
            track.style.transform = `translateX(-${currentIndex * 100}%)`;

            // Update dots
            document.querySelectorAll(".dot").forEach((dot, index) => {
                dot.classList.toggle("active", index === currentIndex);
            });
        }

        // Navigation events
        document.querySelector(".prev-slide").addEventListener("click", () => {
            currentIndex = currentIndex > 0 ? currentIndex - 1 : itemCount - 1;
            updateSlider();
        });

        document.querySelector(".next-slide").addEventListener("click", () => {
            currentIndex = currentIndex < itemCount - 1 ? currentIndex + 1 : 0;
            updateSlider();
        });

        // Dot click events
        document.querySelectorAll(".dot").forEach((dot) => {
            dot.addEventListener("click", () => {
                currentIndex = parseInt(dot.dataset.index);
                updateSlider();
            });
        });

        // Auto-slide (optional)
        let slideInterval = setInterval(() => {
            currentIndex = currentIndex < itemCount - 1 ? currentIndex + 1 : 0;
            updateSlider();
        }, 5000);

        // Pause on hover
        slider.addEventListener("mouseenter", () =>
            clearInterval(slideInterval)
        );
        slider.addEventListener("mouseleave", () => {
            slideInterval = setInterval(() => {
                currentIndex =
                    currentIndex < itemCount - 1 ? currentIndex + 1 : 0;
                updateSlider();
            }, 5000);
        });
    });
</script>
@endsection
