@extends('layouts.admin')
@section('title', 'CMS Pages — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Content Management System</h4>
        <p class="text-muted mb-0">Manage static pages like About Us, Privacy Policy, Terms, and Refund Policy.</p>
    </div>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-orange rounded-pill px-4">
        <i class="bi bi-plus-circle me-1"></i> Add New Page
    </a>
</div>

<div class="admin-card p-4">
    @if($pages->count())
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="table-light">
                    <th>ID</th>
                    <th>Page Title</th>
                    <th>URL Slug</th>
                    <th>Status</th>
                    <th>Last Updated</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $page)
                <tr>
                    <td><span class="fw-bold">#{{ $page->id }}</span></td>
                    <td><span class="fw-bold">{{ $page->title }}</span></td>
                    <td><code>/pages/{{ $page->slug }}</code></td>
                    <td>
                        <span class="badge bg-{{ $page->is_active ? 'success' : 'secondary' }}-subtle text-{{ $page->is_active ? 'success' : 'secondary' }} px-3 py-2 rounded-3">
                            {{ $page->is_active ? 'Active' : 'Draft' }}
                        </span>
                    </td>
                    <td>{{ $page->updated_at->format('d M Y, h:i A') }}</td>
                    <td class="text-end">
                        <a href="/pages/{{ $page->slug }}" target="_blank" class="btn btn-outline-success btn-sm rounded-circle me-1" title="View">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-outline-dark btn-sm rounded-circle me-1" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-outline-danger btn-sm rounded-circle" title="Delete" onclick="confirmDelete({{ $page->id }})">
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
        <i class="bi bi-file-earmark-richtext fs-1 mb-2 d-block opacity-25"></i>
        <p class="mb-0">No pages added to CMS yet. Click "Add New Page" to begin.</p>
    </div>
    @endif
</div>

{{-- Hidden Delete Form --}}
<form id="delete-page-form" action="" method="POST" class="d-none">
    @csrf
</form>
@endsection

@section('scripts')
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Delete CMS Page?',
        text: "Are you sure? This will remove the page and return a 404 error if users try to visit this path.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF7A00',
        cancelButtonColor: '#0E101A',
        confirmButtonText: 'Yes, delete page!'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('delete-page-form');
            form.action = `/admin/pages/delete/${id}`;
            form.submit();
        }
    });
}
</script>
@endsection
