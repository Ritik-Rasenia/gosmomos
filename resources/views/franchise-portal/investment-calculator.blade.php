@extends('layouts.app')

@section('title', 'ROI Calculator — GOS MOMO')

@section('styles')
<style>
.fran-sidebar {
    background: white;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
}
.sidebar-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 12px;
    color: #495057;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}
.sidebar-link:hover, .sidebar-link.active {
    background: rgba(212, 160, 23, 0.08);
    color: #B38613;
}
.calculator-box {
    background: #FFF8F0;
    border-radius: 24px;
    border: 1px solid rgba(212,160,23,0.2);
}
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row g-4">
        {{-- Sidebar --}}
        <div class="col-lg-3">
            <div class="fran-sidebar">
                <div class="text-center mb-4">
                    <div style="width:70px; height:70px; border-radius:50%; background: linear-gradient(135deg, #FF7A00, #FF7A00); color:white; display:flex; align-items:center; justify-content:center; font-size:30px; font-weight:700; margin: 0 auto 12px;">
                        🏢
                    </div>
                    <h5 class="fw-bold mb-1">Franchise Partner</h5>
                    <span class="badge bg-warning text-dark rounded-pill px-3">{{ Auth::user()->name }}</span>
                </div>
                <hr>
                <div class="d-flex flex-column gap-1">
                    <a href="{{ route('franchise.dashboard') }}" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                    <a href="{{ route('franchise.roi') }}" class="sidebar-link active">
                        <i class="bi bi-calculator-fill"></i> ROI Calculator
                    </a>
                    <a href="{{ route('franchise.training') }}" class="sidebar-link">
                        <i class="bi bi-journal-bookmark-fill"></i> Training Academy
                    </a>
                    <a href="{{ route('franchise.documents') }}" class="sidebar-link">
                        <i class="bi bi-file-earmark-lock-fill"></i> Legal Documents
                    </a>
                    <a href="{{ route('franchise.opportunities') }}" class="sidebar-link">
                        <i class="bi bi-geo-alt-fill"></i> Expansion Zones
                    </a>
                    <hr>
                    <a href="{{ route('logout') }}" class="sidebar-link text-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        {{-- ROI Calculator --}}
        <div class="col-lg-9">
            <div class="calculator-box p-4 p-md-5">
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
