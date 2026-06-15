@extends('layouts.app')
@section('title', $product->name . ' — GOS MOMO')
@section('styles')
<style>
/* Mobile background */
@media (max-width: 575.98px) {
    .page-hero {
        background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/menu-mobile.jpg') }}') !important;
        background-size: cover !important;
        background-position: center !important;
    }
}
/* Tablet background */
@media (min-width: 576px) and (max-width: 991.98px) {
    .page-hero {
        background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/menu-tablet.png') }}') !important;
        background-size: cover !important;
        background-position: center !important;
    }
}
/* Laptop background */
@media (min-width: 992px) and (max-width: 1199.98px) {
    .page-hero {
        background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/menu-laptop.png') }}') !important;
        background-size: cover !important;
        background-position: center !important;
    }
}
/* Desktop background */
@media (min-width: 1200px) {
    .page-hero {
        background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/menu-desktop.jpg') }}') !important;
        background-size: cover !important;
        background-position: center !important;
    }
}
.details-hero {
    border-bottom: 1px solid rgba(255,255,255,0.05);
}
.breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255,255,255,0.5);
}
.breadcrumb-item a {
    color: rgba(255,255,255,0.7);
    text-decoration: none;
    transition: color 0.2s;
}
.breadcrumb-item a:hover {
    color: #FF7A00;
}
.product-image-container {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.04);
}
.product-main-img {
    width: 100%;
    height: 450px;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.product-main-img:hover {
    transform: scale(1.03);
}
.thumbnail-img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 12px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.2s ease;
}
.thumbnail-img.active, .thumbnail-img:hover {
    border-color: #FF7A00;
    transform: translateY(-2px);
}
.badge-item {
    font-size: 11px;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: 6px;
    letter-spacing: 0.5px;
}
.price-display {
    font-size: 2.2rem;
    font-weight: 800;
    color: #FF7A00;
    font-family: 'Outfit', sans-serif;
}
.attribute-badge {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 12px;
    text-align: center;
    font-weight: 600;
    color: #0E101A;
}
.veg-badge {
    border: 2px solid #28a745;
    border-radius: 4px;
    padding: 2px 8px;
    color: #28a745;
    font-weight: 700;
    font-size: 12px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.veg-badge::before {
    content: '';
    width: 8px;
    height: 8px;
    background: #28a745;
    border-radius: 50%;
}
.nonveg-badge {
    border: 2px solid #dc3545;
    border-radius: 4px;
    padding: 2px 8px;
    color: #dc3545;
    font-weight: 700;
    font-size: 12px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.nonveg-badge::before {
    content: '';
    width: 0;
    height: 0;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-bottom: 7px solid #dc3545;
}
.quantity-input {
    width: 60px;
    text-align: center;
    font-weight: 700;
    border: none;
    background: transparent;
}
.qty-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1px solid #e9ecef;
    background: white;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}
.qty-btn:hover {
    background: #FF7A00;
    color: white;
    border-color: #FF7A00;
}
.btn-large-cart {
    background: linear-gradient(135deg, #FF7A00 0%, #E26C00 100%);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 12px 36px;
    font-weight: 700;
    font-size: 16px;
    box-shadow: 0 4px 15px rgba(255, 122, 0, 0.3);
    transition: all 0.3s ease;
}
.btn-large-cart:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 122, 0, 0.45);
    color: white;
}
.btn-large-cart:active {
    transform: translateY(0);
}
.spice-flame {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #e9ecef;
    display: inline-block;
}
.spice-flame.active {
    background: #dc3545;
}
.review-card {
    background: #f8f9fa;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 16px;
    border: 1px solid #e9ecef;
}
.related-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    border: 1px solid rgba(0,0,0,0.04);
    transition: all 0.3s;
}
.related-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(255,122,0,0.1);
}
.star-rating-select {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}
.star-rating-select label {
    font-size: 28px;
    color: #e9ecef;
    cursor: pointer;
    transition: color 0.15s ease-in-out;
}
.star-rating-select input:checked ~ label,
.star-rating-select label:hover,
.star-rating-select label:hover ~ label {
    color: #FF7A00 !important;
}
</style>
@endsection

@section('content')
<section class="page-hero text-center py-4" style="padding: 50px 0 !important;">
    <div class="container" data-aos="fade-up">
        <h1 class="fw-bold text-white mb-3" style="font-family:'Outfit'; font-size: 2.2rem;">{{ $product->name }}</h1>
        <nav aria-label="breadcrumb" class="d-flex justify-content-center">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Menu</a></li>
                <li class="breadcrumb-item"><a href="{{ route('menu.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>
                <li class="breadcrumb-item active text-white-50" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</section>

