@extends('layouts.app')
@section('title', 'Cart — GOS MOMO')
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4" data-aos="fade-up"><i class="bi bi-cart3 me-2 text-success"></i> Your Cart</h2>

    @if(isset($cart) && $cart->items->count() > 0)
    <div class="row g-4">
        {{-- Cart Items --}}
        <div class="col-lg-8" data-aos="fade-right">
            @foreach($cart->items as $item)
            <div class="glass-card p-4 mb-3 cart-item-row" id="cart-item-{{ $item->id }}">
                <div class="d-flex align-items-start gap-3">
                    @if($item->product->image_url)
                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" style="width:70px; height:70px; border-radius:12px; object-fit:cover; flex-shrink:0;">
                    @else
                        <div style="width:70px; height:70px; border-radius:12px; background: linear-gradient(135deg, #FF7A00, #FF7A00); display:flex; align-items:center; justify-content:center; font-size:32px; flex-shrink:0;">🥟</div>
                    @endif
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">{{ $item->product->name }}</h6>
                        @if($item->variant)
                            <span class="badge bg-light text-dark border">{{ $item->variant->name }}</span>
                        @endif
                        <div class="fw-bold text-success mt-1">₹{{ number_format($item->variant ? $item->variant->price : $item->product->base_price, 0) }}</div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-outline-success btn-sm rounded-circle qty-btn" style="width:32px;height:32px;" onclick="updateQty({{ $item->id }}, {{ $item->quantity - 1 }})">
                            <i class="bi bi-dash"></i>
                        </button>
                        <span class="fw-bold fs-5" id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                        <button class="btn btn-success btn-sm rounded-circle qty-btn" style="width:32px;height:32px;" onclick="updateQty({{ $item->id }}, {{ $item->quantity + 1 }})">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-success fs-6" id="subtotal-{{ $item->id }}">₹{{ number_format($item->subtotal, 0) }}</div>
                        <button class="btn btn-link text-danger p-0 mt-1 small" onclick="removeItem({{ $item->id }})">
                            <i class="bi bi-trash3"></i> Remove
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Order Summary --}}
        <div class="col-lg-4" data-aos="fade-left">
            <div class="glass-card p-4 position-sticky" style="top: 90px;">
                <h5 class="fw-bold mb-4">Order Summary</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span class="fw-bold" id="cart-subtotal">₹{{ number_format($cart->total, 0) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>GST (5%)</span>
                    <span class="fw-bold" id="cart-tax">₹{{ number_format($cart->total * 0.05, 0) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Delivery Fee</span>
                    <span class="fw-bold text-success">₹{{ $cart->total > 300 ? 0 : 40 }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <span class="fw-bold fs-5">Total</span>
                    <span class="fw-bold fs-5 text-success" id="cart-total">
                        ₹{{ number_format($cart->total + ($cart->total * 0.05) + ($cart->total > 300 ? 0 : 40), 0) }}
                    </span>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn btn-premium w-100 py-3 d-flex align-items-center justify-content-center gap-2 fs-6">
                    <i class="bi bi-lock-fill"></i> Proceed to Checkout
                </a>
                <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary w-100 mt-2 rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i> Continue Shopping
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-5" data-aos="zoom-in">
        <div style="font-size: 100px; margin-bottom: 20px;">🛒</div>
        <h4 class="fw-bold">Your cart is empty</h4>
        <p class="text-muted mb-4">Looks like you haven't added any momos yet.</p>
        <a href="{{ route('menu.index') }}" class="btn btn-premium btn-lg px-5">
            <i class="bi bi-card-checklist me-2"></i> Browse Menu
        </a>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function updateQty(itemId, qty) {
    if (qty < 1) { removeItem(itemId); return; }
    $.ajax({
        url: "{{ route('cart.update') }}",
        method: 'POST',
        data: { _token: "{{ csrf_token() }}", item_id: itemId, quantity: qty },
        success: function(res) {
            if (res.success) {
                $('#qty-' + itemId).text(qty);
                $('#subtotal-' + itemId).text('₹' + Math.round(res.item_subtotal));
                location.reload(); // Simple refresh for cart total update
            }
        }
    });
}

function removeItem(itemId) {
    Swal.fire({
        title: 'Remove Item?',
        text: 'Are you sure you want to remove this item from your cart?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF7A00',
        cancelButtonColor: '#0E101A',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('cart.remove') }}",
                method: 'POST',
                data: { _token: "{{ csrf_token() }}", item_id: itemId },
                success: function(res) {
                    if (res.success) {
                        $('#cart-item-' + itemId).fadeOut(400, function() {
                            $(this).remove();
                            if ($('.cart-item-row').length === 0) location.reload();
                        });
                    }
                }
            });
        }
    });
}
</script>
@endsection
