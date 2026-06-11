@extends('layouts.admin')
@section('title', 'System Settings — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">System Settings</h4>
        <p class="text-muted mb-0">Configure store settings, contact details, brand headers, and SEO rules.</p>
    </div>
</div>

<div class="admin-card p-4">
    <form action="#" method="POST">
        @csrf
        <div class="row g-3">
            <h5 class="fw-bold text-success border-bottom pb-2">General Info</h5>
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Brand Name</label>
                <input type="text" class="form-control rounded-3" value="GOS MOMO">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Tagline</label>
                <input type="text" class="form-control rounded-3" value="The Taste India Will Queue For">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Contact Phone</label>
                <input type="text" class="form-control rounded-3" value="+91 88888 77777">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Contact Email</label>
                <input type="email" class="form-control rounded-3" value="info@gosmomo.com">
            </div>

            <h5 class="fw-bold text-success border-bottom pb-2 mt-4">SEO Details</h5>
            <div class="col-12">
                <label class="form-label fw-semibold small">Default Meta Title</label>
                <input type="text" class="form-control rounded-3" value="GOS MOMO — Premium Hygienic Street Momos in Lucknow & Noida">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold small">Default Meta Description</label>
                <textarea class="form-control rounded-3" rows="3">Premium, hygienic and crispy street-style momos in Lucknow Hazratganj & Noida. scaling with low-cost carts and franchise kiosks. order online today!</textarea>
            </div>
            <div class="col-12 mt-4">
                <button type="button" class="btn btn-success rounded-pill px-4">Save All Configuration</button>
            </div>
        </div>
    </form>
</div>
@endsection
