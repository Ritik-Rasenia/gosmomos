@extends('layouts.app')

@section('title', 'Franchise Opportunities — GOS MOMO')

@section('styles')
<style>
.fran-hero {
    background: linear-gradient(135deg, #0a3620 0%, #0F5132 100%);
    padding: 100px 0 60px;
    color: white;
}
.model-card {
    background: white;
    border-radius: 20px;
    border: 2px solid transparent;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    overflow: hidden;
}
.model-card:hover {
    transform: translateY(-5px);
    border-color: #D4A017;
    box-shadow: 0 15px 40px rgba(212,160,23,0.15);
}
.calculator-box {
    background: #FFF8F0;
    border-radius: 24px;
    border: 1px solid rgba(212,160,23,0.2);
}
</style>
@endsection

@section('content')
<div class="fran-hero text-center">
    <div class="container">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">Expansion Plan</span>
        <h1 class="display-5 fw-bold text-white">Franchise Opportunities</h1>
        <p class="lead text-white-75 mb-0">Partner with India's fastest-growing premium momo startup and build a highly profitable business.</p>
    </div>
</div>

<div class="container py-5" id="models">
    <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="fw-bold text-primary-color">Choose Your Business Model</h2>
        <p class="text-muted">Flexible models tailored to your investment budget and location availability.</p>
    </div>

    <div class="row g-4">
        {{-- Cart Model --}}
        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="model-card p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div style="font-size: 50px; margin-bottom: 15px;">🛒</div>
                    <h4 class="fw-bold text-primary-color mb-2">Cart Model</h4>
                    <p class="text-muted small">Ideal for street food corners, market lanes, and high-footfall tourist spots.</p>
                    <hr>
                    <ul class="list-unstyled d-flex flex-column gap-2 text-muted small my-4">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Investment: <strong>₹3 - ₹5 Lakhs</strong></li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Area Required: <strong>50 - 100 sq ft</strong></li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Staff Required: <strong>1 - 2 Persons</strong></li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Expected ROI: <strong>6 - 9 Months</strong></li>
                    </ul>
                </div>
                <a href="#apply" class="btn btn-premium w-100">Select & Apply</a>
            </div>
        </div>

        {{-- Kiosk Model --}}
        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="model-card p-4 h-100 d-flex flex-column justify-content-between" style="border-color:#D4A017; box-shadow: 0 15px 40px rgba(212,160,23,0.1);">
                <div>
                    <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3 fw-bold rounded-pill">Popular</span>
                    <div style="font-size: 50px; margin-bottom: 15px;">🏪</div>
                    <h4 class="fw-bold text-primary-color mb-2">Kiosk Model</h4>
                    <p class="text-muted small">Ideal for mall food courts, tech parks, metro stations, and hypermarket zones.</p>
                    <hr>
                    <ul class="list-unstyled d-flex flex-column gap-2 text-muted small my-4">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Investment: <strong>₹8 - ₹10 Lakhs</strong></li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Area Required: <strong>100 - 200 sq ft</strong></li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Staff Required: <strong>2 - 3 Persons</strong></li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Expected ROI: <strong>9 - 12 Months</strong></li>
                    </ul>
                </div>
                <a href="#apply" class="btn btn-premium w-100 bg-warning text-dark border-0">Select & Apply</a>
            </div>
        </div>

        {{-- Outlet Model --}}
        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
            <div class="model-card p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div style="font-size: 50px; margin-bottom: 15px;">🏢</div>
                    <h4 class="fw-bold text-primary-color mb-2">Outlet Model</h4>
                    <p class="text-muted small">Full-scale restaurant outlet with indoor seating, cloud-kitchen setup, and delivery hub.</p>
                    <hr>
                    <ul class="list-unstyled d-flex flex-column gap-2 text-muted small my-4">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Investment: <strong>₹15 - ₹20 Lakhs</strong></li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Area Required: <strong>300 - 500 sq ft</strong></li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Staff Required: <strong>4 - 5 Persons</strong></li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Expected ROI: <strong>12 - 18 Months</strong></li>
                    </ul>
                </div>
                <a href="#apply" class="btn btn-premium w-100">Select & Apply</a>
            </div>
        </div>
    </div>
</div>

{{-- ROI Calculator --}}
<div class="container py-5">
    <div class="calculator-box p-4 p-md-5" data-aos="zoom-in">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h3 class="fw-bold text-primary-color mb-3"><i class="bi bi-calculator me-2"></i>Estimate Your Returns</h3>
                <p class="text-muted">Use our interactive ROI estimator to see the projected monthly profit and payback timeline for your selected location model.</p>
                <div class="mb-4">
                    <label class="form-label fw-semibold small">Choose Franchise Model</label>
                    <select id="roi-model" class="form-select rounded-3" onchange="calculateROI()">
                        <option value="cart">Cart Model (₹3L Investment)</option>
                        <option value="kiosk" selected>Kiosk Model (₹8L Investment)</option>
                        <option value="outlet">Outlet Model (₹15L Investment)</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold small">Estimated Daily Plates Sold</label>
                    <input type="range" id="roi-sales" class="form-range" min="50" max="300" step="10" value="120" oninput="calculateROI()">
                    <div class="d-flex justify-content-between small text-muted">
                        <span>50 Plates</span>
                        <span class="fw-bold text-success fs-6"><span id="sales-value">120</span> Plates / day</span>
                        <span>300 Plates</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-4 bg-white rounded-4 shadow-sm border border-light">
                    <h5 class="fw-bold mb-4 text-center">Projected Monthly Profits</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Estimated Monthly Revenue</span>
                        <span class="fw-bold text-dark" id="monthly-revenue">₹3,60,000</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Raw Material Cost (35%)</span>
                        <span class="fw-bold text-danger" id="material-cost">₹1,26,000</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Operational Costs (Staff, Rent)</span>
                        <span class="fw-bold text-danger" id="operating-cost">₹90,000</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold fs-5 text-primary-color">Net Monthly Profit</span>
                        <span class="fw-bold fs-5 text-success" id="net-profit">₹1,44,000</span>
                    </div>
                    <div class="p-3 bg-success-subtle text-success rounded-3 text-center small fw-semibold">
                        Payback Period: ~<span id="payback-period">6</span> Months
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Application Form --}}
<div class="container py-5" id="apply">
    <div class="row justify-content-center">
        <div class="col-lg-10" data-aos="fade-up">
            <div class="bg-white rounded-4 shadow p-4 p-md-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-primary-color">Apply for GOS MOMO Franchise</h2>
                    <p class="text-muted">Complete the form below. Our expansion team will review and contact you within 24-48 hours.</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success rounded-3 mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('franchise.apply') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Full Name *</label>
                            <input type="text" name="name" class="form-control rounded-3" placeholder="Enter your full name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Email Address *</label>
                            <input type="email" name="email" class="form-control rounded-3" placeholder="Enter your email address" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Phone Number *</label>
                            <input type="tel" name="phone" class="form-control rounded-3" placeholder="10-digit mobile number" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Franchise Model Preference *</label>
                            <select name="franchise_type" class="form-select rounded-3" required>
                                <option value="">Select Model</option>
                                <option value="cart">Cart Model (Investment ₹3L)</option>
                                <option value="kiosk">Kiosk Model (Investment ₹8L)</option>
                                <option value="outlet">Outlet Model (Investment ₹15L)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Target City *</label>
                            <input type="text" name="city" class="form-control rounded-3" placeholder="Where do you plan to open?" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Target State *</label>
                            <input type="text" name="state" class="form-control rounded-3" placeholder="e.g. Uttar Pradesh" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Investment Budget *</label>
                            <select name="investment_budget" class="form-select rounded-3" required>
                                <option value="">Select Budget</option>
                                <option value="3-5 Lakhs">₹3 - ₹5 Lakhs</option>
                                <option value="5-10 Lakhs">₹5 - ₹10 Lakhs</option>
                                <option value="10-15 Lakhs">₹10 - ₹15 Lakhs</option>
                                <option value="15+ Lakhs">₹15 Lakhs +</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Upload ID Proof (PDF/JPG/PNG, Max 2MB)</label>
                            <input type="file" name="id_proof" class="form-control rounded-3">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Prior Food & Beverage Experience (Optional)</label>
                            <textarea name="experience" class="form-control rounded-3" rows="3" placeholder="Describe your business or job experience if any..."></textarea>
                        </div>
                        <div class="col-12 text-center mt-5">
                            <button type="submit" class="btn btn-premium btn-lg px-5">Submit Franchise Application</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function calculateROI() {
    const model = document.getElementById('roi-model').value;
    const dailyPlates = parseInt(document.getElementById('roi-sales').value);
    document.getElementById('sales-value').innerText = dailyPlates;

    let investment = 800000;
    let avgPlatePrice = 100;
    let operatingCost = 90000;

    if (model === 'cart') {
        investment = 300000;
        operatingCost = 40000;
    } else if (model === 'outlet') {
        investment = 1500000;
        operatingCost = 150000;
    }

    const monthlyRevenue = dailyPlates * avgPlatePrice * 30;
    const materialCost = monthlyRevenue * 0.35;
    const netProfit = monthlyRevenue - materialCost - operatingCost;
    const paybackPeriod = netProfit > 0 ? (investment / netProfit).toFixed(1) : 'Infinite';

    document.getElementById('monthly-revenue').innerText = '₹' + monthlyRevenue.toLocaleString('en-IN');
    document.getElementById('material-cost').innerText = '₹' + materialCost.toLocaleString('en-IN');
    document.getElementById('operating-cost').innerText = '₹' + operatingCost.toLocaleString('en-IN');
    document.getElementById('net-profit').innerText = '₹' + (netProfit > 0 ? netProfit : 0).toLocaleString('en-IN');
    document.getElementById('payback-period').innerText = paybackPeriod;
}
</script>
@endsection
