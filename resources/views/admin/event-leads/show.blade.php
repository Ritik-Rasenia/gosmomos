@extends('layouts.admin')
@section('title', 'Event Lead Detail — Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-calendar-event me-2 text-orange"></i>Catering / Event Lead</h4>
        <p class="text-muted mb-0">Full details for this inquiry.</p>
    </div>
    <a href="{{ route('admin.event-leads.index') }}" class="btn btn-outline-dark rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="row g-4">
    {{-- Lead Details --}}
    <div class="col-lg-8">
        <div class="admin-card p-4 mb-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                     style="width:60px;height:60px;min-width:60px;background:linear-gradient(135deg,#FF7A00,#E26C00);font-size:22px;">
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
                @php $lc = ['new'=>'primary','contacted'=>'info','booked'=>'success','cancelled'=>'danger']; @endphp
                <span class="badge bg-{{ $lc[$lead->status] ?? 'secondary' }} rounded-pill ms-auto px-3 py-2">
                    {{ ucfirst($lead->status) }}
                </span>
            </div>

            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="p-3 rounded-3" style="background:#f8f9fa;">
                        <div class="text-muted small fw-semibold mb-1"><i class="bi bi-star me-1 text-orange"></i>Event Type</div>
                        <div class="fw-bold">{{ ucfirst(str_replace('_', ' ', $lead->event_type)) }}</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="p-3 rounded-3" style="background:#f8f9fa;">
                        <div class="text-muted small fw-semibold mb-1"><i class="bi bi-calendar me-1 text-orange"></i>Event Date</div>
                        <div class="fw-bold">{{ \Carbon\Carbon::parse($lead->event_date)->format('D, d M Y') }}</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="p-3 rounded-3" style="background:#f8f9fa;">
                        <div class="text-muted small fw-semibold mb-1"><i class="bi bi-people me-1 text-orange"></i>Guest Count</div>
                        <div class="fw-bold">{{ number_format($lead->guest_count) }} Guests</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="p-3 rounded-3" style="background:#f8f9fa;">
                        <div class="text-muted small fw-semibold mb-1"><i class="bi bi-geo-alt me-1 text-orange"></i>City</div>
                        <div class="fw-bold">{{ $lead->city }}</div>
                    </div>
                </div>
                @if($lead->budget)
                <div class="col-sm-6">
                    <div class="p-3 rounded-3" style="background:#f8f9fa;">
                        <div class="text-muted small fw-semibold mb-1"><i class="bi bi-currency-rupee me-1 text-orange"></i>Budget</div>
                        <div class="fw-bold">₹{{ number_format($lead->budget, 0) }}</div>
                    </div>
                </div>
                @endif
                <div class="col-sm-6">
                    <div class="p-3 rounded-3" style="background:#f8f9fa;">
                        <div class="text-muted small fw-semibold mb-1"><i class="bi bi-clock me-1 text-orange"></i>Submitted</div>
                        <div class="fw-bold">{{ $lead->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                </div>
            </div>

            @if($lead->message)
            <div class="mt-4">
                <div class="text-muted small fw-semibold mb-2"><i class="bi bi-chat-text me-1 text-orange"></i>Message from Client</div>
                <div class="p-3 rounded-3 border-start border-4 border-warning" style="background:#fffbf5; line-height:1.6;">
                    {{ $lead->message }}
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Actions Panel --}}
    <div class="col-lg-4">
        {{-- Update Status --}}
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-pencil-square me-2 text-orange"></i>Update Status</h6>
            <form action="{{ route('admin.event-leads.status', $lead->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        @foreach(['new' => 'New', 'contacted' => 'Contacted', 'booked' => 'Booked', 'cancelled' => 'Cancelled'] as $val => $label)
                            <option value="{{ $val }}" {{ $lead->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Admin Notes</label>
                    <textarea name="admin_notes" class="form-control" rows="3"
                              placeholder="Internal notes...">{{ $lead->admin_notes }}</textarea>
                </div>
                <button type="submit" class="btn btn-orange w-100 rounded-pill">
                    <i class="bi bi-check-circle me-1"></i> Update Status
                </button>
            </form>
        </div>

        {{-- Quick Actions --}}
        <div class="admin-card p-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-lightning me-2 text-orange"></i>Quick Actions</h6>
            <div class="d-flex flex-column gap-2">
                <a href="mailto:{{ $lead->email }}" class="btn btn-outline-primary rounded-pill w-100">
                    <i class="bi bi-envelope me-1"></i> Send Email
                </a>
                <a href="tel:{{ $lead->phone }}" class="btn btn-outline-success rounded-pill w-100">
                    <i class="bi bi-telephone me-1"></i> Call Client
                </a>
                <form action="{{ route('admin.event-leads.destroy', $lead->id) }}" method="POST"
                      onsubmit="return confirmDelete(this, 'Delete Event Inquiry?', 'Are you sure you want to delete this catering lead permanently?')">
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
