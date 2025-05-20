@extends('layouts.app') @section('content')
<div class="gallery-detail">
    <div class="gallery-header">
        <h1>{{ $gallery->title }}</h1>
        <p class="author">By {{ $gallery->user->name }}</p>
    </div>

    <div class="gallery-carousel">
        <div class="main-image-container">
            <img
                id="main-image"
                src="{{ Storage::url($gallery->images->first()->image_path) }}"
                alt="{{ $gallery->title }}"
            />
        </div>
        <div class="thumbnail-container">
            @foreach($gallery->images as $image)
            <img
                src="{{ Storage::url($image->image_path) }}"
                alt="Gallery image {{ $loop->iteration }}"
                class="thumbnail {{ $loop->first ? 'active' : '' }}"
                onclick="changeMainImage(this, '{{ Storage::url($image->image_path) }}')"
            />
            @endforeach
        </div>
    </div>

    <div class="gallery-description">
        <p>{{ $gallery->description }}</p>
    </div>

    <div class="gallery-navigation">
        @if($previous)
        <a href="{{ route('gallery.show', $previous) }}" class="btn-prev">
            <i class="fas fa-arrow-left"></i> Previous
        </a>
        @endif

        <a href="{{ route('gallery.index') }}" class="btn-back"
            >Back to Gallery</a
        >

        @if($next)
        <a href="{{ route('gallery.show', $next) }}" class="btn-next">
            Next <i class="fas fa-arrow-right"></i>
        </a>
        @endif
    </div>
</div>
@endsection @section('scripts')
<script>
    function changeMainImage(thumbnail, imageUrl) {
        // Update main image
        document.getElementById("main-image").src = imageUrl;

        // Update active thumbnail
        document
            .querySelectorAll(".thumbnail")
            .forEach((t) => t.classList.remove("active"));
        thumbnail.classList.add("active");
    }
    document.addEventListener("DOMContentLoaded", function () {
        // Thumbnail click functionality
        const thumbnails = document.querySelectorAll(".thumbnail");
        const mainImage = document.getElementById("main-image");

        thumbnails.forEach((thumb) => {
            thumb.addEventListener("click", function () {
                // Remove active class from all thumbnails
                thumbnails.forEach((t) => t.classList.remove("active"));

                // Add active class to clicked thumbnail
                this.classList.add("active");

                // Update main image
                mainImage.src = this.src;
            });
        });

        // Keyboard navigation
        document.addEventListener("keydown", function (e) {
            if (e.key === "ArrowLeft" && document.querySelector(".btn-prev")) {
                document.querySelector(".btn-prev").click();
            } else if (
                e.key === "ArrowRight" &&
                document.querySelector(".btn-next")
            ) {
                document.querySelector(".btn-next").click();
            }
        });
    });
</script>
@endsection
