@extends('layouts.admin')
@section('title', 'Add Chef Profile — Admin')

@section('styles')
<style>
.avatar-preview { width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 3px solid #FF7A00; display: none; }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-person-plus me-2 text-orange"></i>Add Chef Profile</h4>
        <p class="text-muted mb-0">Create a new professional profile card for the homepage expert chefs section.</p>
    </div>
    <a href="{{ route('admin.chefs.index') }}" class="btn btn-outline-dark rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back to Chefs
    </a>
</div>

<form action="{{ route('admin.chefs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        {{-- Main Info --}}
        <div class="col-lg-8">
            <div class="admin-card p-4 mb-4">
                <h6 class="fw-bold mb-3 text-uppercase" style="letter-spacing: 0.5px;"><i class="bi bi-person me-2 text-orange"></i>General Details</h6>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   placeholder="e.g. Chef Harish Joshi" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Professional Role <span class="text-danger">*</span></label>
                            <input type="text" name="role" class="form-control @error('role') is-invalid @enderror"
                                   placeholder="e.g. Head Pastry Chef / Sous Chef" value="{{ old('role') }}" required>
                            @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Chef Biography / Experience Details</label>
                    <textarea name="bio" class="form-control" rows="5"
                              placeholder="Brief background about the chef's culinary journey, specialties, or awards...">{{ old('bio') }}</textarea>
                </div>
            </div>

            <div class="admin-card p-4">
                <h6 class="fw-bold mb-3 text-uppercase" style="letter-spacing: 0.5px;"><i class="bi bi-share me-2 text-orange"></i>Social Media Handles</h6>
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-facebook me-1 text-primary"></i> Facebook Profile URL</label>
                    <input type="url" name="facebook_url" class="form-control" placeholder="https://facebook.com/username" value="{{ old('facebook_url') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-instagram me-1 text-danger"></i> Instagram Profile URL</label>
                    <input type="url" name="instagram_url" class="form-control" placeholder="https://instagram.com/username" value="{{ old('instagram_url') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-twitter-x me-1 text-dark"></i> Twitter / X Profile URL</label>
                    <input type="url" name="twitter_url" class="form-control" placeholder="https://x.com/username" value="{{ old('twitter_url') }}">
                </div>
            </div>
        </div>

        {{-- Sidebar Settings --}}
        <div class="col-lg-4">
            <div class="admin-card p-4 mb-4">
                <h6 class="fw-bold mb-3 text-uppercase" style="letter-spacing: 0.5px;"><i class="bi bi-sliders me-2 text-orange"></i>Settings</h6>
                
                <div class="mb-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', 0) }}">
                    <div class="text-muted small mt-1" style="font-size:11px;">Lowest number appears first.</div>
                </div>

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="is_active">Publish Status (Active)</label>
                    <div class="text-muted small" style="font-size:11px;">If inactive, they will not be shown on the homepage.</div>
                </div>

                <button type="submit" class="btn btn-orange w-100 rounded-pill py-2.5">
                    <i class="bi bi-cloud-upload me-1"></i> Save Chef Profile
                </button>
            </div>

            <div class="admin-card p-4 text-center">
                <h6 class="fw-bold mb-3 text-uppercase text-start" style="letter-spacing: 0.5px;"><i class="bi bi-image me-2 text-orange"></i>Chef Avatar</h6>
                <div class="d-flex justify-content-center mb-3">
                    <img id="avatar-preview" class="avatar-preview" alt="Preview">
                </div>
                <input type="file" name="image" id="image-input" class="form-control" accept="image/*" onchange="previewAvatar(this)">
                <div class="text-muted mt-2 text-start" style="font-size:11px;">Supported format: JPG, PNG, WEBP. Max 3MB.</div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
function previewAvatar(input) {
    const preview = document.getElementById('avatar-preview');
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
