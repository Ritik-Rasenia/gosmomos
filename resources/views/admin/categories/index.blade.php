@extends('layouts.admin')
@section('title', 'Manage Categories — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Categories</h4>
        <p class="text-muted mb-0">Manage catalog menu categories and icons.</p>
    </div>
    <button class="btn btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        <i class="bi bi-plus-circle me-1"></i> Add Category
    </button>
</div>

<div class="admin-card p-4">
    @php $categories = \App\Models\Category::withCount('products')->get(); @endphp
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="table-light">
                    <th>Icon</th>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Product Count</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                <tr>
                    <td><i class="bi {{ $cat->icon ?? 'bi-circle' }} fs-4 text-success"></i></td>
                    <td class="fw-bold">{{ $cat->name }}</td>
                    <td><code>{{ $cat->slug }}</code></td>
                    <td><span class="badge bg-success-subtle text-success">{{ $cat->products_count }} items</span></td>
                    <td>
                        <span class="badge bg-{{ $cat->is_active ? 'success' : 'secondary' }}-subtle text-{{ $cat->is_active ? 'success' : 'secondary' }}">
                            {{ $cat->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-outline-primary btn-sm rounded-circle" title="Edit"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-outline-danger btn-sm rounded-circle" title="Delete"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 bg-success text-white py-3" style="border-radius:16px 16px 0 0;">
                <h5 class="modal-title fw-bold">Add Category</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Category Name *</label>
                        <input type="text" name="name" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Bootstrap Icon Class (optional)</label>
                        <input type="text" name="icon" class="form-control rounded-3" placeholder="bi-grid">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">Create Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