<div class="container py-5">
    <div class="row g-5">
        {{-- Product Images Column --}}
        <div class="col-lg-6" data-aos="fade-right">
            <div class="product-image-container mb-3">
                @if($product->image_url)
                    <img id="main-product-image" src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-main-img" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1625220194771-7ebedd0b4d11?auto=format&fit=crop&w=800&q=80';">
                @else
                    <div class="w-100 d-flex align-items-center justify-content-center text-white" style="height:450px; background: linear-gradient(135deg, #FF7A00, #E26C00); font-size: 100px;">🥟</div>
                @endif
            </div>

            {{-- Image Thumbnails Slider --}}
            @if($product->images->count() > 0)
            <div class="d-flex gap-2 flex-wrap">
                <img src="{{ $product->image_url }}" class="thumbnail-img active" onclick="changeProductImage('{{ $product->image_url }}', this)" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1625220194771-7ebedd0b4d11?auto=format&fit=crop&w=800&q=80';">
                @foreach($product->images as $img)
                <img src="{{ asset('storage/' . $img->image_path) }}" class="thumbnail-img" onclick="changeProductImage('{{ asset('storage/' . $img->image_path) }}', this)">
                @endforeach
            </div>
            @endif
        </div>

        {{-- Product Details Column --}}
        <div class="col-lg-6" data-aos="fade-left">
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="{{ $product->is_veg ? 'veg-badge' : 'nonveg-badge' }}">
                    {{ $product->is_veg ? 'Veg' : 'Non-Veg' }}
                </span>
                
                @if($product->is_bestseller)
                    <span class="badge bg-danger badge-item">BESTSELLER</span>
                @endif
                @if($product->is_new)
                    <span class="badge bg-warning text-dark badge-item">NEW</span>
                @endif
            </div>

            <h1 class="fw-bold mb-2 font-outfit text-dark">{{ $product->name }}</h1>

            <div class="d-flex align-items-center gap-2 mb-4">
                <div class="text-warning fw-bold">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star-fill {{ $i <= round($product->average_rating) ? 'text-warning' : 'text-muted opacity-25' }}"></i>
                    @endfor
                </div>
                <span class="text-muted small">({{ $product->reviews->count() }} customer reviews)</span>
            </div>

            <div class="price-display mb-3" id="current-price-tag">
                ₹{{ number_format($product->variants->first() ? $product->variants->first()->price : $product->base_price, 0) }}
            </div>

            <p class="text-muted mb-4 fs-6">{{ $product->description ?? $product->short_description }}</p>

            {{-- Metadata Badges Grid --}}
            <div class="row g-3 mb-4">
                <div class="col-4">
                    <div class="attribute-badge">
                        <i class="bi bi-stopwatch text-orange fs-4 d-block mb-1"></i>
                        <span class="small text-muted d-block">Prep Time</span>
                        <span class="fs-6">{{ $product->preparation_time ?? '15' }} Mins</span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="attribute-badge">
                        <i class="bi bi-fire text-danger fs-4 d-block mb-1"></i>
                        <span class="small text-muted d-block">Calories</span>
                        <span class="fs-6">{{ $product->calories ?? '250' }} kcal</span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="attribute-badge">
                        <i class="bi bi-egg-fried text-warning fs-4 d-block mb-1"></i>
                        <span class="small text-muted d-block">Spice Level</span>
                        <span class="fs-6 d-flex justify-content-center gap-1 mt-1">
                            @for($s = 1; $s <= 3; $s++)
                                <span class="spice-flame {{ $s <= ($product->spice_level ?? 0) ? 'active' : '' }}"></span>
                            @endfor
                        </span>
                    </div>
                </div>
            </div>

            {{-- Variant Selection --}}
            @if($product->variants->count() > 0)
            <div class="mb-4">
                <label class="form-label fw-bold text-dark mb-2">Select Options</label>
                <div class="d-flex gap-2 flex-wrap">
                    @foreach($product->variants as $variant)
                    <label class="btn btn-outline-dark px-3 py-2 text-start variant-option-btn {{ $loop->first ? 'active bg-dark text-white' : '' }}" style="cursor: pointer; border-radius: 8px;" onclick="selectProductVariant({{ $variant->id }}, {{ $variant->price }}, this)">
                        <input type="radio" name="product_variant" value="{{ $variant->id }}" class="d-none" {{ $loop->first ? 'checked' : '' }}>
                        <div class="fw-bold">{{ $variant->name }}</div>
                        <div class="small">₹{{ number_format($variant->price, 0) }}</div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Add to Cart Row --}}
            <div class="d-flex align-items-center gap-4 mt-4">
                <div class="d-flex align-items-center border rounded-pill p-1 bg-light">
                    <button type="button" class="qty-btn" onclick="updateQty(-1)"><i class="bi bi-dash"></i></button>
                    <input type="text" id="cart-item-qty" class="quantity-input" value="1" readonly>
                    <button type="button" class="qty-btn" onclick="updateQty(1)"><i class="bi bi-plus"></i></button>
                </div>

                <button type="button" class="btn btn-large-cart flex-grow-1" id="add-to-cart-action-btn">
                    <i class="bi bi-cart-plus-fill me-2"></i> Add to Cart
                </button>
            </div>
        </div>
    </div>

    {{-- Reviews Section --}}
    <div class="row mt-5 pt-5 border-top">
        <div class="col-lg-8" data-aos="fade-up">
            <h4 class="fw-bold mb-4 font-outfit">Reviews ({{ $product->reviews->count() }})</h4>
            
            @forelse($reviews as $rev)
            <div class="review-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="fw-bold mb-0">{{ $rev->user->name }}</h6>
                        <span class="text-muted small">{{ $rev->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="text-warning">
                        @for($r = 1; $r <= 5; $r++)
                            <i class="bi bi-star-fill {{ $r <= $rev->rating ? 'text-warning' : 'text-muted opacity-25' }}"></i>
                        @endfor
                    </div>
                </div>
                <p class="text-muted mb-0">{{ $rev->comment }}</p>
                @if($rev->image_url)
                    <div class="mt-2">
                        <img src="{{ $rev->image_url }}" alt="Review photo" class="rounded border" style="max-height: 80px; max-width: 80px; object-fit: cover; cursor: pointer;" onclick="openReviewModal('{{ $rev->image_url }}')">
                    </div>
                @endif
                @if($rev->admin_reply)
                <div class="mt-3 p-3 bg-white rounded-3 border-start border-warning border-3 small">
                    <strong>GOS MOMO response:</strong> {{ $rev->admin_reply }}
                </div>
                @endif
            </div>
            @empty
            <div class="text-center py-5 text-muted bg-light rounded-4">
                <i class="bi bi-chat-left-dots fs-1 opacity-25 d-block mb-2"></i>
                <p class="mb-0">No reviews yet for this product. Be the first to try and review it!</p>
            </div>
            @endforelse

            <!-- Write a Product Review Form -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mt-5">
                @auth
                    <h5 class="fw-bold mb-3 font-outfit text-dark"><i class="bi bi-pencil-square text-primary-color me-2"></i>Write a Review</h5>
                    <form method="POST" action="{{ route('product.review.store', $product->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark d-block">Your Rating *</label>
                            <div class="star-rating-select">
                                <input type="radio" id="star5" name="rating" value="5" class="d-none" required />
                                <label for="star5" class="bi bi-star-fill me-1" title="5 stars"></label>
                                <input type="radio" id="star4" name="rating" value="4" class="d-none" />
                                <label for="star4" class="bi bi-star-fill me-1" title="4 stars"></label>
                                <input type="radio" id="star3" name="rating" value="3" class="d-none" />
                                <label for="star3" class="bi bi-star-fill me-1" title="3 stars"></label>
                                <input type="radio" id="star2" name="rating" value="2" class="d-none" />
                                <label for="star2" class="bi bi-star-fill me-1" title="2 stars"></label>
                                <input type="radio" id="star1" name="rating" value="1" class="d-none" />
                                <label for="star1" class="bi bi-star-fill me-1" title="1 star"></label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Your Comment *</label>
                            <textarea name="comment" class="form-control rounded-3" rows="3" placeholder="Share your experience with this dish..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Upload Image (Optional)</label>
                            <input type="file" name="image" id="review-image-input" class="form-control rounded-3" accept="image/*">
                            <div class="form-text small text-muted">JPEG, PNG, JPG, WEBP (Max 2MB)</div>
                            <div class="mt-2 d-none" id="review-image-preview-container">
                                <span class="d-block small text-muted mb-1">Image Preview:</span>
                                <div class="position-relative d-inline-block">
                                    <img id="review-image-preview" src="#" alt="Preview" class="rounded border" style="max-height: 120px; max-width: 120px; object-fit: cover;">
                                    <button type="button" id="btn-remove-review-image" class="btn btn-danger btn-sm rounded-circle position-absolute top-0 start-100 translate-middle" style="padding: 2px 6px; font-size: 10px;">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-premium w-100 py-2">Submit Review</button>
                    </form>
                @else
                    <div class="p-3 text-center bg-light rounded-3">
                        <i class="bi bi-lock-fill text-warning fs-3 mb-2 d-block"></i>
                        <h6 class="fw-bold text-dark">Add a Review</h6>
                        <p class="text-muted small mb-3">Please log in to rate this product and share your feedback.</p>
                        <a href="{{ route('login') }}" class="btn btn-premium btn-sm px-4">Log In</a>
                    </div>
                @endauth
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->count() > 0)
        <div class="col-lg-4" data-aos="fade-up">
            <h4 class="fw-bold mb-4 font-outfit">You May Also Like</h4>
            <div class="d-flex flex-column gap-3">
                @foreach($relatedProducts as $rel)
                <a href="{{ route('menu.show', $rel->slug) }}" class="text-decoration-none text-dark">
                    <div class="related-card d-flex p-2 gap-3 align-items-center">
                        @if($rel->image_url)
                            <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}" style="width:70px; height:70px; object-fit:cover; border-radius:10px;">
                        @else
                            <div class="d-flex align-items-center justify-content-center text-white bg-orange" style="width:70px; height:70px; border-radius:10px; font-size:24px;">🥟</div>
                        @endif
                        <div>
                            <span class="{{ $rel->is_veg ? 'veg-badge' : 'nonveg-badge' }} px-1 small" style="transform:scale(0.85); transform-origin:left;"></span>
                            <h6 class="fw-bold mb-1 small mt-1">{{ $rel->name }}</h6>
                            <span class="text-orange fw-bold small">₹{{ number_format($rel->base_price, 0) }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Review Image Modal --}}
