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
                        <div class="small mb-1">Total Influencers</div>
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

    {{-- //Top Selling --}}
   <div class="col-md-12">
    <div class="card h-100">
        <div class="card-header">Top Selling Dealers & Executives</div>
        <div class="card-body">
            <canvas id="topSalesChart" style="min-height:300px;"></canvas>
        </div>
    </div>
</div>


     <!-- Promotor Points Chart -->
    <div class="col-6">
        <div class="card h-100">
            <div class="card-header">Promotor Points Leaderboard</div>
            <div class="card-body">
                <canvas id="promotorPointsChart" style="height:250px; width:250px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Dealer vs Executive Pie Chart -->
    <div class="col-6">
        <div class="card h-100">
            <div class="card-header">Dealer vs Executive Sale Entries</div>
            <div class="card-body">
                <canvas id="dealerExecutiveChart" style="height:250px; width:250px;"></canvas>
            </div>
        </div>
    </div>


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
    <div class="col-md-12 col-lg-12">
        <div class="card h-100">
            <div class="card-header">Sales Trend</div>
            <div class="card-body">
                <canvas id="salesTrendChart" style="min-height:300px;"></canvas>
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

   // Promotor Points Leaderboard - Doughnut Chart
const promotors = @json($promotorschart->pluck('name'));
const points = @json($promotorschart->pluck('points'));

// Generate random colors for each promotor
const colors = promotors.map(() => '#' + Math.floor(Math.random()*16777215).toString(16));

new Chart(document.getElementById('promotorPointsChart'), {
    type: 'doughnut', // changed from 'bar' to 'doughnut'
    data: {
        labels: promotors,
        datasets: [{
            label: 'Points',
            data: points,
            backgroundColor: colors // assign different color to each user
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right'
            }
        }
    }
});


   // Dealer vs Executive Sale Entries - Bigger & Simpler
new Chart(document.getElementById('dealerExecutiveChart'), {
    type: 'doughnut',
    data: {
        labels: ['Dealers', 'Executives'],
        datasets: [{
            data: [{{ $dealerCount }}, {{ $executiveCount }}],
            backgroundColor: [
                'rgba(54, 162, 235, 0.85)', // Blue
                'rgba(255, 99, 132, 0.85)'  // Red
            ],
            borderColor: '#fff',
            borderWidth: 3,
            hoverOffset: 20
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '60%', // Thinner ring for bigger appearance
        radius: '90%', // Maximize size
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    font: { size: 16 },
                    generateLabels: chart => {
                        const data = chart.data.datasets[0].data;
                        const total = data.reduce((a, b) => a + b, 0);
                        return chart.data.labels.map((label, i) => ({
                            text: `${label}: ${data[i]} (${(data[i]/total*100).toFixed(1)}%)`,
                            fillStyle: chart.data.datasets[0].backgroundColor[i]
                        }));
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: ctx => {
                        const value = ctx.parsed;
                        const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                        return `${ctx.label}: ${value} (${(value/total*100).toFixed(1)}%)`;
                    }
                }
            }
        }
    }
});



  const dealerLabels = {!! json_encode($topDealers->pluck('dealer.name')) !!};
const dealerData = {!! json_encode($topDealers->pluck('total_quantity')) !!};
const executiveLabels = {!! json_encode($topExecutives->pluck('executive.name')) !!};
const executiveData = {!! json_encode($topExecutives->pluck('total_quantity')) !!};

// Create grouped bar chart
new Chart(document.getElementById('topSalesChart'), {
    type: 'bar',
    data: {
        // Combine labels for x-axis
        labels: [...dealerLabels, ...executiveLabels],
        datasets: [
            {
                label: 'Dealers',
                data: [...dealerData, ...Array(executiveLabels.length).fill(0)], // Pad with zeros for executives
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2
            },
            {
                label: 'Executives',
                data: [...Array(dealerLabels.length).fill(0), ...executiveData], // Pad with zeros for dealers
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    font: { size: 14 },
                    color: '#333'
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.dataset.label}: ${context.raw} units`;
                    }
                }
            },
            title: {
                display: true,
                text: 'Top Selling Dealers vs Executives',
                font: { size: 16 }
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Sales Representatives'
                },
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Units Sold'
                },
                grid: {
                    color: 'rgba(200,200,200,0.3)'
                }
            }
        }
    }
});
</script>
@endpush