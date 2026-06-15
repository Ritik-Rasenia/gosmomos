@extends('layouts.admin')
@section('title', 'My Profile — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">My Profile Settings</h4>
        <p class="text-muted mb-0">Update your account information, email address, avatar, and password.</p>
    </div>
</div>

<div class="row g-4">
    {{-- Left side avatar card --}}
    <div class="col-lg-4">
        <div class="admin-card p-4 text-center">
            <div class="position-relative d-inline-block mb-3">
                <div style="width:130px; height:130px; border-radius:50%; overflow:hidden; border:4px solid white; box-shadow:0 8px 25px rgba(0,0,0,0.1); background:#FAF9F6; margin: 0 auto; display:flex; align-items:center; justify-content:center;">
                    @if($user->avatar)
                        <img src="{{ asset($user->avatar) }}" alt="Avatar" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <span style="font-size:45px; font-weight:700; color:var(--primary-color);">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    @endif
                </div>
            </div>
            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
            <p class="text-muted small mb-3">{{ $user->email }}</p>
            <span class="badge bg-orange-subtle text-orange px-3 py-2 fw-semibold">
                <i class="bi bi-shield-lock me-1"></i> Admin Account
            </span>
        </div>
    </div>

    {{-- Right side forms card --}}
    <div class="col-lg-8">
        <div class="admin-card p-4">
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center rounded-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger rounded-3 mb-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Personal Details</h6>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Full Name</label>
                        <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $user->name) }}" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Email Address</label>
                        <input type="email" name="email" class="form-control rounded-3" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Phone Number</label>
                        <input type="text" name="phone" class="form-control rounded-3" value="{{ old('phone', $user->phone) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Upload Avatar</label>
                        <input type="file" name="avatar" class="form-control rounded-3" accept="image/*">
                    </div>
                </div>

                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Security & Password (Leave blank to keep current)</h6>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">New Password</label>
                        <input type="password" name="password" class="form-control rounded-3" placeholder="Min. 6 characters">
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-3" placeholder="Confirm password">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success rounded-pill px-4 py-2">
                        <i class="bi bi-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
