@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="py-3 mb-0"><span class="text-muted fw-light">Masters /</span>Update Promotors List</h5>
</div>

<!-- Basic Layout -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Update Promotor Details</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif



                <div id="formOne" class="form-toggle-section">
                    <form method="POST" action="{{ route('masters.promotors.update',$promotor->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your Name" value="{{ old('name',$promotor->name) }}">
                                @error('name') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" name="mobile" class="form-control" placeholder="Enter 10-digit mobile number" value="{{ old('mobile',$promotor->mobile) }}">
                                @error('mobile') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Promotor Type</label>
                                <select name="promotor_type_id" id="promotor-select" class="form-control">
                                    <option value="">Select Promotor Type</option>
                                    @foreach($promotor_types as $promotor_type)
                                    <option value="{{ $promotor_type->id }}" {{ old('promotor_type_id',$promotor->promotor_type_id) == $promotor_type->id ? 'selected' : '' }}>{{ $promotor_type->promotor_type }}</option>
                                    @endforeach
                                </select>
                                @error('promotor_type') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Dealer</label>
                                <select name="dealer_id[]" id="dealer-select" class="form-control" multiple="multiple">
                                    <option value="">Select Dealer</option>
                                    @foreach($dealers as $dealer)
                                    <option value="{{ $dealer->id }}" @if(in_array($dealer->id, old('dealer_id', $selectedDealerIds ?? [])))
                                        selected
                                        @endif >{{ $dealer->name }}</option>
                                    @endforeach
                                </select>
                                @error('dealer') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                        </div>



                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">WhatsApp Number</label>
                                <input type="text" name="whatsapp_no" class="form-control" placeholder="Enter 10-digit number" value="{{ old('whatsapp_no',$promotor->whatsapp_no) }}">
                                @error('whatsapp_no') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Aadhar Number</label>
                                <input type="text" name="aadhar_no" class="form-control" placeholder="Aadhar Number" value="{{ old('aadhaasr_no',$promotor->aadhaar_no) }}">
                                @error('aadhar_no') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Door Number</label>
                                <input type="text" name="door_no" class="form-control" placeholder="Door Number" value="{{ old('door_no',$promotor->door_no) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">State</label>
                                <select name="state_id" id="state-select" class="form-control">
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                    <option value="{{ $state->id }}" {{ old('state_id',$promotor->state_id) == $state->id ? 'selected' : '' }}>{{ $state->state_name }}</option>
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
                                <input type="text" name="area_name" class="form-control" placeholder="Enter your Area" value="{{ old('area_name',$promotor->area_name) }}">
                                @error('area_name') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Pin Code</label>
                                <input type="text" name="pincode" class="form-control" placeholder="Enter 6-digit PIN" value="{{ old('pincode',$promotor->pincode) }}">
                                @error('pincode') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control" value="{{ old('dob',$promotor->dob) }}">
                                @error('dob') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>

                        </div>

                        <div class="row mb-3 align-items-center">
                            <div class="col-md-6">
                                <label class="form-label">Product Image</label>
                                <input type="file" name="img_path" class="form-control" onchange="previewImage(event)">
                                <small class="text-muted d-block fw-bold">
                                    <span class="text-danger">*</span> Image size must not exceed 2MB.
                                </small>
                                @error('img_path')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror

                                <!-- Image preview shown just below in a smaller container -->
                                <div class="mt-2">
                                    <div class="card" id="imageCard" style="display: {{ $promotor->img_path ? 'block' : 'none' }}">
                                        <img id="imagePreview"
                                            src="{{ $promotor->img_path ? asset('storage/' . $promotor->img_path) : '' }}"
                                            alt="Promotor Image"
                                            class="card-img-top"
                                            style="max-height: 200px; object-fit: contain;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-12 d-flex justify-content-end gap-2">
                                <a href="{{ route('masters.promotors.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-sm">Update Promotor</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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