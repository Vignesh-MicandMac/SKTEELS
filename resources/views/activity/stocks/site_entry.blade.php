@extends('layouts/contentNavbarLayout')

@section('title', 'Dealers List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="py-3 mb-0"><span class="text-muted fw-light">Masters /</span> Site Entry List</h5>
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
                        <th>Executive Name</th>
                        <th>Dealer Name</th>
                        <th>Promotor Type</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Image</th>
                        <th>Visit Date</th>
                        <th>State</th>
                        <th>District</th>
                        <th>Pincode</th>
                        <th>Area</th>
                        <th>Door No</th>
                        <th>Contact No</th>
                        <th>Contact Person</th>
                        <th>Requirement Quantity</th>
                        <th>Created At</th>
                        <!-- <th>Actions</th> -->
                    </tr>
                </thead>
                <tbody>

                    @foreach($site_entries as $key => $site_entry)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $site_entry->site_name ?? 'N/A'}}</td>
                        <td>{{ $site_entry->executive->name ?? 'N/A'}}</td>
                        <td>{{ $site_entry->dealer->name ?? 'N/A'}}</td>
                        <td>{{ $site_entry->promotorType->promotor_type ?? 'N/A'}}</td>
                        <td>{{ $site_entry->lat ?? 'N/A'}}</td>
                        <td>{{ $site_entry->long ?? 'N/A'}}</td>
                        <td>
                            @if($site_entry->img)
                            <img src="{{ asset('storage/' . $site_entry->img) }}" alt="Image" class="product-img">
                            @else
                            <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>{{ $site_entry->visit_date ?? 'N/A' }}</td>
                        <td>{{ $site_entry->state->state_name ?? 'N/A'}}</td>
                        <td>{{ $site_entry->district->district_name ?? 'N/A'}}</td>
                        <td>{{ $site_entry->pincode->pincode ?? 'N/A'}}</td>
                        <td>{{ $site_entry->area ?? 'N/A'}}</td>
                        <td>{{ $site_entry->door_no ?? 'N/A'}}</td>
                        <td>{{ $site_entry->contact_no ?? 'N/A'}}</td>
                        <td>{{ $site_entry->contact_person ?? 'N/A'}}</td>
                        <td>{{ $site_entry->requirement_qty ?? 'N/A'}}</td>
                        <td>{{ $site_entry->created_at ?? 'N/A'}}</td>
                        <!-- <td>
                            <div class="d-flex gap-2"> -->

                        {{-- @if($site_entry->approved_status == 0 || $site_entry->approved_status == 2) --}}
                        <!-- <button
                                    type="button"
                                    class="btn btn-success btn-sm py-0 px-2"
                                    onclick="updateStatus({{ $site_entry->id }}, 1)">
                                    Approve
                                </button> -->
                        {{-- @endif --}}

                        {{-- @if($site_entry->approved_status == 0 || $site_entry->approved_status == 1) --}}
                        <!-- <button
                                    type="button"
                                    class="btn btn-danger btn-sm py-0 px-2"
                                    onclick="updateStatus({{ $site_entry->id }}, 2)">
                                    UnApprove
                                </button> -->
                        {{-- @endif --}}
                        <!-- </div>
                        </td> -->

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



    function updateStatus(id, status) {
        console.log('status', status);
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to change the status.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: status == 1 ? '#28a745' : '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: status == 1 ? 'Approve' : 'UnApprove'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/activity/stocks/sale-entry-approval-or-unapproval/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        approved_status: status
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.success || 'Status updated successfully!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        setTimeout(() => location.reload(), 1600);
                    },
                    error: function(xhr) {
                        let errorMessage = "Something went wrong.";

                        // Check if backend sent JSON with "error"
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage,
                        });
                    }
                });
            }
        });
    }
</script>
<style>
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 0.375rem 0.75rem;
        margin-left: 0.5rem;
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 0.375rem 2rem 0.375rem 0.75rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.1rem 0.15rem;
        border-radius: 4px;
        border: 1px solid #dee2e6;
        /* margin-left: 0.25rem; */
        color: #696cff !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #696cff !important;
        border-color: #696cff !important;
        color: white !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #f5f5f5 !important;
        border-color: #dee2e6 !important;
        color: #696cff !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        color: #6c757d !important;
        background: transparent !important;
    }

    .btn-icon {
        padding: 0.375rem;
        line-height: 1;
    }

    #dealersTable thead th {
        vertical-align: middle;
    }

    .d-flex.gap-2 {
        gap: 0.5rem;
    }
</style>
@endpush