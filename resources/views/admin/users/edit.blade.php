@extends('layouts.admin')
@section('title', 'Edit User — GOS MOMO')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-dark btn-sm rounded-pill mb-2">
        <i class="bi bi-arrow-left"></i> Back to Users
    </a>
    <h4 class="fw-bold">Edit User Details</h4>
    <p class="text-muted">Modify name, email, status, and role/permission mappings.</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="admin-card p-4">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Full Name</label>
                        <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $user->name) }}" required>
                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Email Address</label>
                        <input type="email" name="email" class="form-control rounded-3" value="{{ old('email', $user->email) }}" required>
                        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Phone Number</label>
                        <input type="text" name="phone" class="form-control rounded-3" value="{{ old('phone', $user->phone) }}">
                        @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Account Status</label>
                        <select name="status" class="form-select rounded-3" required>
                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="suspended" {{ old('status', $user->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                        @error('status') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <hr class="my-4">

                    <!-- Role Selection -->
                    <h5 class="fw-bold text-orange mb-2"><i class="bi bi-shield-lock me-2"></i>Assign Roles</h5>
                    <p class="text-muted small mb-3">Roles define standard access groups for this user.</p>
                    
                    <div class="col-12 mb-4">
                        <div class="row g-3">
                            @foreach($roles as $role)
                            <div class="col-md-6">
                                <div class="form-check p-3 border rounded-3 bg-light">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}"
                                        {{ $user->roles->contains('id', $role->id) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="role_{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                    <span class="d-block small text-muted mt-1">Slug: <code>{{ $role->slug }}</code></span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Custom Permission Overrides -->
                    <h5 class="fw-bold text-orange mb-2"><i class="bi bi-key me-2"></i>Custom Permission Overrides</h5>
                    <p class="text-muted small mb-3">Direct permissions that override role defaults for this specific account.</p>
                    
                    <div class="col-12 mb-4">
                        <div class="row g-2">
                            @foreach($permissions as $perm)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm->id }}" id="perm_{{ $perm->id }}"
                                        {{ $user->permissions->contains('id', $perm->id) ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="perm_{{ $perm->id }}">
                                        {{ $perm->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-orange rounded-pill px-5">Save User Mapping</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Info side-card -->
    <div class="col-lg-4">
        <div class="admin-card p-4 bg-dark text-white">
            <h5 class="fw-bold text-orange border-bottom pb-2 mb-3"><i class="bi bi-info-circle me-2"></i>Security Note</h5>
            <p class="small text-light-50">Assigning role permissions grants immediate dashboard access. Ensure users have strong credentials and verified emails.</p>
            <p class="small text-light-50 mb-0">Role changes are tracked in the Activity Logs. Do not grant admin level roles to untrusted third-party contractors.</p>
        </div>
    </div>
</div>
@endsection
