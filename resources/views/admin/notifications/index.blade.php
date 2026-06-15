@extends('layouts.admin')
@section('title', 'Notifications — Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-bell me-2 text-orange"></i>System Notifications</h4>
        <p class="text-muted mb-0">View and manage all system alerts, logs, and activity notifications.</p>
    </div>
    @if($notifications->count() > 0)
        <button onclick="markAllRead()" class="btn btn-orange rounded-pill px-4">
            <i class="bi bi-check2-all me-1"></i> Mark All as Read
        </button>
    @endif
</div>

{{-- Filters --}}
<div class="d-flex gap-2 mb-4">
    <a href="{{ route('admin.notifications.index', ['filter' => 'all']) }}"
       class="btn {{ $filter === 'all' ? 'btn-orange' : 'btn-outline-dark bg-white' }} btn-sm rounded-pill px-3">
        All Notifications
    </a>
    <a href="{{ route('admin.notifications.index', ['filter' => 'unread']) }}"
       class="btn {{ $filter === 'unread' ? 'btn-orange' : 'btn-outline-dark bg-white' }} btn-sm rounded-pill px-3">
        <i class="bi bi-dot text-danger"></i> Unread
    </a>
    <a href="{{ route('admin.notifications.index', ['filter' => 'read']) }}"
       class="btn {{ $filter === 'read' ? 'btn-orange' : 'btn-outline-dark bg-white' }} btn-sm rounded-pill px-3">
        Read
    </a>
</div>

{{-- Notifications list --}}
<div class="admin-card p-4">
    @if($notifications->count() > 0)
        <div class="d-flex flex-column gap-3" id="notif-list">
            @foreach($notifications as $notif)
            @php
                $typeIcons = [
                    'order'     => ['icon' => 'bi-bag-check-fill',   'color' => '#0d6efd'],
                    'franchise' => ['icon' => 'bi-briefcase-fill',   'color' => '#fd7e14'],
                    'catering'  => ['icon' => 'bi-calendar-event-fill','color' => '#6f42c1'],
                    'system'    => ['icon' => 'bi-gear-fill',         'color' => '#6c757d'],
                    'alert'     => ['icon' => 'bi-exclamation-triangle-fill','color' => '#dc3545'],
                    'booking'   => ['icon' => 'bi-table',             'color' => '#20c997'],
                    'blog'      => ['icon' => 'bi-journal-richtext',  'color' => '#0dcaf0'],
                ];
                $meta  = $typeIcons[$notif->type] ?? ['icon' => 'bi-info-circle-fill', 'color' => '#FF7A00'];
                $unread = is_null($notif->read_at);
            @endphp
            <div class="notif-item p-3 border rounded-3 d-flex align-items-start gap-3 {{ $unread ? 'bg-orange-subtle border-warning' : 'bg-white' }}"
                 style="transition:all 0.3s ease;" id="notif-{{ $notif->id }}">
                {{-- Icon --}}
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:42px;height:42px;min-width:42px;background:{{ $meta['color'] }}20;">
                    <i class="bi {{ $meta['icon'] }}" style="font-size:18px;color:{{ $meta['color'] }};"></i>
                </div>

                {{-- Content --}}
                <div class="flex-grow-1 min-w-0">
                    <div class="d-flex justify-content-between align-items-start gap-2 flex-wrap">
                        <div>
                            <h6 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                                {{ $notif->title }}
                                @if($unread)
                                    <span class="badge rounded-pill bg-danger" style="font-size:8px;padding:3px 6px;">NEW</span>
                                @endif
                            </h6>
                            <p class="text-muted mb-0 small" style="line-height:1.5;">{{ $notif->message }}</p>
                            @if($notif->data)
                                @php $d = $notif->data; @endphp
                                @if(is_array($d) && count($d))
                                <div class="mt-1 d-flex flex-wrap gap-2">
                                    @foreach($d as $k => $v)
                                        @if(!is_array($v))
                                        <span class="badge bg-light text-dark border" style="font-size:10px;">
                                            {{ ucfirst(str_replace('_',' ',$k)) }}: {{ $v }}
                                        </span>
                                        @endif
                                    @endforeach
                                </div>
                                @endif
                            @endif
                        </div>
                        <span class="text-muted small flex-shrink-0">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex gap-1 flex-shrink-0">
                    @if($unread)
                    <button onclick="markRead({{ $notif->id }}, this)"
                            class="btn btn-sm btn-outline-success rounded-2" title="Mark as Read"
                            style="width:32px;height:32px;padding:0;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-check-lg" style="font-size:14px;"></i>
                    </button>
                    @endif
                    <button onclick="deleteNotif({{ $notif->id }}, this)"
                            class="btn btn-sm btn-outline-danger rounded-2" title="Delete"
                            style="width:32px;height:32px;padding:0;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-trash" style="font-size:13px;"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $notifications->appends(['filter' => $filter])->links() }}
        </div>
    @else
        <div class="text-center text-muted py-5">
            <i class="bi bi-bell-slash fs-1 d-block mb-2 opacity-25"></i>
            <h5 class="fw-bold">No notifications found</h5>
            <p class="mb-0">Nothing to see here under this filter.</p>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function markRead(id, btn) {
    $.post("{{ url('admin/notifications') }}/" + id + "/mark-read", {_token: "{{ csrf_token() }}"}, function(res) {
        if (res.success) {
            const item = document.getElementById('notif-' + id);
            item.classList.remove('bg-orange-subtle', 'border-warning');
            item.classList.add('bg-white');
            // Remove "NEW" badge
            const badge = item.querySelector('.badge.bg-danger');
            if (badge) badge.remove();
            // Remove this mark-read button
            btn.remove();
            Toast.fire({ icon: 'success', title: 'Marked as read' });
        }
    });
}

function deleteNotif(id, btn) {
    Swal.fire({
        title: 'Delete Notification?',
        text: 'Are you sure you want to delete this notification?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF7A00',
        cancelButtonColor: '#0E101A',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("{{ url('admin/notifications') }}/" + id + "/delete", {_token: "{{ csrf_token() }}"}, function(res) {
                if (res.success) {
                    const item = document.getElementById('notif-' + id);
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(20px)';
                    item.style.transition = 'all 0.3s ease';
                    setTimeout(() => item.remove(), 300);
                    Toast.fire({ icon: 'success', title: 'Notification deleted' });
                }
            });
        }
    });
}

function markAllRead() {
    $.post("{{ route('admin.notifications.mark-all-read') }}", {_token: "{{ csrf_token() }}"}, function(res) {
        if (res.success) {
            Toast.fire({ icon: 'success', title: 'All notifications marked as read!' });
            setTimeout(() => location.reload(), 800);
        }
    });
}
</script>
@endsection
