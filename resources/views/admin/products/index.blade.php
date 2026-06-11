@extends('layouts.admin')
@section('title', 'Manage Products — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Products Catalog</h4>
        <p class="text-muted mb-0">Manage all momo dishes, beverage variants, and pricing.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success rounded-pill px-4">
        <i class="bi bi-plus-circle me-1"></i> Add New Product
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-3 mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="admin-card p-4">
    @if($products->count())
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="table-light">
                    <th>Product</th>
                    <th>Category</th>
                    <th>Base Price</th>
                    <th>Veg/Non-Veg</th>
                    <th>Bestseller / New</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $prod)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if($prod->image_url)
                                <img src="{{ $prod->image_url }}" alt="{{ $prod->name }}" style="width:40px; height:40px; border-radius:8px; object-fit:cover;">
                            @else
                                <div style="width:40px; height:40px; border-radius:8px; background:linear-gradient(135deg,#0F5132,#D4A017); display:flex; align-items:center; justify-content:center; font-size:20px;">🥟</div>
                            @endif
                            <div>
                                <span class="fw-bold d-block">{{ $prod->name }}</span>
                                <span class="text-muted small">{{ $prod->variants->count() }} variant(s)</span>
                            </div>
                        </div>
                    </td>
                    <td>{{ $prod->category->name }}</td>
                    <td class="fw-bold text-success">₹{{ number_format($prod->base_price, 0) }}</td>
                    <td>
                        <span class="badge bg-{{ $prod->is_veg ? 'success' : 'danger' }}-subtle text-{{ $prod->is_veg ? 'success' : 'danger' }}">
                            {{ $prod->is_veg ? 'Veg' : 'Non-Veg' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            @if($prod->is_bestseller)
                                <span class="badge bg-danger">Bestseller</span>
                            @endif
                            @if($prod->is_new)
                                <span class="badge bg-warning text-dark">New</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-{{ $prod->is_available ? 'success' : 'secondary' }}-subtle text-{{ $prod->is_available ? 'success' : 'secondary' }}">
                            {{ $prod->is_available ? 'Available' : 'Unavailable' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-outline-danger btn-sm rounded-circle" title="Delete" onclick="deleteProduct({{ $prod->id }})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center text-muted py-5">
        <i class="bi bi-box-x fs-1 mb-2 d-block opacity-25"></i>
        <p class="mb-0">No products added yet.</p>
    </div>
    @endif
</div>

{{-- Hidden Delete Form --}}
<form id="delete-product-form" action="" method="POST" class="d-none">
    @csrf
</form>
@endsection

@section('scripts')
<script>
function deleteProduct(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        const form = document.getElementById('delete-product-form');
        form.action = `/admin/products/delete/${id}`;
        form.submit();
    }
}
</script>
@endsection
