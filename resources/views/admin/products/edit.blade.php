@extends('layouts.admin')
@section('title', 'Edit Product — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Edit Product</h4>
        <p class="text-muted mb-0">Modify product properties and variants.</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-success rounded-pill px-3">
        ← Back to List
    </a>
</div>

<div class="admin-card p-4">
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Product Name *</label>
                <input type="text" name="name" class="form-control rounded-3" value="{{ $product->name }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Category *</label>
                <select name="category_id" class="form-select rounded-3" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Base Price (INR) *</label>
                <input type="number" name="base_price" class="form-control rounded-3" value="{{ (int)$product->base_price }}" min="0" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Spice Level</label>
                <select name="spice_level" class="form-select rounded-3">
                    <option value="0" {{ $product->spice_level == 0 ? 'selected' : '' }}>Not Spicy</option>
                    <option value="1" {{ $product->spice_level == 1 ? 'selected' : '' }}>Mild</option>
                    <option value="2" {{ $product->spice_level == 2 ? 'selected' : '' }}>Medium</option>
                    <option value="3" {{ $product->spice_level == 3 ? 'selected' : '' }}>Extra Hot</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold small">Product Image</label>
                <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                @if($product->image_url)
                    <div class="mt-2">
                        <span class="text-muted d-block mb-1" style="font-size:11px;">Current Image:</span>
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width:100px; height:70px; border-radius:8px; object-fit:cover; border:1px solid rgba(0,0,0,0.08);" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1625220194771-7ebedd0b4d11?auto=format&fit=crop&w=200&q=80';">
                    </div>
                @endif
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold small">Short Description *</label>
                <input type="text" name="short_description" class="form-control rounded-3" value="{{ $product->short_description }}" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold small">Detailed Description</label>
                <textarea name="description" class="form-control rounded-3" rows="4">{{ $product->description }}</textarea>
            </div>
            <div class="col-md-3">
                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" name="is_veg" id="is_veg" {{ $product->is_veg ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold small" for="is_veg">Is Vegetarian</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" name="is_bestseller" id="is_bestseller" {{ $product->is_bestseller ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold small" for="is_bestseller">Mark Bestseller</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" name="is_new" id="is_new" {{ $product->is_new ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold small" for="is_new">Mark New Arrival</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" name="is_available" id="is_available" {{ $product->is_available ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold small" for="is_available">Is Available</label>
                </div>
            </div>

            <!-- Variants section -->
            <div class="col-12 mt-4">
                <h5 class="fw-bold mb-3 font-outfit text-orange">Product Size/Price Variants</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="variants-table">
                        <thead class="table-light">
                            <tr>
                                <th>Variant Name (e.g. Half (6 Pcs), Full (10 Pcs))</th>
                                <th>Price (INR)</th>
                                <th>Available</th>
                                <th style="width: 80px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product->variants as $index => $variant)
                            <tr>
                                <td>
                                    <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                                    <input type="text" name="variants[{{ $index }}][name]" class="form-control form-control-sm rounded-3" value="{{ $variant->name }}" required>
                                </td>
                                <td>
                                    <input type="number" name="variants[{{ $index }}][price]" class="form-control form-control-sm rounded-3" value="{{ (int)$variant->price }}" required min="0">
                                </td>
                                <td>
                                    <input type="hidden" name="variants[{{ $index }}][is_available_val]" value="0">
                                    <div class="form-check form-switch m-0">
                                        <input class="form-check-input" type="checkbox" name="variants[{{ $index }}][is_available]" value="1" {{ $variant->is_available ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill" onclick="removeVariantRow(this)">Remove</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-sm btn-outline-orange rounded-pill mb-3" onclick="addVariantRow()">+ Add Custom Variant</button>
            </div>

            <div class="col-12 mt-4 border-top pt-4">
                <button type="submit" class="btn btn-success rounded-pill px-4">Update Product</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
let variantIndex = {{ $product->variants->count() }};
function addVariantRow() {
    const tbody = document.querySelector('#variants-table tbody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>
            <input type="text" name="variants[${variantIndex}][name]" class="form-control form-control-sm rounded-3" placeholder="e.g. Full (10 Pcs)" required>
        </td>
        <td>
            <input type="number" name="variants[${variantIndex}][price]" class="form-control form-control-sm rounded-3" placeholder="99" required min="0">
        </td>
        <td>
            <input type="hidden" name="variants[${variantIndex}][is_available_val]" value="0">
            <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" name="variants[${variantIndex}][is_available]" value="1" checked>
            </div>
        </td>
        <td>
            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill" onclick="removeVariantRow(this)">Remove</button>
        </td>
    `;
    tbody.appendChild(row);
    variantIndex++;
}

function removeVariantRow(btn) {
    btn.closest('tr').remove();
}
</script>
@endsection
