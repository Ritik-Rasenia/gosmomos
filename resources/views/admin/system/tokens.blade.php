@extends('layouts.admin')
@section('title', 'API Tokens — GOS MOMO')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">API Token Management</h4>
    <p class="text-muted">Generate secure API keys to integrate third-party delivery aggregators, POS systems, or mobile apps.</p>
</div>

@if(session('raw_token'))
<div class="alert alert-warning border-warning rounded-3 p-4 mb-4">
    <div class="d-flex align-items-center gap-3 mb-2">
        <i class="bi bi-exclamation-triangle-fill text-warning fs-3"></i>
        <h5 class="fw-bold mb-0 text-dark">Save Your API Token Now!</h5>
    </div>
    <p class="mb-3 text-dark small">For security, this token is hashed in our database. We cannot show it to you again. Copy it now to your secure credentials store:</p>
    <div class="input-group">
        <input type="text" id="rawTokenInput" class="form-control font-monospace fw-bold bg-white text-danger border-warning" value="{{ session('raw_token') }}" readonly>
        <button class="btn btn-warning" type="button" onclick="copyToken()"><i class="bi bi-clipboard me-1"></i> Copy Key</button>
    </div>
</div>
@endif

<div class="row g-4">
    <!-- List Tokens -->
    <div class="col-lg-8">
        <div class="admin-card p-4">
            <h5 class="fw-bold mb-3 text-orange"><i class="bi bi-key-fill me-2"></i>Active API Keys</h5>
            @if($tokens->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="table-light">
                            <th>Name</th>
                            <th>Hashed Secret</th>
                            <th>Status</th>
                            <th>Last Used</th>
                            <th>Created</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tokens as $tok)
                        <tr>
                            <td><span class="fw-bold">{{ $tok->name }}</span></td>
                            <td><code>{{ substr($tok->token, 0, 12) }}...</code></td>
                            <td>
                                <span class="badge bg-{{ $tok->is_active ? 'success' : 'secondary' }}-subtle text-{{ $tok->is_active ? 'success' : 'secondary' }} rounded-3 px-2 py-1">
                                    {{ $tok->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <span class="small text-muted">{{ $tok->last_used_at ? $tok->last_used_at->diffForHumans() : 'Never' }}</span>
                            </td>
                            <td class="small">{{ $tok->created_at->format('d M Y') }}</td>
                            <td class="text-end">
                                <button class="btn btn-outline-danger btn-sm rounded-circle" title="Revoke" onclick="confirmRevoke({{ $tok->id }})">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center text-muted py-5">
                <i class="bi bi-key fs-1 mb-2 d-block opacity-25"></i>
                <p class="mb-0">No API keys created yet. Enter a name on the right to generate one.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Create Token -->
    <div class="col-lg-4">
        <div class="admin-card p-4">
            <h5 class="fw-bold mb-3 text-orange"><i class="bi bi-plus-circle me-2"></i>Create New Key</h5>
            <form action="{{ route('admin.system.tokens.generate') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Token Name/Description</label>
                    <input type="text" name="name" class="form-control rounded-3" placeholder="e.g. Swiggy POS Integration" required>
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-orange w-100 rounded-pill py-2 fw-semibold">Generate Token</button>
            </form>
        </div>
    </div>
</div>

<form id="revoke-token-form" action="" method="POST" class="d-none">
    @csrf
</form>
@endsection

@section('scripts')
<script>
function copyToken() {
    const copyText = document.getElementById("rawTokenInput");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    
    Toast.fire({
        icon: 'success',
        title: 'Token copied to clipboard!'
    });
}

function confirmRevoke(id) {
    Swal.fire({
        title: 'Revoke API Token?',
        text: "This token will stop working immediately! Any external service using this key will face 401 Unauthorized errors.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#E63946',
        cancelButtonColor: '#0E101A',
        confirmButtonText: 'Yes, revoke immediately!'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('revoke-token-form');
            form.action = `/admin/system/tokens/revoke/${id}`;
            form.submit();
        }
    });
}
</script>
@endsection
