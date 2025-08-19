@extends('layouts/contentNavbarLayout')

@section('title', 'Dealers List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="py-3 mb-0"><span class="text-muted fw-light">Masters /</span> Products List</h5>
    @if(hasPermission(['add_product_upload']))
    <a href="{{ route('masters.products.create') }}" class="btn btn-primary btn-sm">
        <i class="mdi mdi-plus me-1"></i> Add Product
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
                        <th>Product Name</th>
                        <th>Product Code</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Points</th>
                        <th>Availability</th>
                        @if(hasPermission(['edit_product_upload','delete_product_upload']))
                        <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->product_code }}</td>
                        <td>{{ $product->description ?? 'N/A' }}</td>
                        <td>
                            @if($product->img_path)
                            <img src="{{ asset('storage/' . $product->img_path) }}" alt="Product Image" class="product-img">
                            @else
                            <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>{{ $product->points }}</td>
                        <td>
                            @if($product->availability == '0')
                            <span class="badge bg-danger">Unavailable</span>
                            @else($product->availability == '1')
                            <span class="badge bg-success">Available</span>
                            @endif
                        </td>

                        @if(hasPermission(['edit_product_upload','delete_product_upload']))
                        <td>
                            <div class="d-flex gap-2">
                                @if(hasPermission(['edit_product_upload']))
                                <a href="{{ route('masters.products.edit', $product->id) }}" class="btn btn-sm btn-icon btn-outline-primary">
                                    <i class="mdi mdi-pencil"></i>
                                </a>
                                @endif

                                @if(hasPermission(['delete_product_upload']))
                                <form id="delete-form-{{ $product->id }}" action="{{ route('masters.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $product->id }})" class="btn btn-sm btn-icon btn-outline-danger">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No products available.</td>
                    </tr>
                    @endforelse
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
                //         targets: 6, // Created At column (index 9)
                //         type: 'date-dd-mm-yyyy'
                //     },
                //     {
                //         targets: 7, // Actions column (index 10)
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
            title: 'Delete this Product?',
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