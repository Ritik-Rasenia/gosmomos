@extends('layouts.admin')
@section('title', 'Catering Leads — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Catering & Event Inquiries</h4>
        <p class="text-muted mb-0">Manage bulk orders and live catering station inquiries for parties/events.</p>
    </div>
</div>

<div class="admin-card p-4">
    @php $leads = \App\Models\EventLead::latest()->get(); @endphp
    @if($leads->count())
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="table-light">
                    <th>Host Name</th>
                    <th>Event Details</th>
                    <th>City</th>
                    <th>Guests</th>
                    <th>Event Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leads as $lead)
                <tr>
                    <td>
                        <div class="fw-bold">{{ $lead->name }}</div>
                        <div class="text-muted small">{{ $lead->phone }} • {{ $lead->email }}</div>
                    </td>
                    <td>
                        <div class="fw-bold">{{ $lead->event_type }}</div>
                        <div class="text-muted small" style="max-width:300px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $lead->message }}</div>
                    </td>
                    <td>{{ $lead->city }}</td>
                    <td><span class="badge bg-success-subtle text-success">{{ $lead->guest_count }} guests</span></td>
                    <td class="small">{{ date('d M Y', strtotime($lead->event_date)) }}</td>
                    <td>
                        <span class="badge bg-primary rounded-pill">New Inquiry</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center text-muted py-5">
        <i class="bi bi-calendar-x fs-1 mb-2 d-block opacity-25"></i>
        <p class="mb-0">No catering inquiries received yet.</p>
    </div>
    @endif
</div>
@endsection
