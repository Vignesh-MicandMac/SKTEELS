@extends('layouts/contentNavbarLayout')

@section('title', 'Dealers List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="py-3 mb-0"><span class="text-muted fw-light">Masters /</span> Dealers List</h5>
    @if(hasPermission(['add_dealers']))
    <a href="{{ route('masters.dealers.create') }}" class="btn btn-primary btn-sm">
        <i class="mdi mdi-plus me-1"></i> Add Dealer
    </a>
    @endif
</div>

<!-- Dealers Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dealersTable">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <!-- <th>Address</th> -->
                        <th>State</th>
                        <th>District</th>
                        <th>Area</th>
                        <th>Pincode</th>
                        <th>GST No</th>
                        <!-- <th>Created At</th> -->
                        @if(hasPermission(['delete_dealers','edit_dealers']))
                        <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>

                    @foreach($dealers as $dealer)
                    <tr>
                        <td>{{ $dealer->id }}</td>
                        <td>{{ $dealer->name ?? 'N/A'}}</td>
                        <td>{{ $dealer->mobile ?? 'N/A'}}</td>
                        <!-- <td>{{ $dealer->address ?? 'N/A'}}</td> -->
                        <td>{{ $dealer->states->state_name ?? 'N/A' }}</td>
                        <td>{{ $dealer->districts->district_name ?? 'N/A'}}</td>
                        <td>{{ $dealer->area ?? 'N/A'}}</td>
                        <td>{{ $dealer->pincode ?? 'N/A'}}</td>
                        <td>{{ $dealer->gst_no ?? 'N/A'}}</td>
                        <!-- <td>{{ \Carbon\Carbon::parse($dealer->created_at)->format('d-m-Y') ?? 'N/A'}}</td> -->
                        @if(hasPermission(['delete_dealers','edit_dealers']))
                        <td>
                            <div class="d-flex gap-2">
                                @if(hasPermission(['edit_dealers']))
                                <a href="{{ route('masters.dealers.edit', $dealer->id) }}" class="btn btn-sm btn-icon btn-outline-primary">
                                    <i class="mdi mdi-pencil"></i>
                                </a>
                                @endif

                                @if(hasPermission(['delete_dealers']))
                                <form id="delete-form-{{ $dealer->id }}" action="{{ route('masters.dealers.destroy', $dealer->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $dealer->id }})" class="btn btn-sm btn-icon btn-outline-danger">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                        @endif
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
                // columnDefs: [{
                //         targets: 7, // Created At column (index 9)
                //         type: 'date-dd-mm-yyyy'
                //     },
                //     {
                //         targets: 8, // Actions column (index 10)
                //         orderable: false,
                //         searchable: false
                //     }
                // ],
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

    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete this Dealer?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            customClass: {
                popup: 'swal2-tiny-popup',
                title: 'swal2-tiny-title',
                htmlContainer: 'swal2-tiny-text',
                confirmButton: 'swal2-tiny-button',
                cancelButton: 'swal2-tiny-button'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
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