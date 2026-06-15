@extends('layouts.admin')
@section('title', 'Franchise Leads — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-briefcase me-2 text-orange"></i>Franchise Applications</h4>
        <p class="text-muted mb-0">Track and manage potential franchise applications and expansion requests.</p>
    </div>
    <span class="badge bg-orange rounded-pill px-3 py-2" style="background:#FF7A00!important;">
        {{ $leads->total() }} Applications
    </span>
</div>

<div class="admin-card p-4">
    @if($leads->count())
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="table-light">
                    <th>#</th>
                    <th>Applicant</th>
                    <th>City / State</th>
                    <th>Model</th>
                    <th>Budget</th>
                    <th>Status</th>
                    <th>Applied</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leads as $lead)
                @php $lc = ['new'=>'primary','contacted'=>'info','site_visit'=>'warning','approved'=>'success','rejected'=>'danger']; @endphp
                <tr>
                    <td class="text-muted small">{{ $lead->id }}</td>
                    <td>
                        <div class="fw-bold">{{ $lead->name }}</div>
                        <div class="text-muted small">{{ $lead->phone }}</div>
                    </td>
                    <td>{{ $lead->city }}, {{ $lead->state }}</td>
                    <td><span class="badge bg-info-subtle text-info">{{ ucfirst($lead->franchise_type) }}</span></td>
                    <td class="small">{{ $lead->investment_budget }}</td>
                    <td>
                        <span class="badge bg-{{ $lc[$lead->status] ?? 'secondary' }}-subtle text-{{ $lc[$lead->status] ?? 'secondary' }}">
                            {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                        </span>
                    </td>
                    <td class="small text-muted">{{ $lead->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.franchise-leads.show', $lead->id) }}"
                               class="btn btn-sm btn-outline-primary rounded-2" title="View Details">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="{{ route('admin.franchise-leads.status', $lead->id) }}" method="POST" class="d-inline">
                                @csrf
                                <select name="status" class="form-select form-select-sm rounded-2"
                                        style="min-width:110px;font-size:11px;" onchange="this.form.submit()">
                                    @foreach(['new'=>'New','contacted'=>'Contacted','site_visit'=>'Site Visit','approved'=>'Approved','rejected'=>'Rejected'] as $val=>$lbl)
                                        <option value="{{ $val }}" {{ $lead->status === $val ? 'selected':'' }}>{{ $lbl }}</option>
                                    @endforeach
                                </select>
                            </form>
                            <form action="{{ route('admin.franchise-leads.destroy', $lead->id) }}" method="POST"
                                  onsubmit="return confirmDelete(this, 'Delete Franchise Lead?', 'Are you sure you want to delete this lead application?')" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-danger rounded-2" title="Delete">
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
    <div class="mt-3">{{ $leads->links() }}</div>
    @else
    <div class="text-center text-muted py-5">
        <i class="bi bi-briefcase fs-1 mb-2 d-block opacity-25"></i>
        <h5 class="fw-bold">No franchise applications yet</h5>
        <p class="mb-0">Share your franchise page to attract applications!</p>
    </div>
    @endif
</div>
@endsection
