@extends('layouts.app')

@section('title', 'Catering & Events — GOS MOMO')

@section('styles')
<style>
/* Mobile background */
@media (max-width: 575.98px) {
    .page-hero {
        background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/catering-mobile.jpg') }}') !important;
        background-size: cover !important;
        background-position: center !important;
    }
}
/* Tablet background */
@media (min-width: 576px) and (max-width: 991.98px) {
    .page-hero {
        background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/catering-tablet.png') }}') !important;
        background-size: cover !important;
        background-position: center !important;
    }
}
/* Laptop background */
@media (min-width: 992px) and (max-width: 1199.98px) {
    .page-hero {
        background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/catering-laptop.png') }}') !important;
        background-size: cover !important;
        background-position: center !important;
    }
}
/* Desktop background */
@media (min-width: 1200px) {
    .page-hero {
        background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/catering-desktop.jpg') }}') !important;
        background-size: cover !important;
        background-position: center !important;
    }
}
.catering-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.05);
    border: none;
}
</style>
@endsection

@section('content')
<section class="page-hero text-center">
    <div class="container" data-aos="fade-up">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3 text-uppercase">Make It Special</span>
        <h1 class="display-4 fw-extrabold text-white mb-2">Catering & Event Bookings</h1>
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Catering</li>
            </ol>
        </nav>
        <p class="lead text-white-75 max-width-600 mx-auto">Treat your guests to the crunchiest, fresh momos prepared live at your venue!</p>
    </div>
</section>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-6" data-aos="fade-right">
            <h2 class="fw-bold text-primary-color mb-4">Live Momo Counter at Your Event</h2>
            <p class="text-muted">Whether it is a wedding, birthday party, corporate gathering, or a small family event, GOS MOMO brings a complete live setup to serve fresh, steaming hot momos to your guests.</p>
            
            <div class="d-flex flex-column gap-3 my-4">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:40px; height:40px; border-radius:50%; background:rgba(15,81,50,0.1); color:#FF7A00; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="bi bi-check-lg fw-bold"></i>
                    </div>
                    <span class="fw-semibold text-muted">Custom Menu Tailored to Your Guest Preferences</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div style="width:40px; height:40px; border-radius:50%; background:rgba(15,81,50,0.1); color:#FF7A00; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="bi bi-check-lg fw-bold"></i>
                    </div>
                    <span class="fw-semibold text-muted">Complete Live Prep Station with Trained Chefs</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div style="width:40px; height:40px; border-radius:50%; background:rgba(15,81,50,0.1); color:#FF7A00; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="bi bi-check-lg fw-bold"></i>
                    </div>
                    <span class="fw-semibold text-muted">100% Hygienic Setup and Elegant Presentation</span>
                </div>
            </div>

            <div class="p-4 bg-light rounded-4 border-start border-4 border-success mt-4">
                <h5 class="fw-bold mb-2">Need a Custom Package?</h5>
                <p class="text-muted small mb-0">Our catering managers can assist in customizing menus, combos, and live counter theme decorations. WhatsApp us directly at +91 88888 77777.</p>
            </div>
        </div>

        <div class="col-lg-6" data-aos="fade-left">
            <div class="catering-card p-4 p-md-5">
                <h4 class="fw-bold mb-4"><i class="bi bi-envelope-open me-2 text-success"></i>Book / Inquire Now</h4>

                @if(session('success'))
                    <div class="alert alert-success rounded-3 mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('catering.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Full Name *</label>
                            <input type="text" name="name" class="form-control rounded-3" placeholder="Aarav Sharma" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Email Address *</label>
                            <input type="email" name="email" class="form-control rounded-3" placeholder="aarav@gmail.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Phone Number *</label>
                            <input type="tel" name="phone" class="form-control rounded-3" placeholder="9876543210" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Event Type *</label>
                            <select name="event_type" class="form-select rounded-3" required>
                                <option value="">Select Event Type</option>
                                <option value="Birthday Party">Birthday Party</option>
                                <option value="Wedding Event">Wedding / Anniversary</option>
                                <option value="Corporate Gathering">Corporate Gathering</option>
                                <option value="Kitty Party">Kitty Party / Social Get-together</option>
                                <option value="Catering Order Only">Bulk Food Order (No Live Counter)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Event Date *</label>
                            <input type="date" name="event_date" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Expected Guests *</label>
                            <input type="number" name="guest_count" class="form-control rounded-3" placeholder="Min 10 guests" min="10" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">City *</label>
                            <input type="text" name="city" class="form-control rounded-3" placeholder="Noida / Lucknow" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Estimated Budget (INR)</label>
                            <input type="number" name="budget" class="form-control rounded-3" placeholder="Optional" min="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Additional Message / Special Requests</label>
                            <textarea name="message" class="form-control rounded-3" rows="3" placeholder="Tell us more about your event..."></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-premium w-100 py-3">Submit Catering Inquiry</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
