@extends('layouts.admin')
@section('title', 'Admin Dashboard — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Welcome back, {{ Auth::user()->name }}! 👋</h4>
        <p class="text-muted mb-0">Here's your GOS MOMO platform overview for today.</p>
    </div>
    <div class="text-end">
        <span class="text-muted small">{{ now()->format('D, d M Y') }}</span>
    </div>
</div>

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    @php
    $stats = [
        ['icon'=>'bi-bag-check','label'=>'Total Orders','value'=>\App\Models\Order::count(),'color'=>'#0F5132','sub'=>'All time'],
        ['icon'=>'bi-people','label'=>'Customers','value'=>\App\Models\User::whereHas('roles', fn($q)=>$q->where('slug','customer'))->count(),'color'=>'#D4A017','sub'=>'Registered'],
        ['icon'=>'bi-briefcase','label'=>'Franchise Leads','value'=>\App\Models\FranchiseLead::count(),'color'=>'#E63946','sub'=>'Applications'],
        ['icon'=>'bi-currency-rupee','label'=>'Total Revenue','value'=>'₹'.number_format(\App\Models\Order::where('payment_status','paid')->sum('total')),'color'=>'#6f42c1','sub'=>'Paid orders'],
    ];
    @endphp
    @foreach($stats as $stat)
    <div class="col-md-6 col-xl-3">
        <div class="admin-card stat-card" style="border-left-color: {{ $stat['color'] }}">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title" style="color: {{ $stat['color'] }}">{{ $stat['label'] }}</div>
                    <div class="stat-value" style="color: {{ $stat['color'] }}">{{ $stat['value'] }}</div>
                    <small class="text-muted">{{ $stat['sub'] }}</small>
                </div>
                <div style="width:50px; height:50px; border-radius:12px; background: {{ $stat['color'] }}20; display:flex; align-items:center; justify-content:center;">
                    <i class="bi {{ $stat['icon'] }} fs-4" style="color: {{ $stat['color'] }}"></i>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-4">
    {{-- Quick Actions --}}
    <div class="col-lg-4">
        <div class="admin-card p-4 h-100">
            <h5 class="fw-bold mb-3"><i class="bi bi-lightning-charge me-2 text-warning"></i>Quick Actions</h5>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('admin.products.create') }}" class="btn btn-success rounded-2 text-start px-3">
                    <i class="bi bi-plus-circle me-2"></i> Add New Product
                </a>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary rounded-2 text-start px-3">
                    <i class="bi bi-cart-check me-2"></i> Manage Orders
                </a>
                <a href="{{ route('admin.franchise-leads.index') }}" class="btn btn-outline-warning rounded-2 text-start px-3">
                    <i class="bi bi-briefcase me-2"></i> Franchise Leads
                </a>
                <a href="{{ route('admin.event-leads.index') }}" class="btn btn-outline-danger rounded-2 text-start px-3">
                    <i class="bi bi-calendar-event me-2"></i> Event Inquiries
                </a>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary rounded-2 text-start px-3">
                    <i class="bi bi-globe me-2"></i> View Website
                </a>
            </div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="col-lg-8">
        <div class="admin-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-cart-check me-2 text-success"></i>Recent Orders</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-success btn-sm rounded-pill px-3">View All</a>
            </div>
            @php $recentOrders = \App\Models\Order::with(['user','items'])->latest()->take(5)->get(); @endphp
            @if($recentOrders->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="table-light">
                            <th class="small fw-semibold">Order #</th>
                            <th class="small fw-semibold">Customer</th>
                            <th class="small fw-semibold">Items</th>
                            <th class="small fw-semibold">Total</th>
                            <th class="small fw-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td><span class="fw-bold text-success">#{{ $order->order_number }}</span></td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->items->count() }} item(s)</td>
                            <td class="fw-bold">₹{{ number_format($order->total, 0) }}</td>
                            <td>
                                @php
                                    $statusColors = ['placed'=>'primary','confirmed'=>'info','preparing'=>'warning','packed'=>'secondary','out_for_delivery'=>'dark','delivered'=>'success','cancelled'=>'danger'];
                                    $color = $statusColors[$order->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }} rounded-pill">{{ ucfirst(str_replace('_',' ',$order->status)) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center text-muted py-4">
                <i class="bi bi-bag-x fs-1 mb-2 d-block opacity-25"></i>
                <p class="mb-0">No orders yet. Share the menu link to get started!</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Categories Overview --}}
    <div class="col-lg-4">
        <div class="admin-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-tags me-2 text-primary"></i>Categories</h5>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Manage</a>
            </div>
            @php $cats = \App\Models\Category::withCount('products')->get(); @endphp
            @foreach($cats as $cat)
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi {{ $cat->icon ?? 'bi-circle' }} text-success"></i>
                    <span class="fw-semibold small">{{ $cat->name }}</span>
                </div>
                <span class="badge bg-success-subtle text-success">{{ $cat->products_count }} items</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Franchise Leads Summary --}}
    <div class="col-lg-8">
        <div class="admin-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-briefcase me-2 text-warning"></i>Latest Franchise Leads</h5>
                <a href="{{ route('admin.franchise-leads.index') }}" class="btn btn-outline-warning btn-sm rounded-pill px-3">View All</a>
            </div>
            @php $leads = \App\Models\FranchiseLead::latest()->take(5)->get(); @endphp
            @if($leads->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead><tr class="table-light">
                        <th class="small fw-semibold">Name</th>
                        <th class="small fw-semibold">City</th>
                        <th class="small fw-semibold">Type</th>
                        <th class="small fw-semibold">Investment</th>
                        <th class="small fw-semibold">Status</th>
                    </tr></thead>
                    <tbody>
                        @foreach($leads as $lead)
                        <tr>
                            <td><div class="fw-semibold">{{ $lead->name }}</div><div class="text-muted small">{{ $lead->phone }}</div></td>
                            <td>{{ $lead->city }}</td>
                            <td><span class="badge bg-info-subtle text-info">{{ ucfirst($lead->franchise_type) }}</span></td>
                            <td class="small">{{ $lead->investment_budget }}</td>
                            <td>
                                @php $lc = ['new'=>'primary','contacted'=>'info','site_visit'=>'warning','approved'=>'success','rejected'=>'danger']; @endphp
                                <span class="badge bg-{{ $lc[$lead->status] ?? 'secondary' }}-subtle text-{{ $lc[$lead->status] ?? 'secondary' }}">{{ ucfirst($lead->status) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center text-muted py-4">
                <i class="bi bi-briefcase fs-1 mb-2 d-block opacity-25"></i>
                <p class="mb-0">No franchise leads yet. Share your franchise page!</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
