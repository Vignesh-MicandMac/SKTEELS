@extends('layouts/contentNavbarLayout')

@section('title', 'Dealers List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="py-3 mb-0"><span class="text-muted fw-light">Masters /</span> Influencer List</h5>
</div>


<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Search Influencers</h5>
            </div>
            <div class="card-body">
                {{-- @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}
            </div>
            @endif --}}

            <form method="GET" action="{{ route('reports.influencer_list') }}">
                @csrf

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

                    <div class="col-md-4">
                        <label for="approval_status" class="form-label"> Approved Status</label>
                        <select name="approval_status" id="promotor-select" class="form-select select2">
                            <option value="">Select Status</option>
                            <option value="0" {{ request('approval_status') === '0' ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ request('approval_status') === '1' ? 'selected' : '' }}>Approved</option>
                            <option value="2" {{ request('approval_status') === '2' ? 'selected' : '' }}>UnApproved</option>
                        </select>
                        @error('approval_status') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row justify-content-end">
                    <div class="col-sm-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('reports.influencer_list') }}" class="btn btn-light btn-sm">Clear</a>
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
                        <th>Enroll No</th>
                        <th>Influencer Name</th>
                        <th>Influencer Type</th>
                        <th>Mapped Dealer</th>
                        <th> Image</th>
                        <th>Mobile No</th>
                        <th>WhatsApp No</th>
                        <th>Address</th>
                        <th>State</th>
                        <th>District</th>
                        <th>Area</th>
                        <th>Date Of Birth</th>
                        <th>Points</th>
                        <th>Created At</th>
                        <th>Approved Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promotors as $index => $promotor)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $promotor->enroll_no ?? 'N/A' }}</td>
                        <td>{{ $promotor->name ?? 'N/A' }}</td>
                        <td>{{ $promotor->promotor_type->promotor_type ?? 'N/A' }}</td>
                        <td>
                            @if($promotor->mappedDealers->count())
                            {{ $promotor->mappedDealers->pluck('name')->join(', ') }}
                            @else
                            <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if($promotor->img_path)
                            <img src="{{ asset('storage/' . $promotor->img_path) }}" alt="promotor Image" class="product-img">
                            @else
                            <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>{{ $promotor->mobile ?? 'N/A'}}</td>
                        <td>{{ $promotor->whatsapp_no ?? 'N/A'}}</td>
                        <td>{{ $promotor->address ?? 'N/A'}}</td>
                        <td>{{ $promotor->state->state_name ?? 'N/A'}}</td>
                        <td>{{ $promotor->district->district_name ?? 'N/A'}}</td>
                        <td>{{ $promotor->area_name ?? 'N/A'}}</td>
                        <td>{{ $promotor->dob ?? 'N/A'}}</td>
                        <td>{{ $promotor->points ?? 'N/A'}}</td>
                        <td>{{ \Carbon\Carbon::parse($promotor->created_at)->format('d-m-Y') ?? 'N/A'}}</td>
                        <td>
                            @if($promotor->approval_status == 1)
                            <span class="badge bg-success">Approved</span>
                            @elseif($promotor->approval_status == 2)
                            <span class="badge bg-danger">UnApproved</span>
                            @else
                            <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
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