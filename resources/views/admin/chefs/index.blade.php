@extends('layouts.admin')
@section('title', 'Chef Management — Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-people-fill me-2 text-orange"></i>Chef Management</h4>
        <p class="text-muted mb-0">Create, edit, and organize profile cards for the Expert Chefs section on the homepage.</p>
    </div>
    <a href="{{ route('admin.chefs.create') }}" class="btn btn-orange rounded-pill px-4">
        <i class="bi bi-plus-circle me-1"></i> Add New Chef
    </a>
</div>

<div class="admin-card p-4">
    @if($chefs->count())
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="table-light">
                    <th style="width:80px;">Avatar</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Bio</th>
                    <th>Sort Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chefs as $chef)
                <tr>
                    <td>
                        <img src="{{ $chef->image_url }}"
                             style="width:50px;height:50px;object-fit:cover;border-radius:50%;border: 2px solid #FF7A00;" alt="avatar">
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ $chef->name }}</div>
                        <div class="text-muted small">
                            @if($chef->facebook_url)<a href="{{ $chef->facebook_url }}" target="_blank" class="me-1 text-primary"><i class="bi bi-facebook"></i></a>@endif
                            @if($chef->instagram_url)<a href="{{ $chef->instagram_url }}" target="_blank" class="me-1 text-danger"><i class="bi bi-instagram"></i></a>@endif
                            @if($chef->twitter_url)<a href="{{ $chef->twitter_url }}" target="_blank" class="text-info"><i class="bi bi-twitter-x"></i></a>@endif
                        </div>
                    </td>
                    <td><span class="badge bg-light text-dark fw-semibold">{{ $chef->role }}</span></td>
                    <td class="small text-muted" style="max-width: 300px;">{{ Str::limit($chef->bio ?? 'No bio description provided.', 100) }}</td>
                    <td>
                        <span class="badge bg-secondary-subtle text-secondary fw-bold">{{ $chef->sort_order }}</span>
                    </td>
                    <td>
                        <form action="{{ route('admin.chefs.toggle-active', $chef->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm border-0 bg-transparent p-0" title="Click to toggle status">
                                @if($chef->is_active)
                                    <span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Active</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-circle me-1"></i>Inactive</span>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.chefs.edit', $chef->id) }}" class="btn btn-sm btn-outline-warning rounded-2" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.chefs.destroy', $chef->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirmDelete(this, 'Delete Chef Profile?', 'Are you sure you want to delete this chef profile?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-2" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $chefs->links() }}</div>
    @else
    <div class="text-center py-5 text-muted">
        <i class="bi bi-people fs-1 d-block mb-3 opacity-25"></i>
        <h5 class="fw-bold">No chef profiles yet</h5>
        <p>Add chef profiles to display them dynamically on your homepage!</p>
        <a href="{{ route('admin.chefs.create') }}" class="btn btn-orange rounded-pill px-4 mt-2">
            <i class="bi bi-plus me-1"></i> Add Your First Chef
        </a>
    </div>
    @endif
</div>
@endsection
