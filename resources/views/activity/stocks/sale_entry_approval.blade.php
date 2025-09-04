@extends('layouts/contentNavbarLayout')

@section('title', 'Dealers List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="py-3 mb-0"><span class="text-muted fw-light">Masters /</span> Sale Entry Approval List</h5>
</div>


<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Search Stocks</h5>
            </div>
            <div class="card-body">
                {{-- @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}
            </div>
            @endif --}}

            <form method="GET" action="{{ route('activity.stocks.sale_entry') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="dealer_ids" class="form-label"> Dealers</label>
                        <select name="dealer_id" id="dealer-select" class="form-select select2">
                            <option value="">Select Dealer</option>
                            @foreach($dealers as $dealer)
                            <option value="{{ $dealer->id }}" {{ request('dealer_id') == $dealer->id ? 'selected' : '' }}>{{ $dealer->name }}</option>
                            @endforeach
                        </select>
                        @error('dealer_id') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="promotor_ids" class="form-label"> Promotors</label>
                        <select name="promotor_id" id="promotor-select" class="form-select select2">
                            <option value="">Select Promotors</option>
                            @foreach($promotors as $promotor)
                            <option value="{{ $promotor->id }}" {{ request('promotor_id') == $promotor->id ? 'selected' : '' }}>{{ $promotor->name }}</option>
                            @endforeach
                        </select>
                        @error('promotor_id') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>


                </div>


                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        @error('start_date') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        @error('end_date') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="approved_status" class="form-label"> Promotors</label>
                        <select name="approved_status" id="promotor-select" class="form-select select2">
                            <option value="">Select Status</option>
                            <option value="0" {{ request('approved_status') === '0' ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ request('approved_status') === '1' ? 'selected' : '' }}>Approved</option>
                            <option value="2" {{ request('approved_status') === '2' ? 'selected' : '' }}>UnApproved</option>
                        </select>
                        @error('approved_status') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row justify-content-end">
                    <div class="col-sm-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('activity.stocks.sale_entry') }}" class="btn btn-light btn-sm">Clear</a>
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
                        <th>Dealer Name</th>
                        <th>Executive Name</th>
                        <th>Promotor Name</th>
                        <th>Quantity</th>
                        <th>Obtained Points</th>
                        <th>Site Details</th>
                        <th>SO Approved Status</th>
                        <th>SO Declined Reason</th>
                        <th>Admin Approved Status</th>
                        <th>Admin Declined Reason</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($promotor_sale_entries as $key => $sale_entry)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $sale_entry->dealer->name ?? 'N/A'}}</td>
                        <td>{{ $sale_entry->executive->name ?? 'N/A'}}</td>
                        <td>{{ $sale_entry->promotor->name ?? 'N/A'}}</td>
                        <td>{{ $sale_entry->quantity ?? 'N/A' }}</td>
                        <td>{{ $sale_entry->obtained_points ?? 'N/A'}}</td>
                        <!-- <td> -->
                        {{-- @if($sale_entry->approved_status == 1)
                            <span class="badge bg-success">Approved</span>
                            @elseif($sale_entry->approved_status == 2)
                            <span class="badge bg-danger">UnApproved</span>
                            @else
                            <span class="badge bg-warning">Pending</span>
                            @endif --}}
                        <!-- </td> -->



                        <td>
                            <button type="button" class="btn btn-info btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#siteModal"
                                data-sites='@json($promotor_site_details[$sale_entry->promotor_id] ?? [])'>
                                View
                            </button>
                        </td>

                        <td>
                            <div class="d-flex gap-2">

                                @if($sale_entry->so_approved_status == 0)
                                <button
                                    type="button"
                                    class="btn btn-primary btn-sm py-0 px-2"
                                    onclick="executive_approval_status({{ $sale_entry->id }}, 1)">
                                    Approve
                                </button>

                                <button
                                    type="button"
                                    class="btn btn-dark btn-sm py-0 px-2"
                                    onclick="executive_approval_status({{ $sale_entry->id }}, 2)">
                                    UnApprove
                                </button>
                                @elseif($sale_entry->so_approved_status == 1)
                                <span class="badge bg-success">Approved</span>
                                @elseif($sale_entry->so_approved_status == 2)
                                <span class="badge bg-danger">UnApproved</span>
                                @endif
                            </div>
                        </td>



                        <td>{{ $sale_entry->so_declined_reason ?? 'N/A'}}</td>

                        <td>
                            <div class="d-flex gap-2">

                                @if($sale_entry->so_approved_status == 1 && $sale_entry->approved_status == 0)
                                <button
                                    type="button"
                                    class="btn btn-primary btn-sm py-0 px-2"
                                    onclick="updateStatus({{ $sale_entry->id }}, 1)">
                                    Approve
                                </button>

                                <button
                                    type="button"
                                    class="btn btn-dark btn-sm py-0 px-2"
                                    onclick="updateStatus({{ $sale_entry->id }}, 2)">
                                    UnApprove
                                </button>
                                @elseif($sale_entry->so_approved_status == 2 || $sale_entry->approved_status == 2)
                                <span class="badge bg-danger">UnApproved</span>
                                @elseif($sale_entry->approved_status == 1)
                                <span class="badge bg-success">Approved</span>
                                @endif
                            </div>
                        </td>
                        <td>{{ $sale_entry->declined_reason ?? 'N/A'}}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="siteModal" tabindex="-1" aria-labelledby="siteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="siteModalLabel">Site Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="siteModalBody">
                <!-- JS will populate site details here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
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
                drawCallback: function() {
                    $('.dataTables_paginate .pagination').addClass('pagination-sm');
                },
                // dom: '<"top"<"row"<"col-md-6"l><"col-md-6"f>>>rt<"bottom"<"row"<"col-md-6"i><"col-md-6"p>>>',
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

    // function updateStatus(id, status) {
    //     if (status == 1) {
    //         // Approve confirmation (no reason needed)
    //         Swal.fire({
    //             title: 'Are you sure?',
    //             text: "You are about to approve this entry.",
    //             icon: 'warning',
    //             showCancelButton: true,
    //             confirmButtonColor: '#28a745',
    //             cancelButtonColor: '#6c757d',
    //             confirmButtonText: 'Approve'
    //         }).then((result) => {
    //             if (result.isConfirmed) {
    //                 sendStatusUpdate(id, status, null);
    //             }
    //         });
    //     } else if (status == 2) {
    //         // UnApprove - Ask reason
    //         Swal.fire({
    //             title: 'Reason For UnApproval',
    //             input: 'textarea',
    //             inputPlaceholder: 'Enter reason...',
    //             inputAttributes: {
    //                 style: 'min-height:40px;font-size:13px;' // smaller textarea
    //             },
    //             width: 400, // shrink popup width
    //             customClass: {
    //                 confirmButton: 'swal2-sm-button',
    //                 cancelButton: 'swal2-sm-button',
    //                 popup: 'swal2-sm-popup',
    //                 title: 'swal2-sm-title'
    //             },
    //             inputValidator: (value) => {
    //                 if (!value) {
    //                     return 'Reason required!';
    //                 }
    //             },
    //             showCancelButton: true,
    //             confirmButtonText: 'Submit',
    //             confirmButtonColor: '#dc3545',
    //             cancelButtonColor: '#6c757d',
    //         }).then((result) => {
    //             if (result.isConfirmed) {
    //                 sendStatusUpdate(id, status, result.value);
    //             }
    //         });
    //     }
    // }

    // function sendStatusUpdate(id, status, reason = null) {
    //     $.ajax({
    //         url: '/activity/stocks/sale-entry-approval-or-unapproval/' + id,
    //         type: 'POST',
    //         data: {
    //             _token: '{{ csrf_token() }}',
    //             approved_status: status,
    //             declined_reason: reason // <-- send reason if unapproved
    //         },
    //         success: function(response) {
    //             Swal.fire({
    //                 icon: 'success',
    //                 title: 'Success!',
    //                 text: response.success || 'Status updated successfully!',
    //                 timer: 1500,
    //                 showConfirmButton: false
    //             });
    //             setTimeout(() => location.reload(), 1600);
    //         },
    //         error: function(xhr) {
    //             let errorMessage = "Something went wrong.";
    //             if (xhr.responseJSON && xhr.responseJSON.error) {
    //                 errorMessage = xhr.responseJSON.error;
    //             }
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Error!',
    //                 text: errorMessage,
    //             });
    //         }
    //     });
    // }

    //Admin APPROVAL STATUS CHANGES
    function updateStatus(id, status) {
        if (status == 1) {
            // Approve confirmation (no reason needed)
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to approve this entry.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Approve',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    sendStatusUpdate(id, status, null);
                }

                cleanupAfterSwal();
            }).catch((error) => {

                cleanupAfterSwal();
            });
        } else if (status == 2) {
            // UnApprove - Ask reason
            Swal.fire({
                title: 'Reason For UnApproval',
                input: 'textarea',
                inputPlaceholder: 'Enter reason...',
                inputAttributes: {
                    style: 'min-height:40px;font-size:13px;'
                },
                width: 400,
                customClass: {
                    confirmButton: 'swal2-sm-button',
                    cancelButton: 'swal2-sm-button',
                    popup: 'swal2-sm-popup',
                    title: 'swal2-sm-title'
                },
                inputValidator: (value) => {
                    if (!value) {
                        return 'Reason required!';
                    }
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    sendStatusUpdate(id, status, result.value);
                }

                cleanupAfterSwal();
            }).catch((error) => {

                cleanupAfterSwal();
            });
        }
    }


    function cleanupAfterSwal() {

        document.body.classList.remove('swal2-shown', 'swal2-no-backdrop', 'swal2-toast-shown');
        document.documentElement.classList.remove('swal2-shown', 'swal2-no-backdrop', 'swal2-toast-shown');

        $('.swal2-container').remove();
        document.body.focus();
    }

    function sendStatusUpdate(id, status, reason = null) {
        $.ajax({
            url: '/activity/stocks/sale-entry-approval-or-unapproval/' + id,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                approved_status: status,
                declined_reason: reason
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

    //Admin APPROVAL STATUS CHANGES ENDS


    //SO OR EXECUTIVE APPROVAL STATUS CHANGES
    function executive_approval_status(id, status) {
        if (status == 1) {
            // Approve confirmation (no reason needed)
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to approve this entry.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Approve',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    send_So_StatusUpdate(id, status, null);
                }

                cleanupAfterSwal();
            }).catch((error) => {

                cleanupAfterSwal();
            });
        } else if (status == 2) {
            // UnApprove - Ask reason
            Swal.fire({
                title: 'Reason For UnApproval',
                input: 'textarea',
                inputPlaceholder: 'Enter reason...',
                inputAttributes: {
                    style: 'min-height:40px;font-size:13px;'
                },
                width: 400,
                customClass: {
                    confirmButton: 'swal2-sm-button',
                    cancelButton: 'swal2-sm-button',
                    popup: 'swal2-sm-popup',
                    title: 'swal2-sm-title'
                },
                inputValidator: (value) => {
                    if (!value) {
                        return 'Reason required!';
                    }
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    send_So_StatusUpdate(id, status, result.value);
                }

                cleanupAfterSwal();
            }).catch((error) => {

                cleanupAfterSwal();
            });
        }
    }


    function cleanupAfterSwal() {

        document.body.classList.remove('swal2-shown', 'swal2-no-backdrop', 'swal2-toast-shown');
        document.documentElement.classList.remove('swal2-shown', 'swal2-no-backdrop', 'swal2-toast-shown');

        $('.swal2-container').remove();
        document.body.focus();
    }

    function send_So_StatusUpdate(id, status, reason = null) {
        $.ajax({
            url: '/activity/stocks/so-sale-entry-approval-or-unapproval/' + id,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                approved_status: status,
                declined_reason: reason
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

    //SO OR EXECUTIVE APPROVAL STATUS CHANGES ENDS



    //SITE DETAILS
    var siteModal = document.getElementById('siteModal');

    siteModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var sites = JSON.parse(button.getAttribute('data-sites'));
        var modalBody = siteModal.querySelector('#siteModalBody');

        if (!sites.length) {
            modalBody.innerHTML = '<p>No sites available.</p>';
            return;
        }

        var content = '';

        sites.forEach(function(site, index) {
            content += `
            <h6 class="mb-2" style="font-size: 0.95rem;">Site ${index + 1}: ${site.site_name}</h6>
            <div class="container-fluid mb-2 p-2" style="font-size: 0.85rem; line-height: 1.3;">
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Dealer:</strong> ${site.dealer?.name ?? 'N/A'}</div>
                    <div class="col-md-6"><strong>Executive:</strong> ${site.executive?.name ?? 'N/A'}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Promotor Type:</strong> ${site.promotor_type?.promotor_type ?? 'N/A'}</div>
                    <div class="col-md-6"><strong>Promotor:</strong> ${site.promotor?.name ?? 'N/A'}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Contact:</strong> ${site.contact_person ?? 'N/A'} / ${site.contact_no ?? 'N/A'}</div>
                    <div class="col-md-6"><strong>Visit Date:</strong> ${site.visit_date ?? 'N/A'}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Address:</strong> ${site.area ?? 'N/A'}, ${site.door_no ?? 'N/A'}, ${site.street_name ?? 'N/A'}</div>
                    <div class="col-md-6"><strong>Building/Floor:</strong> ${site.building_stage ?? 'N/A'}, ${site.floor_stage ?? 'N/A'}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Latitude:</strong> ${site.lat ?? 'N/A'}</div>
                    <div class="col-md-6"><strong>Longitude:</strong> ${site.long ?? 'N/A'}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><strong>State / District / Pincode:</strong> ${site.state?.state_name ?? 'N/A'} / ${site.district?.district_name ?? 'N/A'} / ${site.pincode?.pincode ?? 'N/A'}</div>
                    <div class="col-md-6"><strong>Requirement Qty:</strong> ${site.requirement_qty ?? 'N/A'}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">${site.img ? `<strong>Image:</strong><br><img src="/storage/${site.img}" class="img-fluid rounded" style="max-width:150px;">` : ''}</div>
                </div>
            </div>
            <hr style="margin: 0.5rem 0;">`;
        });

        modalBody.innerHTML = content;

    });
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