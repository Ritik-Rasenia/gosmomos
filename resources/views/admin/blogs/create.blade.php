@extends('layouts.admin')
@section('title', 'Create Blog Post — Admin')

@section('styles')
<style>
.ql-editor { min-height: 300px; font-size: 14px; }
.cover-preview { width: 100%; height: 180px; object-fit: cover; border-radius: 12px; display: none; }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-plus-circle me-2 text-orange"></i>Create Blog Post</h4>
        <p class="text-muted mb-0">Write and publish a new article for the Expert Chefs Blog.</p>
    </div>
    <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-dark rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back to Blogs
    </a>
</div>

<form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        {{-- Main Content --}}
        <div class="col-lg-8">
            <div class="admin-card p-4 mb-4">
                <div class="mb-3">
                    <label class="form-label">Post Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                           placeholder="e.g. The Secret Behind Perfect Steamed Momos..." value="{{ old('title') }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Excerpt / Short Description</label>
                    <textarea name="excerpt" class="form-control" rows="2"
                              placeholder="A brief teaser shown on listing pages (max 500 chars)...">{{ old('excerpt') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Full Content <span class="text-danger">*</span></label>
                    <textarea name="content" id="content-editor" class="form-control @error('content') is-invalid @enderror"
                              rows="14" placeholder="Write your full article here...">{{ old('content') }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Publish Settings --}}
            <div class="admin-card p-4 mb-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-gear me-2 text-orange"></i>Publish Settings</h6>
                <div class="mb-3">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="blog_category_id" class="form-select" required>
                        <option value="">— Select Category —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('blog_category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Author</label>
                    <select name="user_id" class="form-select">
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ $author->id === auth()->id() ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_published" id="is_published"
                           {{ old('is_published') ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="is_published">Publish Immediately</label>
                    <div class="text-muted" style="font-size:11px;">If unchecked, post will be saved as Draft.</div>
                </div>
                <button type="submit" class="btn btn-orange w-100 rounded-pill">
                    <i class="bi bi-cloud-upload me-1"></i> Save Post
                </button>
            </div>

            {{-- Cover Image --}}
            <div class="admin-card p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-image me-2 text-orange"></i>Cover Image</h6>
                <img id="cover-preview" class="cover-preview mb-3" alt="Preview">
                <input type="file" name="image" id="image-input" class="form-control" accept="image/*"
                       onchange="previewCover(this)">
                <div class="text-muted mt-2" style="font-size:11px;">Recommended: 1200×630px, max 3MB</div>
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
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