<div class="modal fade" id="reviewImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body p-0 text-center position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <img id="modalReviewImage" src="" class="img-fluid rounded-4 shadow-lg" style="max-height: 80vh; object-fit: contain;">
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let selectedVariantId = "{{ $product->variants->first() ? $product->variants->first()->id : '' }}";

function changeProductImage(url, el) {
    $('#main-product-image').attr('src', url);
    $('.thumbnail-img').removeClass('active');
    $(el).addClass('active');
}

function selectProductVariant(id, price, el) {
    selectedVariantId = id;
    $('#current-price-tag').text('₹' + parseFloat(price).toFixed(0));
    $('.variant-option-btn').removeClass('active bg-dark text-white');
    $(el).addClass('active bg-dark text-white');
}

function openReviewModal(url) {
    $('#modalReviewImage').attr('src', url);
    new bootstrap.Modal(document.getElementById('reviewImageModal')).show();
}

function updateQty(amt) {
    const qtyInput = $('#cart-item-qty');
    let currentVal = parseInt(qtyInput.value || qtyInput.val());
    currentVal = isNaN(currentVal) ? 1 : currentVal + amt;
    if (currentVal < 1) currentVal = 1;
    if (currentVal > 10) currentVal = 10; // Max limit per cart item
    qtyInput.val(currentVal);
}

