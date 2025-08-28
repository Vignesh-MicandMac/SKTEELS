@extends('layouts/contentNavbarLayout')

@section('title', 'Dealers List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="py-3 mb-0"><span class="text-muted fw-light">Masters /</span> Sites List </h5>
</div>


<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Search Sites </h5>
            </div>
            <div class="card-body">
                {{-- @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}
            </div>
            @endif --}}

            <form method="GET" action="{{ route('reports.sites_list') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="dealer_ids" class="form-label"> Dealers</label>
                        <select name="dealer_id" id="dealer-select" class="form-select select2">
                            <option value="">Select Dealer</option>
                            @foreach($dealers as $dealer)
                            <option value="{{ $dealer->id }}" {{ request('dealer_id') == $dealer->id ? 'selected' : '' }}>{{ $dealer->name }}</option>
                            @endforeach
                        </select>
                        @error('dealer_id') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="promotor_ids" class="form-label"> Executive</label>
                        <select name="executive_id" id="promotor-select" class="form-select select2">
                            <option value="">Select Executive</option>
                            @foreach($executives as $executive)
                            <option value="{{ $executive->id }}" {{ request('executive_id') == $executive->id ? 'selected' : '' }}>{{ $executive->name }}</option>
                            @endforeach
                        </select>
                        @error('executive_id') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="promotor_ids" class="form-label"> Influencer</label>
                        <select name="promotor_id" id="promotor-select" class="form-select select2">
                            <option value="">Select Influencer</option>
                            @foreach($promotors as $promotor)
                            <option value="{{ $promotor->id }}" {{ request('promotor_id') == $promotor->id ? 'selected' : '' }}>{{ $promotor->name }}</option>
                            @endforeach
                        </select>
                        @error('promotor_id') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>


                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        @error('start_date') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        @error('end_date') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>


                    <!-- <div class="col-md-4">
                        <label for="approved_status" class="form-label"> Approved Status</label>
                        <select name="approved_status" id="promotor-select" class="form-select select2">
                            <option value="">Select Status</option>
                            <option value="0" {{ request('approved_status') === '0' ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ request('approved_status') === '1' ? 'selected' : '' }}>Approved</option>
                            <option value="2" {{ request('approved_status') === '2' ? 'selected' : '' }}>UnApproved</option>
                        </select>
                        @error('approved_status') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div> -->
                </div>

                <div class="row justify-content-end">
                    <div class="col-sm-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('reports.sites_list') }}" class="btn btn-light btn-sm">Clear</a>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
</div>


<!-- Dealers Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dealersTable">
                <thead class="table-light">
                    <tr>
                        <th># No</th>
                        <th>Site Name</th>
                        <th>Influencer Name</th>
                        <th>Influencer Type</th>
                        <th>Dealer Name</th>
                        <th>Executive Name</th>
                        <th>Site Image</th>
                        <th>Visited Date</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>State</th>
                        <th>District</th>
                        <th>Pincode</th>
                        <th>Area</th>
                        <th>Door No</th>
                        <th>Contact No</th>
                        <th>Contact Person</th>
                        <th>Requirement Quantity</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($sites_list as $key => $sites)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $sites->site_name ?? 'N/A'}}</td>
                        <td>{{ $sites->promotor->name ?? 'N/A'}}</td>
                        <td>{{ $sites->promotorType->promotor_type ?? 'N/A'}}</td>
                        <td>{{ $sites->dealer->name ?? 'N/A'}}</td>
                        <td>{{ $sites->executive->name ?? 'N/A'}}</td>
                        <td>
                            @if($sites->img)
                            <img src="{{ asset('storage/' . $sites->img) }}" alt="Image" class="product-img">
                            @else
                            <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>{{ $sites->visit_date ?? 'N/A'}}</td>
                        <td>{{ $sites->lat ?? 'N/A'}}</td>
                        <td>{{ $sites->long ?? 'N/A'}}</td>
                        <td>{{ $sites->state->state_name ?? 'N/A'}}</td>
                        <td>{{ $sites->district->district_name ?? 'N/A'}}</td>
                        <td>{{ $sites->pincode->pincode ?? 'N/A'}}</td>
                        <td>{{ $sites->area ?? 'N/A'}}</td>
                        <td>{{ $sites->door_no ?? 'N/A'}}</td>
                        <td>{{ $sites->contact_no ?? 'N/A'}}</td>
                        <td>{{ $sites->contact_person ?? 'N/A'}}</td>
                        <td>{{ $sites->requirement_qty ?? 'N/A'}}</td>
                        <td>{{ \Carbon\Carbon::parse($sites->created_at)->format('d-m-Y') ?? 'N/A'}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<!-- Ensure jQuery is loaded first -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />

<script>
    // Ensure document is ready and jQuery is available
    (function($) {
        $(document).ready(function() {
            // Check if DataTable is defined
            if (!$.fn.DataTable) {
                console.error('DataTable is not loaded. Check CDN or script inclusion.');
                return;
            }


            // Initialize DataTable
            $('#dealersTable').DataTable({
                autoWidth: true,
                responsive: true,
                // drawCallback: function() {
                //     $('.dataTables_paginate .pagination').addClass('pagination-sm');
                // },
                dom: '<"top"<"row"<"col-md-6"l><"col-md-6"f>>><"table-wrapper"rt><"bottom"<"row"<"col-md-6"i><"col-md-6"p>>>',
                language: {
                    search: "",
                    searchPlaceholder: "Search dealers...",
                    lengthMenu: "Show _MENU_ entries",
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    }
                },
                columnDefs: [{
                        targets: 6, // Created At column (index 9)
                        type: 'date-dd-mm-yyyy'
                    },
                    {
                        targets: 7, // Actions column (index 10)
                        orderable: false,
                        searchable: false
                    }
                ],
                initComplete: function() {
                    // Style the search input
                    $('.dataTables_filter input').addClass('form-control form-control-sm');
                    $('.dataTables_filter label').contents().filter(function() {
                        return this.nodeType === 3;
                    }).remove();

                    // Style the length menu
                    $('.dataTables_length select').addClass('form-select form-select-sm');

                    // Add CSS to fix pagination position
                    $('<style>')
                        .text(`
                        .dataTables_wrapper {
                            display: flex;
                            flex-direction: column;
                            width: 100%;
                        }
                        .table-wrapper {
                            overflow-x: auto;
                            flex: 1;
                        }
                        .bottom {
                            width: 100%;
                            flex-shrink: 0;
                        }
                    `)
                        .appendTo('head');
                }
            });
        });
    })(jQuery);
</script>
@endpush