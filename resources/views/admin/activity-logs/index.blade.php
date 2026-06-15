@extends('layouts.admin')
@section('title', 'System Activity Logs — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">System Audit & Activity Logs</h4>
        <p class="text-muted mb-0">Monitor database updates, logins, and API actions. All payloads exclude sensitive passwords.</p>
    </div>
</div>

<div class="admin-card p-4">
    @if($logs->count())
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="table-light">
                    <th>Timestamp</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Request Path</th>
                    <th>IP Address</th>
                    <th>Payload Changes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr>
                    <td class="small">{{ $log->created_at->format('d M Y, h:i:s A') }}</td>
                    <td>
                        @if($log->user)
                            <span class="fw-bold">{{ $log->user->name }}</span>
                            <span class="text-muted small d-block">{{ $log->user->email }}</span>
                        @else
                            <span class="text-muted">Guest / System</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ str_contains($log->action, 'post') || str_contains($log->action, 'create') ? 'success' : (str_contains($log->action, 'delete') ? 'danger' : 'info') }} px-2 py-1">
                            {{ strtoupper(str_replace('_request', '', $log->action)) }}
                        </span>
                    </td>
                    <td>
                        <code>{{ $log->model_type ?? '/' }}</code>
                    </td>
                    <td>
                        <span class="small text-muted">{{ $log->ip_address }}</span>
                    </td>
                    <td>
                        @if($log->new_values)
                            <button class="btn btn-outline-dark btn-xs py-0 px-2 rounded-pill small" style="font-size: 11px;" onclick="viewPayload({{ $log->id }})">
                                <i class="bi bi-eye"></i> View Payload
                            </button>
                            <div id="payload_{{ $log->id }}" class="d-none mt-2 p-2 bg-light border rounded small" style="max-width: 300px; max-height: 200px; overflow: auto;">
                                <pre class="mb-0"><code>{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</code></pre>
                            </div>
                        @else
                            <span class="text-muted small">None</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        {{ $logs->links() }}
    </div>
    @else
    <div class="text-center text-muted py-5">
        <i class="bi bi-journal-text fs-1 mb-2 d-block opacity-25"></i>
        <p class="mb-0">No activity logs recorded yet.</p>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function viewPayload(id) {
    const el = document.getElementById('payload_' + id);
    if (el.classList.contains('d-none')) {
        el.classList.remove('d-none');
    } else {
        el.classList.add('d-none');
    }
}
</script>
@endsection
