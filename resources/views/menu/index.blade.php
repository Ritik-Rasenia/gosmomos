@extends('layouts.app')
@section('title', 'Menu — GOS MOMO')
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
.filter-bar { background: white; border-bottom: 1px solid rgba(0,0,0,0.06); padding: 16px 0; position: sticky; top: 70px; z-index: 100; box-shadow: 0 4px 20px rgba(0,0,0,0.04); }
.filter-chip { display: inline-flex; align-items: center; gap: 6px; padding: 6px 16px; border-radius: 8px; border: 2px solid #e9ecef; background: white; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-decoration: none; color: #495057; }
.filter-chip:hover, .filter-chip.active { border-color: #FF7A00; background: #FF7A00; color: white; }
.product-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05); transition: all 0.3s ease; }
.product-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(15,81,50,0.1); }
.product-img-placeholder { height: 180px; background: linear-gradient(135deg, #FF7A00, #FF7A00); display: flex; align-items: center; justify-content: center; font-size: 60px; }
.price-tag { font-size: 1.2rem; font-weight: 800; color: #FF7A00; font-family: 'Outfit',sans-serif; }
.veg-dot { width: 20px; height: 20px; border: 2px solid #28a745; border-radius: 3px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.veg-dot::after { content: ''; width: 8px; height: 8px; background: #28a745; border-radius: 50%; }
.nonveg-dot { width: 20px; height: 20px; border: 2px solid #dc3545; border-radius: 3px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.nonveg-dot::after { content: ''; width: 0; height: 0; border-left: 5px solid transparent; border-right: 5px solid transparent; border-bottom: 8px solid #dc3545; }
.btn-add { background: linear-gradient(135deg, #FF7A00, #E26C00); color: white; border: none; border-radius: 8px; padding: 7px 18px; font-weight: 600; font-size: 13px; cursor: pointer; transition: all 0.3s ease; }
.btn-add:hover { transform: scale(1.05); box-shadow: 0 4px 15px rgba(15,81,50,0.3); }
.spice-indicator { display: flex; gap: 2px; }
.spice-dot { width: 6px; height: 6px; border-radius: 50%; background: #e9ecef; }
.spice-dot.active { background: #E63946; }
.text-hover-orange { transition: color 0.2s ease-in-out; }
.text-hover-orange:hover { color: #FF7A00 !important; }
</style>
@endsection

@section('content')
<section class="page-hero text-center">
    <div class="container" data-aos="fade-up">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3 text-uppercase">Fresh & Tasty</span>
        <h1 class="display-4 fw-extrabold text-white mb-2">Our Menu 🥟</h1>
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Menu</li>
            </ol>
        </nav>
        <p class="lead text-white-75 max-width-600 mx-auto">Fresh, hygienic, and made with love. Pick your momo mood!</p>
    </div>
</section>

<div class="filter-bar">
    <div class="container">
        <div class="d-flex gap-2 flex-nowrap overflow-auto pb-1">
            <a href="{{ route('menu.index') }}" class="filter-chip {{ !request('category') ? 'active' : '' }}">
                <i class="bi bi-grid"></i> All
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('menu.index', ['category' => $cat->slug]) }}" class="filter-chip {{ request('category') == $cat->slug ? 'active' : '' }}">
                <i class="bi {{ $cat->icon ?? 'bi-circle' }}"></i> {{ $cat->name }}
            </a>
            @endforeach
            <a href="{{ route('menu.index', array_merge(request()->query(), ['veg' => 1])) }}" class="filter-chip {{ request('veg') == 1 ? 'active' : '' }}" style="{{ request('veg') == 1 ? 'border-color: #28a745; background: #28a745;' : '' }}">
                <span class="veg-dot d-inline-flex me-1"></span> Veg Only
            </a>
        </div>
    </div>
</div>

<div class="container py-5">
    {{-- Search Bar --}}
    <form method="GET" action="{{ route('menu.index') }}" class="mb-4" data-aos="fade-up">
        <div class="input-group" style="max-width: 400px;">
            <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px;">
                <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" name="search" class="form-control border-start-0" placeholder="Search momos..." value="{{ request('search') }}" style="border-radius: 0 12px 12px 0; border-left: none;">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
        </div>
    </form>

    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 80 }}">
            <div class="product-card">
                <div class="position-relative">
                    <a href="{{ route('menu.show', $product->slug) }}">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-100" style="height:180px; object-fit:cover;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1625220194771-7ebedd0b4d11?auto=format&fit=crop&w=600&q=80';">
                        @else
                            <div class="product-img-placeholder">🥟</div>
                        @endif
                    </a>

                    @if($product->is_bestseller)
                        <span class="position-absolute top-0 start-0 m-2 badge" style="background:#E63946; font-size: 10px;">BESTSELLER</span>
                    @endif
                    @if($product->is_new)
                        <span class="position-absolute top-0 {{ $product->is_bestseller ? 'start-50' : 'start-0' }} m-2 badge" style="background:#FF7A00; font-size: 10px;">NEW</span>
                    @endif
                </div>
                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="{{ $product->is_veg ? 'veg-dot' : 'nonveg-dot' }}"></div>
                        <div class="d-flex align-items-center gap-1 text-warning small fw-bold">
                            <i class="bi bi-star-fill" style="font-size: 11px;"></i>
                            {{ $product->average_rating }}
                        </div>
                    </div>
                    <a href="{{ route('menu.show', $product->slug) }}" class="text-decoration-none text-dark">
                        <h6 class="fw-bold mb-1 text-hover-orange">{{ $product->name }}</h6>
                    </a>
                    <p class="text-muted small mb-2" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $product->short_description }}</p>

                    {{-- Spice Level --}}
                    @if($product->spice_level > 0)
                    <div class="d-flex align-items-center gap-1 mb-2">
                        <span class="text-muted" style="font-size: 11px;">Spice:</span>
                        <div class="spice-indicator">
                            @for($s = 1; $s <= 3; $s++)
                                <div class="spice-dot {{ $s <= $product->spice_level ? 'active' : '' }}"></div>
                            @endfor
                        </div>
                    </div>
                    @endif

                    {{-- Variants --}}
                    @if($product->variants->count() > 1)
                    <div class="mb-2">
                        <select class="form-select form-select-sm variant-select" data-product-id="{{ $product->id }}" style="font-size: 12px; border-radius: 8px;">
                            @foreach($product->variants as $variant)
                                <option value="{{ $variant->id }}" data-price="{{ $variant->price }}">{{ $variant->name }} — ₹{{ number_format($variant->price, 0) }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="price-tag">
                            ₹{{ number_format($product->variants->first() ? $product->variants->first()->price : $product->base_price, 0) }}
                        </span>
                        <button class="btn-add add-to-cart-btn"
                            data-product-id="{{ $product->id }}"
                            data-product-name="{{ $product->name }}">
                            <i class="bi bi-plus-lg me-1"></i> Add
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5" data-aos="fade-up">
            <div style="font-size: 80px; margin-bottom: 20px;">🥟</div>
            <h4 class="fw-bold text-muted">No items found</h4>
            <p class="text-muted">Try a different category or search term.</p>
            <a href="{{ route('menu.index') }}" class="btn btn-premium">View All Items</a>
        </div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Dynamic price updater when selecting different variants
    $(document).on('change', '.variant-select', function() {
        const select = $(this);
        const price = select.find(':selected').data('price');
        const card = select.closest('.product-card');
        card.find('.price-tag').text('₹' + parseFloat(price).toFixed(0));
    });

    $(document).on('click', '.add-to-cart-btn', function() {
        const btn = $(this);
        const card = btn.closest('.product-card');
        const productId = btn.data('product-id');
        const variantSelect = card.find('.variant-select');
        const variantId = variantSelect.length ? variantSelect.val() : null;

        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i>');

        $.ajax({
            url: "{{ route('cart.add') }}",
            method: 'POST',
            data: { _token: "{{ csrf_token() }}", product_id: productId, variant_id: variantId, quantity: 1 },
            success: function(res) {
                if (res.success) {
                    btn.html('<i class="bi bi-check-lg"></i>');
                    setTimeout(() => btn.prop('disabled', false).html('<i class="bi bi-plus-lg me-1"></i> Add'), 1500);
                    const count = res.cart_count;
                    $('#desktop-cart-count, #mobile-cart-badge, #mobile-bottom-cart-badge, #floating-cart-badge').text(count).removeClass('d-none');
                }
            },
            error: () => { btn.prop('disabled', false).html('<i class="bi bi-plus-lg me-1"></i> Add'); }
        });
    });
});
</script>
@endsection
