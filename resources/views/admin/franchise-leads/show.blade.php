@extends('layouts.admin')
@section('title', 'Franchise Lead Detail — Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-briefcase me-2 text-orange"></i>Franchise Lead Detail</h4>
        <p class="text-muted mb-0">Full details for this franchise application.</p>
    </div>
    <a href="{{ route('admin.franchise-leads.index') }}" class="btn btn-outline-dark rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card p-4 mb-4">
            {{-- Applicant Header --}}
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                     style="width:60px;height:60px;min-width:60px;background:linear-gradient(135deg,#6f42c1,#9b59b6);font-size:22px;">
                    {{ strtoupper(substr($lead->name, 0, 1)) }}
                </div>
                <div>
                    <h5 class="fw-bold mb-0">{{ $lead->name }}</h5>
                    <div class="text-muted small">
                        <a href="mailto:{{ $lead->email }}" class="text-decoration-none me-3">
                            <i class="bi bi-envelope me-1"></i>{{ $lead->email }}
                        </a>
                        <a href="tel:{{ $lead->phone }}" class="text-decoration-none">
                            <i class="bi bi-telephone me-1"></i>{{ $lead->phone }}
                        </a>
                    </div>
                </div>
                @php $lc = ['new'=>'primary','contacted'=>'info','site_visit'=>'warning','approved'=>'success','rejected'=>'danger']; @endphp
                <span class="badge bg-{{ $lc[$lead->status] ?? 'secondary' }} rounded-pill ms-auto px-3 py-2">
                    {{ ucfirst(str_replace('_',' ',$lead->status)) }}
                </span>
            </div>

            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="p-3 rounded-3" style="background:#f8f9fa;">
                        <div class="text-muted small fw-semibold mb-1"><i class="bi bi-shop me-1 text-orange"></i>Franchise Type</div>
                        <div class="fw-bold">{{ ucfirst($lead->franchise_type) }}</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="p-3 rounded-3" style="background:#f8f9fa;">
                        <div class="text-muted small fw-semibold mb-1"><i class="bi bi-geo-alt me-1 text-orange"></i>Location</div>
                        <div class="fw-bold">{{ $lead->city }}, {{ $lead->state }}</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="p-3 rounded-3" style="background:#f8f9fa;">
                        <div class="text-muted small fw-semibold mb-1"><i class="bi bi-currency-rupee me-1 text-orange"></i>Investment Budget</div>
                        <div class="fw-bold">{{ $lead->investment_budget }}</div>
                    </div>
                </div>
                @if($lead->experience)
                <div class="col-sm-6">
                    <div class="p-3 rounded-3" style="background:#f8f9fa;">
                        <div class="text-muted small fw-semibold mb-1"><i class="bi bi-award me-1 text-orange"></i>Experience</div>
                        <div class="fw-bold">{{ $lead->experience }}</div>
                    </div>
                </div>
                @endif
                @if($lead->follow_up_date)
                <div class="col-sm-6">
                    <div class="p-3 rounded-3" style="background:#f8f9fa;">
                        <div class="text-muted small fw-semibold mb-1"><i class="bi bi-calendar-check me-1 text-orange"></i>Follow-up Date</div>
                        <div class="fw-bold">{{ \Carbon\Carbon::parse($lead->follow_up_date)->format('d M Y') }}</div>
                    </div>
                </div>
                @endif
                <div class="col-sm-6">
                    <div class="p-3 rounded-3" style="background:#f8f9fa;">
                        <div class="text-muted small fw-semibold mb-1"><i class="bi bi-clock me-1 text-orange"></i>Applied On</div>
                        <div class="fw-bold">{{ $lead->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                </div>
            </div>

            @if($lead->message)
            <div class="mt-4">
                <div class="text-muted small fw-semibold mb-2"><i class="bi bi-chat-text me-1 text-orange"></i>Applicant Message</div>
                <div class="p-3 rounded-3 border-start border-4 border-warning" style="background:#fffbf5; line-height:1.6;">
                    {{ $lead->message }}
                </div>
            </div>
            @endif

            @if($lead->admin_notes)
            <div class="mt-3">
                <div class="text-muted small fw-semibold mb-2"><i class="bi bi-sticky me-1 text-orange"></i>Admin Notes</div>
                <div class="p-3 rounded-3 border-start border-4 border-info" style="background:#f0f9ff; line-height:1.6;">
                    {{ $lead->admin_notes }}
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="col-lg-4">
        {{-- Update Status --}}
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-pencil-square me-2 text-orange"></i>Update Pipeline</h6>
            <form action="{{ route('admin.franchise-leads.status', $lead->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pipeline Stage</label>
                    <select name="status" class="form-select">
                        @foreach(['new' => 'New Lead', 'contacted' => 'Contacted', 'site_visit' => 'Site Visit Scheduled', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $val => $label)
                            <option value="{{ $val }}" {{ $lead->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Follow-up Date</label>
                    <input type="date" name="follow_up_date" class="form-control"
                           value="{{ $lead->follow_up_date ? $lead->follow_up_date->format('Y-m-d') : '' }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Admin Notes</label>
                    <textarea name="admin_notes" class="form-control" rows="3"
                              placeholder="Internal notes...">{{ $lead->admin_notes }}</textarea>
                </div>
                <button type="submit" class="btn btn-orange w-100 rounded-pill">
                    <i class="bi bi-check-circle me-1"></i> Save Changes
                </button>
            </form>
        </div>

        <div class="admin-card p-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-lightning me-2 text-orange"></i>Quick Actions</h6>
            <div class="d-flex flex-column gap-2">
                <a href="mailto:{{ $lead->email }}" class="btn btn-outline-primary rounded-pill w-100">
                    <i class="bi bi-envelope me-1"></i> Send Email
                </a>
                <a href="tel:{{ $lead->phone }}" class="btn btn-outline-success rounded-pill w-100">
                    <i class="bi bi-telephone me-1"></i> Call Applicant
                </a>
                <form action="{{ route('admin.franchise-leads.destroy', $lead->id) }}" method="POST"
                      onsubmit="return confirmDelete(this, 'Delete Franchise Lead?', 'Are you sure you want to delete this lead application permanently?')">
                    @csrf
                    <button class="btn btn-outline-danger rounded-pill w-100">
                        <i class="bi bi-trash me-1"></i> Delete Lead
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
