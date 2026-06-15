@extends('layouts.admin')
@section('title', 'Event & Catering Leads — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-calendar-event me-2 text-orange"></i>Catering & Event Inquiries</h4>
        <p class="text-muted mb-0">Manage bulk orders, table bookings, and live catering station inquiries.</p>
    </div>
    <span class="badge bg-orange rounded-pill px-3 py-2" style="background:#FF7A00!important;">
        {{ $leads->total() }} Total Leads
    </span>
</div>

<div class="admin-card p-4">
    @if($leads->count())
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="table-light">
                    <th>#</th>
                    <th>Host Name</th>
                    <th>Event Details</th>
                    <th>City</th>
                    <th>Guests</th>
                    <th>Event Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leads as $lead)
                @php $lc = ['new'=>'primary','contacted'=>'info','booked'=>'success','cancelled'=>'danger']; @endphp
                <tr>
                    <td class="text-muted small">{{ $lead->id }}</td>
                    <td>
                        <div class="fw-bold">{{ $lead->name }}</div>
                        <div class="text-muted small">{{ $lead->phone }} • {{ $lead->email }}</div>
                    </td>
                    <td>
                        <div class="fw-bold">{{ ucfirst(str_replace('_', ' ', $lead->event_type)) }}</div>
                        @if($lead->budget)
                        <div class="text-muted small">Budget: ₹{{ number_format($lead->budget, 0) }}</div>
                        @endif
                    </td>
                    <td>{{ $lead->city }}</td>
                    <td><span class="badge bg-success-subtle text-success">{{ $lead->guest_count }} guests</span></td>
                    <td class="small">{{ \Carbon\Carbon::parse($lead->event_date)->format('d M Y') }}</td>
                    <td>
                        <span class="badge bg-{{ $lc[$lead->status] ?? 'secondary' }}-subtle text-{{ $lc[$lead->status] ?? 'secondary' }}">
                            {{ ucfirst($lead->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.event-leads.show', $lead->id) }}"
                               class="btn btn-sm btn-outline-primary rounded-2" title="View Details">
                                <i class="bi bi-eye"></i>
                            </a>
                             <form action="{{ route('admin.event-leads.destroy', $lead->id) }}" method="POST"
                                   onsubmit="return confirmDelete(this, 'Delete Event Inquiry?', 'Are you sure you want to delete this event/catering lead?')" class="d-inline">
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
        <i class="bi bi-calendar-x fs-1 mb-2 d-block opacity-25"></i>
        <h5 class="fw-bold">No catering inquiries yet</h5>
        <p class="mb-0">They will appear here once customers submit the form.</p>
    </div>
    @endif
</div>
@endsection
