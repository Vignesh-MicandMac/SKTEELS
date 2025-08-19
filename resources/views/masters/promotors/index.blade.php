@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="py-3 mb-0"><span class="text-muted fw-light">Masters /</span> Promotors List</h5>

    <!-- Toggle Switch Replacing Add Dealer Button -->
    <div class="square-toggle-container">
        <input type="checkbox" id="formToggle" class="square-toggle-checkbox">
        <label for="formToggle" class="square-toggle-label">
            <span class="toggle-text toggle-on">New Promotor</span>
            <span class="toggle-text toggle-off">Exsisting Promotor</span>
            <div class="toggle-handle"></div>
        </label>
    </div>

</div>


@if(hasPermission(['add_promotors']))
<!-- Basic Layout -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Promotor Details</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif



                <div id="formOne" class="form-toggle-section">
                    <form method="POST" action="{{ route('masters.promotors.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your Name" value="{{ old('name') }}">
                                @error('name') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" name="mobile" class="form-control" placeholder="Enter 10-digit mobile number" value="{{ old('mobile') }}">
                                @error('mobile') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Promotor Type</label>
                                <select name="promotor_type_id" id="promotor-select" class="form-control">
                                    <option value="">Select Promotor Type</option>
                                    @foreach($promotor_types as $promotor_type)
                                    <option value="{{ $promotor_type->id }}" {{ old('promotor_type_id') == $promotor_type->id ? 'selected' : '' }}>{{ $promotor_type->promotor_type }}</option>
                                    @endforeach
                                </select>
                                @error('promotor_type') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="dealer_ids" class="form-label"> Dealers</label>
                                <select name="dealer_id[]" id="dealer-select" class="form-select select2" multiple="multiple">
                                    <option value="">Select Dealers</option>
                                    @foreach($dealers as $dealer)
                                    <option value="{{ $dealer->id }}">{{ $dealer->name }}</option>
                                    @endforeach
                                </select>
                                @error('dealer_id') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                        </div>



                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">WhatsApp Number</label>
                                <input type="text" name="whatsapp_no" class="form-control" placeholder="Enter 10-digit number" value="{{ old('whatsapp_no') }}">
                                @error('whatsapp_no') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Aadhar Number</label>
                                <input type="text" name="aadhar_no" class="form-control" placeholder="Aadhar Number" value="{{ old('aadhar_no') }}">
                                @error('aadhar_no') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Door Number</label>
                                <input type="text" name="door_no" class="form-control" placeholder="Door Number" value="{{ old('door_no') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">State</label>
                                <select name="state_id" id="state-select" class="form-control">
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                    <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                    @endforeach
                                </select>
                                @error('state') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">District</label>
                                <select name="district_id" id="district-select" class="form-control">
                                    <option value="">Select District</option>
                                </select>

                                @error('district') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Area Name</label>
                                <input type="text" name="area_name" class="form-control" placeholder="Enter your Area" value="{{ old('area_name') }}">
                                @error('area_name') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Pin Code</label>
                                <input type="text" name="pincode" class="form-control" placeholder="Enter 6-digit PIN" value="{{ old('pincode') }}">
                                @error('pincode') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                                @error('dob') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Profile Image</label>
                                <input type="file" name="img_path" class="form-control" onchange="previewImage(event)" accept="image/*">
                                <small class="text-muted d-block fw-bold"><span class="text-danger">*</span>Image size must not exceed 2MB.</small>
                                @error('img_path') <small class="text-danger">{{ $message }}</small> @enderror
                                <!-- Image preview shown just below in a smaller container -->
                                <div class="mt-2">
                                    <div class="card" id="imageCard">
                                        <img id="imagePreview" src="#" alt="Product Image" class="card-img-top">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-12 d-flex justify-content-end gap-2">
                                <a href="{{ route('masters.promotors.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-sm">Add Promotor</button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif




                <!-- Form 2 (Assingning Dealer to promotors Form) -->
                <div id="formTwo" class="form-toggle-section d-none">
                    <form method="POST" action="{{ route('masters.promotors.mapping_dealers') }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Enrollment Number</label>
                                <input type="text" name="enroll_no" class="form-control" placeholder="Enter Enrollment Number" value="{{ old('enroll_no') }}">
                                @error('enroll_no') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="dealer_ids" class="form-label"> Dealers</label>
                                <select name="dealer_id[]" id="multiple-select" class="form-select select2" multiple="multiple">
                                    <option value="">Select Dealers</option>
                                    @foreach($dealers as $dealer)
                                    <option value="{{ $dealer->id }}">{{ $dealer->name }}</option>
                                    @endforeach
                                </select>
                                @error('dealer_id') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
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
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dealersTable">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Enroll No</th>
                        <th>Dealer Name</th>
                        <th>Promotor Name</th>
                        <th>Promotor Type</th>
                        <th>Profile Image</th>
                        <th>Mobile No</th>
                        <th>WhatsApp no</th>
                        <th>State</th>
                        <th>District</th>
                        <th>Area Name</th>
                        <th>Date Of Birth</th>
                        <th>Approval Status</th>
                        <th>Created At</th>
                        @if(hasPermission(['edit_promotors','delete_promotors']))
                        <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>

                    @foreach($promotors as $promotor)
                    <tr>
                        <td>{{ $promotor->id }}</td>
                        <td>{{ $promotor->enroll_no ?? 'N/A'}}</td>
                        <td>
                            @if($promotor->mappedDealers->count())
                            {{ $promotor->mappedDealers->pluck('name')->join(', ') }}
                            @else
                            <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>{{ $promotor->name ?? 'N/A'}}</td>
                        <td>{{ $promotor->promotor_type->promotor_type ?? 'N/A'}}</td>
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
                            @elseif($promotor->approval_status == 0)
                            <span class="badge bg-danger">UnApproved</span>
                            @else
                            <span class="badge bg-secondary">N/A</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($promotor->created_at)->format('d-m-Y') ?? 'N/A'}}</td>

                        @if(hasPermission(['edit_promotors','delete_promotors']))
                        <td>
                            <div class="d-flex gap-2">
                                @if(hasPermission(['edit_promotors']))
                                <a href="{{ route('masters.promotors.edit', $promotor->id) }}" class="btn btn-sm btn-icon btn-outline-primary">
                                    <i class="mdi mdi-pencil"></i>
                                </a>
                                @endif

                                @if(hasPermission(['delete_promotors']))
                                <form id="delete-form-{{ $promotor->id }}" action="{{ route('masters.promotors.destroy', $promotor->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $promotor->id }})" class="btn btn-sm btn-icon btn-outline-danger">
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


    $(document).ready(function() {
        $('#multiple-select').select2({
            placeholder: "Select Dealers",
            allowClear: true,
            closeOnSelect: false,
            width: '100%'
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
                // columnDefs: [{
                //         targets: 13, // Created At column (index 9)
                //         type: 'date-dd-mm-yyyy'
                //     },
                //     {
                //         targets: 14, // Actions column (index 10)
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
            title: 'Delete this Promotor?',
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

    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('formToggle');
        const formOne = document.getElementById('formOne');
        const formTwo = document.getElementById('formTwo');

        toggle.addEventListener('change', function() {
            if (toggle.checked) {
                formOne.classList.add('d-none');
                formTwo.classList.remove('d-none');
            } else {
                formTwo.classList.add('d-none');
                formOne.classList.remove('d-none');
            }
        });
    });

    // District ------------------------
    $(document).ready(function() {

        $('#state-select').on('change', function() {
            let stateId = $(this).val();
            if (stateId) {
                $.ajax({
                    url: '/masters/dealers/get-districts/' + stateId,
                    type: 'GET',
                    success: function(data) {
                        $('#district-select').empty().append('<option value="">Select District</option>');
                        $.each(data, function(key, value) {
                            $('#district-select').append('<option value="' + value.id + '">' + value.district_name + '</option>');
                        });
                    }
                });
            } else {
                $('#district-select').empty().append('<option value="">Select District</option>');
            }
        });
    });

    // Image Preview
    function previewImage(event) {
        const imageCard = document.getElementById('imageCard');
        const imagePreview = document.getElementById('imagePreview');
        const file = event.target.files[0];

        if (file) {
            imagePreview.src = URL.createObjectURL(file);
            imageCard.style.display = 'block';
        } else {
            imagePreview.src = '';
            imageCard.style.display = 'none';
        }
    }
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