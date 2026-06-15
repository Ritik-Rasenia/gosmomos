@extends('layouts.admin')
@section('title', 'Edit Blog Post — Admin')

@section('styles')
<style>
.cover-preview { width: 100%; height: 180px; object-fit: cover; border-radius: 12px; }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-pencil-square me-2 text-orange"></i>Edit Blog Post</h4>
        <p class="text-muted mb-0">Update article content, settings, and publish status.</p>
    </div>
    <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-dark rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        {{-- Main Content --}}
        <div class="col-lg-8">
            <div class="admin-card p-4 mb-4">
                <div class="mb-3">
                    <label class="form-label">Post Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $blog->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Excerpt / Short Description</label>
                    <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $blog->excerpt) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Full Content <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                              rows="16">{{ old('content', $blog->content) }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            <div class="admin-card p-4 mb-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-gear me-2 text-orange"></i>Settings</h6>
                <div class="mb-3">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="blog_category_id" class="form-select" required>
                        <option value="">— Select Category —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $blog->blog_category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Author</label>
                    <select name="user_id" class="form-select">
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ $blog->user_id == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_published" id="is_published"
                           {{ $blog->is_published ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="is_published">Published</label>
                    <div class="text-muted" style="font-size:11px;">
                        @if($blog->published_at) Published: {{ $blog->published_at->format('d M Y, h:i A') }}
                        @else Not published yet @endif
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-orange flex-grow-1 rounded-pill">
                        <i class="bi bi-check-circle me-1"></i> Update
                    </button>
                    <a href="{{ route('admin.blogs.show', $blog->id) }}" class="btn btn-outline-primary rounded-pill">
                        <i class="bi bi-eye"></i>
                    </a>
                </div>
            </div>

            <div class="admin-card p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-image me-2 text-orange"></i>Cover Image</h6>
                @if($blog->image_url)
                    <img src="{{ $blog->image_url }}" id="cover-preview" class="cover-preview mb-3" alt="Current cover">
                @else
                    <img id="cover-preview" class="cover-preview mb-3" alt="Preview" style="display:none;">
                @endif
                <input type="file" name="image" class="form-control" accept="image/*"
                       onchange="previewCover(this)">
                <div class="text-muted mt-1" style="font-size:11px;">Leave blank to keep current image.</div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
function previewCover(input) {
    const preview = document.getElementById('cover-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
