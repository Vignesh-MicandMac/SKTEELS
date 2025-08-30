@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('content')
<div class="row gy-4">
    <!-- Total Dealers Card -->
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar me-3">
                        <div class="avatar-initial bg-primary rounded shadow">
                            <i class="mdi mdi-account-group mdi-24px"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small mb-1">Total Dealers</div>
                        <h5 class="mb-0">{{ $dealers }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Executives Card -->
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar me-3">
                        <div class="avatar-initial bg-success rounded shadow">
                            <i class="mdi mdi-briefcase-account mdi-24px"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small mb-1">Total Executives</div>
                        <h5 class="mb-0">{{ $executives }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Promotors Card -->
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar me-3">
                        <div class="avatar-initial bg-warning rounded shadow">
                            <i class="mdi mdi-bullhorn mdi-24px"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small mb-1">Total Promotors</div>
                        <h5 class="mb-0">{{ $promotors }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Products Card -->
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar me-3">
                        <div class="avatar-initial bg-info rounded shadow">
                            <i class="mdi mdi-cart-outline mdi-24px"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small mb-1">Total Products</div>
                        <h5 class="mb-0">{{ $products }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Redeem Count Card -->
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar me-3">
                        <div class="avatar-initial bg-danger rounded shadow">
                            <i class="mdi mdi-ticket-confirmation-outline mdi-24px"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small mb-1">Total Redeem</div>
                        <h5 class="mb-0">{{$redeems}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Total Users Card -->
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar me-3">
                        <div class="avatar-initial bg-dark rounded shadow">
                            <i class="mdi mdi-account-group mdi-24px"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small mb-1">Total Users</div>
                        <h5 class="mb-0">{{$users}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row gy-4 mt-3">
    <!-- Dealer Stock Chart -->
    <div class="col-md-12 col-lg-12">
        <div class="card h-100">
            <div class="card-header">Dealer Stock Overview</div>
            <div class="card-body">
                <canvas id="dealerStockChart" style="min-height:300px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Sales Trend Chart -->
    <div class="col-md-12 col-lg-6">
        <div class="card h-100">
            <div class="card-header">Sales Trend</div>
            <div class="card-body">
                <canvas id="salesTrendChart" style="min-height:300px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Promotor Points Chart -->
    <div class="col-6">
        <div class="card h-100">
            <div class="card-header">Promotor Points Leaderboard</div>
            <div class="card-body">
                <canvas id="promotorPointsChart" style="min-height:350px;"></canvas>
            </div>
        </div>
    </div>

    
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart defaults for responsiveness
    Chart.defaults.responsive = true;
    Chart.defaults.maintainAspectRatio = false;

    // Dealer Stock Chart
    new Chart(document.getElementById('dealerStockChart'), {
        type: 'bar',
        data: {
            labels: @json($dealerStocks -> pluck('dealer.name')),
            datasets: [{
                    label: 'Total Stock',
                    data: @json($dealerStocks -> pluck('total_stock')),
                    backgroundColor: '#36a2eb'
                },
                {
                    label: 'Closing Stock',
                    data: @json($dealerStocks -> pluck('closing_stock')),
                    backgroundColor: '#ff6384'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Sales Trend Chart
    new Chart(document.getElementById('salesTrendChart'), {
        type: 'line',
        data: {
            labels: @json($salesTrend -> pluck('date')),
            datasets: [{
                    label: 'Dispatch',
                    data: @json($salesTrend -> pluck('dispatch')),
                    borderColor: '#36a2eb',
                    tension: 0.3,
                    fill: false
                },
                {
                    label: 'Promoter Sales',
                    data: @json($salesTrend -> pluck('promoter_sales')),
                    borderColor: '#ff9f40',
                    tension: 0.3,
                    fill: false
                },
                {
                    label: 'Other Sales',
                    data: @json($salesTrend -> pluck('other_sales')),
                    borderColor: '#4bc0c0',
                    tension: 0.3,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Promotor Points Leaderboard
    new Chart(document.getElementById('promotorPointsChart'), {
        type: 'bar',
        data: {
            labels: @json($promotorschart -> pluck('name')),
            datasets: [{
                label: 'Points',
                data: @json($promotorschart -> pluck('points')),
                backgroundColor: '#9966ff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endpush