@extends('layouts.app')

@section('title', 'Checkout — GOS MOMO')

@section('styles')
<style>
.checkout-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    border: none;
    padding: 30px;
}
.method-tab {
    cursor: pointer;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 15px;
    text-align: center;
    transition: all 0.3s ease;
    font-weight: 600;
}
.method-tab.active {
    border-color: #0F5132;
    background: rgba(15, 81, 50, 0.05);
    color: #0F5132;
}
.address-card {
    cursor: pointer;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
}
.address-card.active {
    border-color: #0F5132;
    background: rgba(15, 81, 50, 0.03);
}
</style>
@endsection

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4" data-aos="fade-up"><i class="bi bi-shield-check me-2 text-success"></i> Secure Checkout</h2>

    @if(session('error'))
        <div class="alert alert-danger rounded-3 mb-4">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('checkout.place') }}" id="checkout-form">
        @csrf
        <div class="row g-4">
            {{-- Delivery details --}}
            <div class="col-lg-8" data-aos="fade-right">
                <div class="checkout-card mb-4">
                    <h5 class="fw-bold mb-4">1. Delivery Option</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="method-tab active" id="tab-delivery" onclick="setMethod('delivery')">
                                <i class="bi bi-truck fs-3 d-block mb-1"></i>
                                Delivery to Address
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="method-tab" id="tab-pickup" onclick="setMethod('pickup')">
                                <i class="bi bi-shop fs-3 d-block mb-1"></i>
                                Self Pickup
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="delivery_method" id="delivery_method" value="delivery">

                    {{-- Address list --}}
                    <div id="delivery-addresses-section">
                        <h6 class="fw-bold mb-3">Select Delivery Address</h6>
                        @forelse($addresses as $addr)
                        <div class="address-card {{ $loop->first ? 'active' : '' }}" onclick="selectAddress({{ $addr->id }}, this)">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-success mb-2">{{ ucfirst($addr->label) }}</span>
                                    <div class="fw-bold">{{ $addr->address_line_1 }}</div>
                                    <div class="text-muted small">{{ $addr->city }}, {{ $addr->state }} - {{ $addr->pincode }}</div>
                                </div>
                                <i class="bi bi-check-circle-fill text-success fs-4 check-icon {{ $loop->first ? '' : 'd-none' }}"></i>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 border rounded-3 mb-3">
                            <p class="text-muted mb-3">No delivery address saved yet.</p>
                            <a href="{{ route('customer.addresses') }}" class="btn btn-outline-success btn-sm rounded-pill"><i class="bi bi-plus-circle me-1"></i> Add Address</a>
                        </div>
                        @endforelse
                        <input type="hidden" name="address_id" id="address_id" value="{{ $addresses->first()?->id }}">
                    </div>

                    {{-- Locations list (pickup outlet) --}}
                    <div id="pickup-locations-section" class="d-none">
                        <h6 class="fw-bold mb-3">Select Pickup Location</h6>
                        @foreach($locations as $loc)
                        <div class="address-card {{ $loop->first ? 'active' : '' }}" onclick="selectLocation({{ $loc->id }}, this)">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">{{ $loc->name }}</div>
                                    <div class="text-muted small">{{ $loc->address }}, {{ $loc->city }}</div>
                                </div>
                                <i class="bi bi-check-circle-fill text-success fs-4 check-icon {{ $loop->first ? '' : 'd-none' }}"></i>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="location_id" id="location_id" value="{{ $locations->first()?->id }}">
                </div>

                {{-- Payment Method --}}
                <div class="checkout-card mb-4">
                    <h5 class="fw-bold mb-4">2. Payment Method</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="address-card w-100 active text-center py-4 mb-0" id="pay-cod-label">
                                <input type="radio" name="payment_method" value="cod" checked class="d-none" onchange="selectPayment('cod')">
                                <i class="bi bi-cash-coin fs-2 d-block mb-1 text-success"></i>
                                <span class="fw-bold d-block small">Cash on Delivery</span>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label class="address-card w-100 text-center py-4 mb-0" id="pay-razorpay-label">
                                <input type="radio" name="payment_method" value="razorpay" class="d-none" onchange="selectPayment('razorpay')">
                                <i class="bi bi-credit-card-2-front fs-2 d-block mb-1 text-primary"></i>
                                <span class="fw-bold d-block small">Online Payment</span>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label class="address-card w-100 text-center py-4 mb-0" id="pay-wallet-label">
                                <input type="radio" name="payment_method" value="wallet" class="d-none" onchange="selectPayment('wallet')">
                                <i class="bi bi-wallet2 fs-2 d-block mb-1 text-warning"></i>
                                <span class="fw-bold d-block small">GOS Wallet (₹{{ number_format($walletBalance, 2) }})</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Special Instructions --}}
                <div class="checkout-card">
                    <h5 class="fw-bold mb-3">3. Cooking Instructions</h5>
                    <textarea name="special_instructions" class="form-control rounded-3" rows="3" placeholder="e.g. Make it extra spicy, don't ring the doorbell, etc."></textarea>
                </div>
            </div>

            {{-- Summary Panel --}}
            <div class="col-lg-4" data-aos="fade-left">
                <div class="checkout-card position-sticky" style="top: 90px;">
                    <h5 class="fw-bold mb-4">Your Order</h5>
                    @foreach($cart->items as $item)
                    <div class="d-flex justify-content-between mb-3 small">
                        <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                        <span class="fw-bold">₹{{ number_format($item->subtotal, 0) }}</span>
                    </div>
                    @endforeach
                    <hr>

                    {{-- Coupon Input --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Have a Coupon?</label>
                        <div class="input-group">
                            <input type="text" id="coupon-code-input" class="form-control rounded-start-3" placeholder="GOSMOMO50">
                            <button type="button" class="btn btn-success rounded-end-3" onclick="applyCouponCode()">Apply</button>
                        </div>
                        <input type="hidden" name="coupon_code" id="applied-coupon-code">
                        <div id="coupon-message" class="small mt-2"></div>
                    </div>

                    <div class="d-flex justify-content-between mb-2 small">
                        <span>Subtotal</span>
                        <span id="summary-subtotal">₹{{ number_format($subtotal, 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small d-none" id="discount-row">
                        <span class="text-danger">Coupon Discount</span>
                        <span class="fw-bold text-danger" id="summary-discount">-₹0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span>GST (5%)</span>
                        <span id="summary-tax">₹{{ number_format($tax, 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 small">
                        <span>Delivery Fee</span>
                        <span id="summary-delivery">₹{{ number_format($deliveryFee, 0) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Grand Total</span>
                        <span class="fw-bold fs-5 text-success" id="summary-total">₹{{ number_format($total, 0) }}</span>
                    </div>

                    <button type="submit" class="btn btn-premium w-100 py-3 d-flex align-items-center justify-content-center gap-2 fs-6">
                        <i class="bi bi-lock-fill"></i> Place Order
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
function setMethod(method) {
    $('.method-tab').removeClass('active');
    if (method === 'delivery') {
        $('#tab-delivery').addClass('active');
        $('#delivery-addresses-section').removeClass('d-none');
        $('#pickup-locations-section').addClass('d-none');
        $('#delivery_method').val('delivery');
    } else {
        $('#tab-pickup').addClass('active');
        $('#delivery-addresses-section').addClass('d-none');
        $('#pickup-locations-section').removeClass('d-none');
        $('#delivery_method').val('pickup');
    }
}

function selectAddress(id, el) {
    $('#delivery-addresses-section .address-card').removeClass('active');
    $('#delivery-addresses-section .check-icon').addClass('d-none');
    $(el).addClass('active');
    $(el).find('.check-icon').removeClass('d-none');
    $('#address_id').val(id);
}

function selectLocation(id, el) {
    $('#pickup-locations-section .address-card').removeClass('active');
    $('#pickup-locations-section .check-icon').addClass('d-none');
    $(el).addClass('active');
    $(el).find('.check-icon').removeClass('d-none');
    $('#location_id').val(id);
}

function selectPayment(method) {
    $('#pay-cod-label, #pay-razorpay-label, #pay-wallet-label').removeClass('active');
    $('#pay-' + method + '-label').addClass('active');
}

function applyCouponCode() {
    const code = $('#coupon-code-input').val().trim();
    if (!code) return;

    $.ajax({
        url: "{{ route('checkout.coupon') }}",
        method: "POST",
        data: { _token: "{{ csrf_token() }}", code: code },
        success: function(res) {
            if (res.success) {
                $('#applied-coupon-code').val(res.code);
                $('#coupon-message').removeClass('text-danger').addClass('text-success').text(res.message);
                $('#discount-row').removeClass('d-none');
                $('#summary-discount').text('-₹' + Math.round(res.discount));
                $('#summary-tax').text('₹' + Math.round(res.tax));
                $('#summary-delivery').text('₹' + Math.round(res.delivery_fee));
                $('#summary-total').text('₹' + Math.round(res.total));
            }
        },
        error: function(xhr) {
            $('#applied-coupon-code').val('');
            $('#coupon-message').removeClass('text-success').addClass('text-danger').text(xhr.responseJSON?.message || 'Error applying coupon.');
        }
    });
}
</script>
@endsection
