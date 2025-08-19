@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
<h5 class="py-3 mb-4"><span class="text-muted fw-light">Masters/</span> Executive Mapping</h5>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Executive Mapping</h5>
            </div>
            <div class="card-body">
                {{-- @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}
            </div>
            @endif --}}

            <form method="POST" action="{{ route('masters.executive.mapping.store') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Executive</label>
                        <select name="executive_id" class="form-control">
                            <option value="">Select Executive</option>
                            @foreach($executives as $executive)
                            <option value="{{ $executive->id }}">{{ $executive->name }}</option>
                            @endforeach
                        </select>

                        @error('executive_id') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="dealer_ids" class="form-label"> Dealers</label>
                        <select name="dealer_ids[]" id="dealer-select" class="form-select select2" multiple="multiple">
                            @foreach($dealers as $dealer)
                            <option value="{{ $dealer->id }}">{{ $dealer->name }}</option>
                            @endforeach
                        </select>
                        @error('dealer_ids') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>


                </div>

                <div class="row justify-content-end">
                    <div class="col-sm-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('masters.executives.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dealersTable">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Executive Name</th>
                        <th>Dealer Name</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($executive_mappings as $executive)
                    <tr>
                        <td>{{ $executive->id }}</td>
                        <td>{{ $executive->name ?? 'N/A'}}</td>
                        <!-- <td>
                            @foreach($executive->dealerMappings as $mapping)
                            <form id="delete-form-{{ $mapping->id }}" action="{{ route('masters.executive.mapping.delete', $mapping->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <span class="bg">
                                    {{ $mapping->dealer->name ?? 'N/A' }}
                                    <button type="submit" class="btn btn-sm btn-warning btn-close p-0 ms-1" aria-label="Remove" onclick="confirmDelete({{ $mapping->id }})"></button>
                                </span>
                            </form>
                            @endforeach
                        </td> -->

                        <!-- <td style="max-height: 120px; overflow-y: auto; display: block; min-width: 250px;">
                            @foreach($executive->dealerMappings as $mapping)
                            <form id="delete-form-{{ $mapping->id }}"
                                action="{{ route('masters.executive.mapping.delete', $mapping->id) }}"
                                method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')

                                <span class="badge bg-primary text-white d-inline-flex align-items-center mb-1 me-1" style="padding: 6px 10px; border-radius: 20px;">
                                    {{ $mapping->dealer->name ?? 'N/A' }}
                                    <button type="submit"
                                        class="btn btn-sm ms-2 p-0"
                                        style="color: white; background-color: #dc3545; border: none; font-size: 14px; width: 18px; height: 18px; border-radius: 50%; line-height: 14px;"
                                        aria-label="Remove">
                                        &times;
                                    </button>
                                </span>
                            </form>
                            @endforeach
                        </td> -->


                        <td>
                            <div style="max-height: 60px; overflow-y: auto;">
                                @foreach($executive->dealerMappings as $mapping)
                                <form id="delete-form-{{ $mapping->id }}"
                                    action="{{ route('masters.executive.mapping.delete', $mapping->id) }}"
                                    method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    {{ $mapping->dealer->name ?? 'N/A' }}
                                    <button type="submit"
                                        class="close-dealer"
                                        style="border: none; background: none; color: red; cursor: pointer;"
                                        aria-label="Close">×
                                    </button>
                                    <br>
                                </form>
                                @endforeach
                            </div>
                        </td>


                        <td>{{ \Carbon\Carbon::parse($executive->created_at)->format('d-m-Y') ?? 'N/A'}}</td>
                        <!-- <td>
                            <div class="d-flex gap-2"> -->
                        <!-- <a href="{{ route('masters.executive.mapping.edit', $executive->id) }}" class="btn btn-sm btn-icon btn-outline-primary">
                                    <i class="mdi mdi-pencil"></i>
                                </a> -->
                        <!-- Replace this anchor tag -->

                        <!-- <form id="delete-form-{{ $executive->id }}" action="{{ route('masters.executive.mapping.destroy', $executive->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $executive->id }})" class="btn btn-sm btn-icon btn-outline-danger">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </form> -->

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Ensure jQuery is loaded first -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {

        $(document).ready(function() {
            $('#dealer-select').select2({
                placeholder: "Select Dealers",
                allowClear: true,
                closeOnSelect: false,
                width: '100%'
            });
        });
    });


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
                        targets: 2, // Created At column (index 9)
                        type: 'date-dd-mm-yyyy'
                    },
                    {
                        targets: 3, // Actions column (index 10)
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

    // function confirmDelete(id) {
    //     Swal.fire({
    //         title: 'Delete this Executive?',
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#d33',
    //         cancelButtonColor: '#3085d6',
    //         confirmButtonText: 'Yes',
    //         cancelButtonText: 'No',
    //         customClass: {
    //             popup: 'swal2-tiny-popup',
    //             title: 'swal2-tiny-title',
    //             htmlContainer: 'swal2-tiny-text',
    //             confirmButton: 'swal2-tiny-button',
    //             cancelButton: 'swal2-tiny-button'
    //         }
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             document.getElementById(`delete-form-${id}`).submit();
    //         }
    //     });
    // }
</script>
@endpush
@push('styles')
<style>
    .select2-container {
        width: 100% !important;
    }

    .select2-selection__choice {
        background-color: #e4e4e4;
        border: 1px solid #aaa;
        border-radius: 4px;
        padding: 2px 5px;
        margin: 2px;
    }

    .select2-selection__choice__remove {
        cursor: pointer;
        margin-right: 5px;
    }

    .select2-selection__clear {
        cursor: pointer;
        font-size: 16px;
        margin-right: 10px;
    }

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