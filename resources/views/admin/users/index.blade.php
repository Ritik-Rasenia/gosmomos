@extends('layouts.admin')
@section('title', 'Manage Users — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">User & Role Management</h4>
        <p class="text-muted mb-0">Control staff, customer, franchise partner, and delivery partner accounts.</p>
    </div>
</div>

<div class="admin-card p-4 mb-4">
    <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3 align-items-center">
        <div class="col-md-6 col-lg-4">
            <input type="text" name="search" class="form-control rounded-3" placeholder="Search by name, email, phone..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4 col-lg-3">
            <select name="role" class="form-select rounded-3">
                <option value="">All Roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role->slug }}" {{ request('role') == $role->slug ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-orange rounded-pill px-4"><i class="bi bi-search me-1"></i> Filter</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill px-3 ms-2">Reset</a>
        </div>
    </form>
</div>

<div class="admin-card p-4">
    @if($users->count())
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="table-light">
                    <th>User ID</th>
                    <th>User Details</th>
                    <th>Phone</th>
                    <th>Roles</th>
                    <th>Status</th>
                    <th>Registered</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td><span class="fw-bold">#{{ $user->id }}</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-orange-subtle text-orange d-flex align-items-center justify-content-center fw-bold" style="width:36px; height:36px;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <span class="fw-bold d-block">{{ $user->name }}</span>
                                <span class="text-muted small">{{ $user->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->phone ?? '—' }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge bg-dark rounded-pill">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'danger' }}-subtle text-{{ $user->status == 'active' ? 'success' : 'danger' }} px-3 py-2 rounded-3">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td class="small">{{ $user->created_at->format('d M Y, h:i A') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-dark btn-sm rounded-circle me-1" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-outline-danger btn-sm rounded-circle" title="Delete" onclick="confirmDelete({{ $user->id }})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="d-flex justify-content-end mt-3">
        {{ $users->links() }}
    </div>
    @else
    <div class="text-center text-muted py-5">
        <i class="bi bi-people fs-1 mb-2 d-block opacity-25"></i>
        <p class="mb-0">No users found matching the filter criteria.</p>
    </div>
    @endif
</div>

{{-- Hidden Delete Form --}}
<form id="delete-user-form" action="" method="POST" class="d-none">
    @csrf
</form>
@endsection

@section('scripts')
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this! The user's role and database references will be deleted.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF7A00',
        cancelButtonColor: '#0E101A',
        confirmButtonText: 'Yes, delete user!'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('delete-user-form');
            form.action = `/admin/users/delete/${id}`;
            form.submit();
        }
    });
}
</script>
@endsection
