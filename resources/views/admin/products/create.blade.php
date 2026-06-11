@extends('layouts.admin')
@section('title', 'Add Product — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Add New Product</h4>
        <p class="text-muted mb-0">Create a new item in your food catalog.</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-success rounded-pill px-3">
        ← Back to List
    </a>
</div>

<div class="admin-card p-4">
    <form action="#" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Product Name *</label>
                <input type="text" name="name" class="form-control rounded-3" placeholder="e.g. Classic Chicken Steamed Momo" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Category *</label>
                <select name="category_id" class="form-select rounded-3" required>
                    @foreach(\App\Models\Category::all() as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Base Price (INR) *</label>
                <input type="number" name="base_price" class="form-control rounded-3" placeholder="99" min="0" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Spice Level</label>
                <select name="spice_level" class="form-select rounded-3">
                    <option value="0">Not Spicy</option>
                    <option value="1">Mild</option>
                    <option value="2">Medium</option>
                    <option value="3">Extra Hot</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold small">Short Description</label>
                <input type="text" name="short_description" class="form-control rounded-3" placeholder="Brief tagline shown on the cards">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold small">Detailed Description</label>
                <textarea name="description" class="form-control rounded-3" rows="4" placeholder="Detailed food description..."></textarea>
            </div>
            <div class="col-md-4">
                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" name="is_veg" id="is_veg" checked>
                    <label class="form-check-label fw-semibold small" for="is_veg">Is Vegetarian</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" name="is_bestseller" id="is_bestseller">
                    <label class="form-check-label fw-semibold small" for="is_bestseller">Mark Bestseller</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" name="is_new" id="is_new" checked>
                    <label class="form-check-label fw-semibold small" for="is_new">Mark New Arrival</label>
                </div>
            </div>
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-success rounded-pill px-4">Create Product</button>
            </div>
        </div>
    </form>
</div>
@endsection
