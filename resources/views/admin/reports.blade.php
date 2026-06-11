@extends('layouts.admin')
@section('title', 'Sales Reports — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Reports & Analytics</h4>
        <p class="text-muted mb-0">Monitor platform sales, franchise lead conversions, and store performance.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card p-4 h-100">
            <h5 class="fw-bold mb-4">Monthly Revenue Trend</h5>
            <canvas id="revenueChart" style="max-height: 300px;"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card p-4 h-100">
            <h5 class="fw-bold mb-4">Top Performing Products</h5>
            <canvas id="productChart" style="max-height: 300px;"></canvas>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Revenue Chart
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Monthly Sales (INR)',
                data: [120000, 190000, 300000, 500000, 200000, 420000],
                borderColor: '#0F5132',
                backgroundColor: 'rgba(15, 81, 82, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Product Performance Chart
    new Chart(document.getElementById('productChart'), {
        type: 'doughnut',
        data: {
            labels: ['Steamed Veg', 'Kurkure Chicken', 'Tandoori Paneer'],
            datasets: [{
                data: [45, 35, 20],
                backgroundColor: ['#0F5132', '#D4A017', '#E63946']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});
</script>
@endsection
