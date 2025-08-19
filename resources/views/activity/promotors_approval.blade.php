@extends('layouts/contentNavbarLayout')

@section('title', 'Dealers List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="py-3 mb-0"><span class="text-muted fw-light">Masters /</span>Promotor Approval List</h5>
</div>


<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dealersTable">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Enroll No</th>
                        <th>Promotor Name</th>
                        <th>Profile Image</th>
                        <th>Mobile No</th>
                        <th>WhatsApp no</th>
                        <th>State</th>
                        <th>District</th>
                        <th>Area Name</th>
                        <th>Date Of Birth</th>
                        <th>Approval Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($promotors as $key => $promotor)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $promotor->enroll_no ?? 'N/A'}}</td>
                        <td>{{ $promotor->name ?? 'N/A'}}</td>
                        <td>
                            @if($promotor->img_path)
                            <img src="{{ asset('storage/' . $promotor->img_path) }}" alt="Promotor Image" class="product-img">
                            @else
                            <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>{{ $promotor->mobile ?? 'N/A'}}</td>
                        <td>{{ $promotor->whatsapp_no ?? 'N/A'}}</td>
                        <td>{{ $promotor->state->state_name ?? 'N/A'}}</td>
                        <td>{{ $promotor->district->district_name ?? 'N/A'}}</td>
                        <td>{{ $promotor->area_name ?? 'N/A'}}</td>
                        <td>{{ $promotor->dob ?? 'N/A'}}</td>
                        <td>
                            @if($promotor->approval_status == 1)
                            <span class="badge bg-success">Approved</span>
                            @elseif($promotor->approval_status == 2)
                            <span class="badge bg-danger">UnApproved</span>
                            @else
                            <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">

                                @if($promotor->approval_status == 0 || $promotor->approval_status == 2)
                                <button
                                    type="button"
                                    class="btn btn-success btn-sm py-0 px-2"
                                    onclick="updateStatus({{ $promotor->id }}, 1)">
                                    Approve
                                </button>
                                @endif

                                @if($promotor->approval_status == 0 || $promotor->approval_status == 1)
                                <button
                                    type="button"
                                    class="btn btn-danger btn-sm py-0 px-2"
                                    onclick="updateStatus({{ $promotor->id }}, 2)">
                                    UnApprove
                                </button>
                                @endif
                            </div>
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
                dom: '<"top"<"row"<"col-md-6"l><"col-md-6"f>>>rt<"bottom"<"row"<"col-md-6"i><"col-md-6"p>>>',
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
                        targets: 10, // Created At column (index 9)
                        type: 'date-dd-mm-yyyy'
                    },
                    {
                        targets: 11, // Actions column (index 10)
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
                }
            });
        });
    })(jQuery);

    function updateStatus(id, status) {
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
                    url: '/activity/stocks/promotors-approval-update/' + id,
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
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong.',
                        });
                    }
                });
            }
        });
    }

    // function updateStatus(id, status) {
    //     if (!confirm('Are you sure?')) return;

    //     $.ajax({
    //         url: '/activity/stocks/sale-entry-update/' + id,
    //         type: 'POST',
    //         data: {
    //             _token: '{{ csrf_token() }}',
    //             approved_status: status
    //         },
    //         success: function(response) {
    //             alert(response.message);
    //             location.reload();
    //         },
    //         error: function(xhr) {
    //             alert('Something went wrong.');
    //         }
    //     });
    // }
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