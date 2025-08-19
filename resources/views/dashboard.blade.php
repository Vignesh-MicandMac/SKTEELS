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
                        <div class="small mb-1">Total Redeem Count</div>
                        <h5 class="mb-0">5</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection