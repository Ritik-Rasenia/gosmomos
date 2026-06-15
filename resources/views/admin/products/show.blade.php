@extends('layouts.admin')
@section('title', 'Product Details — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">{{ $product->name }}</h4>
        <p class="text-muted mb-0">Full specifications, pricing, and variants.</p>
    </div>
    <div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-light rounded-pill px-3 me-2">
            ← Back to List
        </a>
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-orange rounded-pill px-4">
            <i class="bi bi-pencil me-1"></i> Edit Product
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Main Info Card -->
    <div class="col-lg-8">
        <div class="admin-card p-4 h-100">
            <h5 class="fw-bold mb-3 border-bottom pb-2 font-outfit text-orange">Product Specifications</h5>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <span class="text-muted d-block small">Category</span>
                    <span class="fw-semibold">{{ $product->category->name }}</span>
                </div>
                <div class="col-md-6">
                    <span class="text-muted d-block small">Base Price</span>
                    <span class="fw-bold text-success fs-5">₹{{ number_format($product->base_price, 0) }}</span>
                </div>
                <div class="col-md-6">
                    <span class="text-muted d-block small">Spice Level</span>
                    <span>
                        @if($product->spice_level == 0)
                            <span class="badge bg-secondary-subtle text-secondary">Not Spicy</span>
                        @elseif($product->spice_level == 1)
                            <span class="badge bg-info-subtle text-info">Mild</span>
                        @elseif($product->spice_level == 2)
                            <span class="badge bg-warning-subtle text-warning">Medium</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger">Extra Hot</span>
                        @endif
                    </span>
                </div>
                <div class="col-md-6">
                    <span class="text-muted d-block small">Food Preference</span>
                    <span>
                        @if($product->is_veg)
                            <span class="badge bg-success-subtle text-success">Veg</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger">Non-Veg</span>
                        @endif
                    </span>
                </div>
                <div class="col-md-6">
                    <span class="text-muted d-block small">Status Badges</span>
                    <div class="d-flex gap-2">
                        @if($product->is_bestseller)
                            <span class="badge bg-danger">Bestseller</span>
                        @endif
                        @if($product->is_new)
                            <span class="badge bg-warning text-dark">New Arrival</span>
                        @endif
                        @if(!$product->is_bestseller && !$product->is_new)
                            <span class="text-muted small">—</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <span class="text-muted d-block small">Availability Status</span>
                    <span>
                        @if($product->is_available)
                            <span class="badge bg-success-subtle text-success">Available in Catalog</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">Hidden / Unavailable</span>
                        @endif
                    </span>
                </div>

                <div class="col-12 mt-3 border-top pt-3">
                    <span class="text-muted d-block small">Short Description</span>
                    <p class="mb-3 fw-medium text-dark">{{ $product->short_description }}</p>
                </div>
                
                <div class="col-12">
                    <span class="text-muted d-block small">Detailed Description</span>
                    <p class="mb-0 text-muted-dark" style="white-space: pre-wrap;">{{ $product->description ?? 'No detailed description provided.' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Image Card -->
    <div class="col-lg-4">
        <div class="admin-card p-4 h-100 text-center d-flex flex-column justify-content-center align-items-center">
            <h5 class="fw-bold mb-3 border-bottom pb-2 w-100 font-outfit text-orange">Product Photo</h5>
            <div class="w-100 position-relative mb-3" style="max-width: 300px;">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-100 rounded-3 shadow-sm" style="height: 200px; object-fit: cover;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1625220194771-7ebedd0b4d11?auto=format&fit=crop&w=400&q=80';">
            </div>
            <span class="text-muted small">Updated: {{ $product->updated_at->format('d M Y, h:i A') }}</span>
        </div>
    </div>

    <!-- Variants Table -->
    <div class="col-12 mt-4">
        <div class="admin-card p-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2 font-outfit text-orange">Size & Price Variants</h5>
            @if($product->variants->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="table-light">
                                <th>Variant Name</th>
                                <th>Price</th>
                                <th>Availability</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product->variants as $variant)
                            <tr>
                                <td class="fw-bold">{{ $variant->name }}</td>
                                <td class="fw-bold text-success">₹{{ number_format($variant->price, 0) }}</td>
                                <td>
                                    <span class="badge bg-{{ $variant->is_available ? 'success' : 'secondary' }}-subtle text-{{ $variant->is_available ? 'success' : 'secondary' }}">
                                        {{ $variant->is_available ? 'Available' : 'Unavailable' }}
                                    </span>
                                </td>
                                <td>{{ $variant->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-4">
                    <i class="bi bi-tag fs-1 mb-2 d-block opacity-25"></i>
                    <p class="mb-0">No custom size/price variants created for this product. Using base price.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
