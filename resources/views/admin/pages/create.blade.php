@extends('layouts.admin')
@section('title', 'Create CMS Page — GOS MOMO')

@section('styles')
<!-- Quill Rich Text Editor Theme -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<style>
    .ql-editor {
        min-height: 250px;
        font-family: 'Poppins', sans-serif;
    }
</style>
@endsection

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-dark btn-sm rounded-pill mb-2">
        <i class="bi bi-arrow-left"></i> Back to Pages
    </a>
    <h4 class="fw-bold">Create New Page</h4>
    <p class="text-muted">Draft a new content page with dynamic route binding and SEO rules.</p>
</div>

<div class="admin-card p-4">
    <form action="{{ route('admin.pages.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <h5 class="fw-bold text-orange border-bottom pb-2 mb-3"><i class="bi bi-file-earmark-text me-2"></i>Page Content</h5>
            
            <div class="col-md-8">
                <label class="form-label fw-semibold small">Page Title</label>
                <input type="text" name="title" class="form-control rounded-3" placeholder="e.g. About Us" value="{{ old('title') }}" required>
                @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check p-3 border rounded-3 bg-light w-100 mb-1">
                    <input class="form-check-input ms-0 me-2" type="checkbox" name="is_active" value="1" id="is_active" checked>
                    <label class="form-check-label fw-semibold" for="is_active">
                        Publish Immediately
                    </label>
                </div>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold small">Page Body</label>
                <!-- Editor Container -->
                <div id="editor"></div>
                <!-- Hidden Field for Submission -->
                <input type="hidden" name="content" id="content-input">
                @error('content') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <h5 class="fw-bold text-orange border-bottom pb-2 mt-5 mb-3"><i class="bi bi-search me-2"></i>SEO & Metadata</h5>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Meta Title</label>
                <input type="text" name="meta_title" class="form-control rounded-3" placeholder="If empty, matches page title" value="{{ old('meta_title') }}">
                @error('meta_title') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Meta Keywords</label>
                <input type="text" name="meta_keywords" class="form-control rounded-3" placeholder="Comma-separated words" value="{{ old('meta_keywords') }}">
                @error('meta_keywords') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold small">Meta Description</label>
                <textarea name="meta_description" class="form-control rounded-3" rows="3" placeholder="Summary for Google search results snippet...">{{ old('meta_description') }}</textarea>
                @error('meta_description') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-orange rounded-pill px-5">Create Page</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<!-- Quill Rich Text Editor Library -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Type page content here...'
        });

        const form = document.querySelector('form');
        form.onsubmit = function() {
            const contentInput = document.getElementById('content-input');
            // Populate hidden input with quill html
            contentInput.value = quill.root.innerHTML;
        };
    });
</script>
@endsection