$(document).ready(function() {
    $('#add-to-cart-action-btn').on('click', function() {
        const btn = $(this);
        const qty = parseInt($('#cart-item-qty').val());
        const productId = "{{ $product->id }}";
        
        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-2"></i> Adding...');

        $.ajax({
            url: "{{ route('cart.add') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                product_id: productId,
                variant_id: selectedVariantId || null,
                quantity: qty
            },
            success: function(res) {
                if (res.success) {
                    btn.removeClass('btn-large-cart').addClass('btn-success').html('<i class="bi bi-check-circle-fill me-2"></i> Added!');
                    
                    // Fire Toast success
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        icon: 'success',
                        title: 'Product added to cart successfully!',
                        timerProgressBar: true
                    });

                    setTimeout(() => {
                        btn.removeClass('btn-success').addClass('btn-large-cart').prop('disabled', false).html('<i class="bi bi-cart-plus-fill me-2"></i> Add to Cart');
                    }, 2000);
                    
                    const count = res.cart_count;
                    $('#desktop-cart-count, #mobile-cart-badge, #mobile-bottom-cart-badge, #floating-cart-badge').text(count).removeClass('d-none');
                }
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="bi bi-cart-plus-fill me-2"></i> Add to Cart');
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    icon: 'error',
                    title: 'Failed to add product to cart.',
                    timerProgressBar: true
                });
            }
        });
    });

    // Live image preview for reviews
    $('#review-image-input').on('change', function() {
        const file = this.files[0];
        if (file) {
            // Check file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File too large',
                    text: 'Please upload an image smaller than 2MB.'
                });
                this.value = '';
                $('#review-image-preview-container').addClass('d-none');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#review-image-preview').attr('src', e.target.result);
                $('#review-image-preview-container').removeClass('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            $('#review-image-preview-container').addClass('d-none');
        }
    });

    $('#btn-remove-review-image').on('click', function() {
        $('#review-image-input').val('');
        $('#review-image-preview-container').addClass('d-none');
        $('#review-image-preview').attr('src', '#');
    });
});
</script>
@endsection
