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
    border-color: #FF7A00;
    background: rgba(15, 81, 50, 0.05);
    color: #FF7A00;
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
    border-color: #FF7A00;
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
                    <div class="d-flex align-items-center justify-content-between mb-3 gap-2">
                        <div class="d-flex align-items-center gap-2">
                            @if($item->product->image_url)
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" style="width:40px; height:40px; border-radius:6px; object-fit:cover; flex-shrink:0;">
                            @else
                                <div class="d-flex align-items-center justify-content-center text-white bg-orange" style="width:40px; height:40px; border-radius:6px; font-size:16px; background-color:#FF7A00 !important;">🥟</div>
                            @endif
                            <div>
                                <span class="fw-semibold small d-block">{{ $item->product->name }}</span>
                                @if($item->variant)
                                    <span class="text-muted d-block" style="font-size: 10px;">{{ $item->variant->name }}</span>
                                @endif
                                <span class="text-muted" style="font-size: 11px;">Qty: {{ $item->quantity }}</span>
                            </div>
                        </div>
                        <span class="fw-bold small text-success">₹{{ number_format($item->subtotal, 0) }}</span>
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
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
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

$(document).ready(function() {
    $('#checkout-form').on('submit', function(e) {
        const payMethod = $('input[name="payment_method"]:checked').val();
        
        // Intercept if Razorpay is chosen and payment ID is not yet generated
        if (payMethod === 'razorpay' && !$('#razorpay_payment_id').length) {
            e.preventDefault();
            
            const totalText = $('#summary-total').text().replace(/[^\d.]/g, '');
            const totalAmount = parseFloat(totalText);
            
            if (isNaN(totalAmount) || totalAmount <= 0) {
                Swal.fire('Error', 'Invalid order total.', 'error');
                return;
            }
            
            // Custom premium mock Razorpay Sandbox checkout modal
            Swal.fire({
                title: '<div class="d-flex align-items-center justify-content-center gap-2 mt-2"><img src="https://razorpay.com/favicon.png" style="width: 24px; height: 24px; object-fit: contain;"> <span style="color: #0b2559; font-weight: 800; font-family: var(--font-outfit);">Razorpay</span> <span class="badge bg-warning text-dark font-monospace" style="font-size: 10px !important; padding: 4px 8px; border-radius: 4px;">TEST SANDBOX</span></div>',
                html: `
                    <div class="text-center p-1" style="font-family: var(--font-poppins);">
                        <div class="mb-3 border-bottom pb-3 mt-2">
                            <span class="text-muted small d-block text-uppercase" style="letter-spacing: 0.5px; font-size: 11px;">MERCHANT</span>
                            <strong class="text-dark fs-5" style="font-family: var(--font-outfit);">GOS MOMO</strong>
                        </div>
                        <div class="mb-4">
                            <span class="text-muted small d-block text-uppercase" style="letter-spacing: 0.5px; font-size: 11px;">AMOUNT TO PAY</span>
                            <h2 class="fw-bold text-success mt-1" style="font-family: var(--font-outfit); font-size: 28px;">₹${totalAmount.toLocaleString('en-IN')}</h2>
                        </div>
                        <div class="alert alert-info py-2 small border-0 text-start d-flex align-items-start gap-2 mb-0" style="background-color: rgba(13, 202, 240, 0.08); border-radius: 10px;">
                            <i class="bi bi-info-circle-fill text-info fs-5 mt-0"></i>
                            <div style="font-size: 12px; color: #087990;">
                                You are in <strong>Sandbox Bypass Mode</strong>. This will simulate a successful online transaction and forward a mock transaction token.
                            </div>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-shield-fill-check me-1"></i> Simulate Payment Success',
                confirmButtonColor: '#0b2559',
                cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Cancel',
                cancelButtonColor: '#dc3545',
                customClass: {
                    popup: 'rounded-4 shadow-lg border-0',
                    confirmButton: 'px-4 py-2 rounded-pill fw-bold small',
                    cancelButton: 'px-4 py-2 rounded-pill fw-bold small'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const mockPaymentId = 'pay_test_' + Math.random().toString(36).substring(2, 16).toUpperCase();
                    
                    $('<input>').attr({
                        type: 'hidden',
                        id: 'razorpay_payment_id',
                        name: 'razorpay_payment_id',
                        value: mockPaymentId
                    }).appendTo('#checkout-form');
                    
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        icon: 'success',
                        title: 'Payment simulated successfully!',
                        timerProgressBar: true
                    });
                    
                    setTimeout(function() {
                        $('#checkout-form')[0].submit();
                    }, 1200);
                } else {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        icon: 'info',
                        title: 'Payment cancelled.',
                        timerProgressBar: true
                    });
                }
            });
        }
    });
});
</script>
@endsection
