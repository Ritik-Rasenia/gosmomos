@extends('layouts.admin')
@section('title', 'Manage Product Reviews — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Product Reviews</h4>
        <p class="text-muted mb-0">Manage customer feedback, ratings, replies and approvals for momo products.</p>
    </div>
</div>

<div class="admin-card p-4">
    @if($reviews->count())
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="table-light">
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $rev)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 32px; height: 32px; border-radius: 50%; overflow: hidden; background: #FF7A00; display:flex; align-items:center; justify-content:center; color: white; font-weight: bold;">
                                {{ strtoupper(substr($rev->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <span class="fw-bold d-block">{{ $rev->user->name }}</span>
                                <span class="text-muted small" style="font-size: 10px;">{{ $rev->user->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="fw-semibold">{{ $rev->product->name }}</span>
                    </td>
                    <td>
                        <div class="text-warning">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star-fill {{ $i <= $rev->rating ? 'text-warning' : 'text-muted opacity-25' }}" style="font-size: 11px;"></i>
                            @endfor
                        </div>
                    </td>
                    <td>
                        <span title="{{ $rev->comment }}">{{ Str::limit($rev->comment, 40) }}</span>
                    </td>
                    <td>
                        @if($rev->image_url)
                            <img src="{{ $rev->image_url }}" alt="Review photo" class="rounded border" style="width: 36px; height: 36px; object-fit: cover; cursor: pointer;" onclick="openImageModal('{{ $rev->image_url }}')">
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td>
                        <button onclick="toggleApproval({{ $rev->id }})" class="border-0 bg-transparent p-0" title="Click to change status">
                            <span class="badge bg-{{ $rev->is_approved ? 'success' : 'warning' }}-subtle text-{{ $rev->is_approved ? 'success' : 'warning' }}">
                                {{ $rev->is_approved ? 'Approved' : 'Pending Approval' }}
                            </span>
                        </button>
                    </td>
                    <td>
                        <span class="text-muted small">{{ $rev->created_at->format('d M Y') }}</span>
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1 justify-content-end">
                            <button onclick="viewReviewDetails({{ json_encode($rev) }}, '{{ $rev->user->name }}', '{{ $rev->product->name }}')" class="btn btn-sm btn-outline-info rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; padding: 0;" title="View Details & Reply">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; padding: 0;" title="Delete" onclick="deleteReview({{ $rev->id }})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center text-muted py-5">
        <i class="bi bi-chat-left-dots fs-1 mb-2 d-block opacity-25"></i>
        <p class="mb-0">No product reviews submitted yet.</p>
    </div>
    @endif
</div>

{{-- Details and Reply Modal --}}
<div class="modal fade" id="reviewDetailsModal" tabindex="-1" aria-labelledby="reviewDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light rounded-top-4 py-3">
                <h5 class="modal-title fw-bold" id="reviewDetailsModalLabel"><i class="bi bi-chat-text text-orange me-2"></i>Review Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="box-shadow: none;"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex align-items-start gap-3 mb-3 pb-3 border-bottom">
                    <div style="width: 48px; height: 48px; border-radius: 50%; overflow: hidden; background: #FF7A00; display:flex; align-items:center; justify-content:center; color: white; font-weight: bold; font-size: 20px;">
                        <span id="modal-user-initial">C</span>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 text-dark" id="modal-customer-name">Customer Name</h6>
                        <span class="text-muted small" style="font-size: 11px;">Product: <strong class="text-dark" id="modal-product-name">Product Name</strong></span>
                        <div class="text-warning mt-1" id="modal-rating-stars"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-muted small">Customer Comment</label>
                    <p class="p-3 bg-light rounded-3 text-dark mb-0 fs-6" id="modal-comment" style="white-space: pre-wrap;"></p>
                </div>

                <div class="mb-3 d-none" id="modal-image-container">
                    <label class="form-label fw-bold text-muted small d-block">Uploaded Photo</label>
                    <img id="modal-review-image" src="" class="img-fluid rounded border shadow-sm" style="max-height: 200px; object-fit: contain;">
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-muted small">Approval Status</span>
                        <span id="modal-status-badge" class="badge">Approved</span>
                    </div>
                </div>

                {{-- Admin Reply Form --}}
                <form id="modal-reply-form" method="POST" action="">
                    @csrf
                    <div class="mb-3">
                        <label for="modal-admin-reply" class="form-label fw-bold text-dark"><i class="bi bi-reply-fill text-orange me-1"></i>Admin Reply</label>
                        <textarea class="form-control" name="admin_reply" id="modal-admin-reply" rows="3" placeholder="Type your response to the customer here..."></textarea>
                    </div>
                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="modal-toggle-status-btn" class="btn btn-warning px-3 text-dark fw-bold">Approve/Disapprove</button>
                        <button type="submit" class="btn btn-orange btn-premium px-4">Save Reply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Image Preview Modal --}}
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body p-0 text-center position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <img id="previewImageSrc" src="" class="img-fluid rounded-4 shadow-lg" style="max-height: 80vh; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

{{-- Hidden Action Forms --}}
<form id="delete-review-form" action="" method="POST" class="d-none">
    @csrf
</form>

<form id="toggle-approval-form" action="" method="POST" class="d-none">
    @csrf
</form>
@endsection

@section('scripts')
<script>
function deleteReview(id) {
    Swal.fire({
        title: 'Delete Product Review?',
        text: 'Are you sure you want to delete this review? This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF7A00',
        cancelButtonColor: '#0E101A',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('delete-review-form');
            form.action = `/admin/product-reviews/delete/${id}`;
            form.submit();
        }
    });
}

function toggleApproval(id) {
    const form = document.getElementById('toggle-approval-form');
    form.action = `/admin/product-reviews/${id}/toggle-approve`;
    form.submit();
}

function openImageModal(url) {
    $('#previewImageSrc').attr('src', url);
    new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
}

function viewReviewDetails(review, userName, productName) {
    // Populate Modal
    $('#modal-user-initial').text(userName.substring(0, 1).toUpperCase());
    $('#modal-customer-name').text(userName);
    $('#modal-product-name').text(productName);
    $('#modal-comment').text(review.comment || 'No text comment provided.');
    
    // Rating Stars
    let starsHtml = '';
    for (let i = 1; i <= 5; i++) {
        starsHtml += `<i class="bi bi-star-fill ${i <= review.rating ? 'text-warning' : 'text-muted opacity-25'} me-1" style="font-size:13px;"></i>`;
    }
    $('#modal-rating-stars').html(starsHtml);

    // Image
    if (review.image) {
        const imageSrc = review.image.startsWith('http') ? review.image : '/storage/' + review.image;
        $('#modal-review-image').attr('src', imageSrc);
        $('#modal-image-container').removeClass('d-none');
    } else {
        $('#modal-image-container').addClass('d-none');
    }

    // Status Badge
    const badge = $('#modal-status-badge');
    badge.removeClass('bg-success-subtle text-success bg-warning-subtle text-warning');
    if (review.is_approved) {
        badge.text('Approved').addClass('bg-success-subtle text-success');
        $('#modal-toggle-status-btn').text('Disapprove Review').removeClass('btn-success').addClass('btn-warning');
    } else {
        badge.text('Pending Approval').addClass('bg-warning-subtle text-warning');
        $('#modal-toggle-status-btn').text('Approve Review').removeClass('btn-warning').addClass('btn-success');
    }

    // Form Action
    $('#modal-reply-form').attr('action', `/admin/product-reviews/${review.id}/reply`);
    $('#modal-admin-reply').val(review.admin_reply);

    // Toggle Status button handler in modal
    $('#modal-toggle-status-btn').off('click').on('click', function() {
        toggleApproval(review.id);
    });

    // Show Modal
    new bootstrap.Modal(document.getElementById('reviewDetailsModal')).show();
}
</script>
@endsection
