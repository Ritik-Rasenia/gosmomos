@extends('layouts.admin')
@section('title', 'Franchise Leads — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Franchise Leads</h4>
        <p class="text-muted mb-0">Track and manage potential franchise applications and expansion requests.</p>
    </div>
</div>

<div class="admin-card p-4">
    @php $leads = \App\Models\FranchiseLead::latest()->get(); @endphp
    @if($leads->count())
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="table-light">
                    <th>Name</th>
                    <th>City / State</th>
                    <th>Model</th>
                    <th>Budget</th>
                    <th>Status</th>
                    <th>Applied Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leads as $lead)
                <tr>
                    <td>
                        <div class="fw-bold">{{ $lead->name }}</div>
                        <div class="text-muted small">{{ $lead->phone }} • {{ $lead->email }}</div>
                    </td>
                    <td>{{ $lead->city }}, {{ $lead->state }}</td>
                    <td><span class="badge bg-info-subtle text-info">{{ ucfirst($lead->franchise_type) }}</span></td>
                    <td class="small">{{ $lead->investment_budget }}</td>
                    <td>
                        @php $lc = ['new'=>'primary','contacted'=>'info','site_visit'=>'warning','approved'=>'success','rejected'=>'danger']; @endphp
                        <span class="badge bg-{{ $lc[$lead->status] ?? 'secondary' }}-subtle text-{{ $lc[$lead->status] ?? 'secondary' }}">{{ ucfirst($lead->status) }}</span>
                    </td>
                    <td class="small">{{ $lead->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center text-muted py-5">
        <i class="bi bi-briefcase fs-1 mb-2 d-block opacity-25"></i>
        <p class="mb-0">No franchise applications received yet.</p>
    </div>
    @endif
</div>
@endsection
