@extends('layouts.app') @section('title', 'Add Gallery Item')
@section('content')
<div class="gallery-form-container">
    <h1>Add New Gallery Item</h1>

    <form
        action="{{ route('gallery.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="gallery-form"
    >
        @csrf

        <div class="form-group">
            <label for="title">Title*</label>
            <input type="text" id="title" name="title" required />
        </div>

        <div class="form-group">
            <label for="description">Description*</label>
            <textarea
                id="description"
                name="description"
                rows="5"
                required
            ></textarea>
        </div>

        <div class="form-group">
            <label for="image">Image*</label>
            <input
                type="file"
                id="image"
                name="image"
                accept="image/*"
                required
            />
            <small>Max size: 2MB | Formats: JPEG, PNG, JPG, GIF</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="submit-btn">
                Submit for Approval
            </button>
            <a href="{{ route('gallery.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>

<style>
    .gallery-form-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .gallery-form-container h1 {
        margin-bottom: 2rem;
        color: #2d3748;
    }

    .gallery-form {
        display: grid;
        gap: 1.5rem;
    }

    .form-group {
        display: grid;
        gap: 0.5rem;
    }

    .form-group label {
        font-weight: 500;
        color: #4a5568;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        font-size: 1rem;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-group small {
        font-size: 0.8rem;
        color: #718096;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 1rem;
    }

    .submit-btn,
    .cancel-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .submit-btn {
        background: #4f46e5;
        color: white;
        border: none;
    }

    .submit-btn:hover {
        background: #4338ca;
    }

    .cancel-btn {
        background: white;
        color: #4a5568;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .cancel-btn:hover {
        background: #f7fafc;
    }
</style>
@endsection
