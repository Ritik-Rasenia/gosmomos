@extends('layouts.admin')
@section('title', 'Manage Orders — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Orders Tracker</h4>
        <p class="text-muted mb-0">Track and assign delivery partners, view cooking instructions, update status.</p>
    </div>
</div>

<div class="admin-card p-4">
    @php $orders = \App\Models\Order::with(['user', 'location'])->latest()->get(); @endphp
    @if($orders->count())
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="table-light">
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Outlet/Location</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $ord)
                <tr>
                    <td><span class="fw-bold text-success">#{{ $ord->order_number }}</span></td>
                    <td>
                        <div class="fw-bold">{{ $ord->user->name }}</div>
                        <div class="text-muted small">{{ $ord->user->phone }}</div>
                    </td>
                    <td>{{ $ord->location->name }}</td>
                    <td class="fw-bold">₹{{ number_format($ord->total, 0) }}</td>
                    <td>
                        @php
                            $statusColors = ['placed'=>'primary','confirmed'=>'info','preparing'=>'warning','packed'=>'secondary','out_for_delivery'=>'dark','delivered'=>'success','cancelled'=>'danger'];
                            $color = $statusColors[$ord->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $color }} rounded-pill px-3 py-1">{{ ucfirst(str_replace('_',' ',$ord->status)) }}</span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $ord->payment_status === 'paid' ? 'success' : 'warning' }}-subtle text-{{ $ord->payment_status === 'paid' ? 'success' : 'warning' }}">
                            {{ ucfirst($ord->payment_status) }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.orders.show', $ord->id) }}" class="btn btn-outline-success btn-sm rounded-pill px-3">Details</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center text-muted py-5">
        <i class="bi bi-bag-x fs-1 mb-2 d-block opacity-25"></i>
        <p class="mb-0">No orders placed in the system yet.</p>
    </div>
    @endif
</div>
@endsection
