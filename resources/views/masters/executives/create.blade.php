@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
<h5 class="py-3 mb-4"><span class="text-muted fw-light">Masters/</span> Add New Executive</h5>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Executive Profile</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('masters.executives.store') }}">
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
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Enter your Address" value="{{ old('address') }}">
                            @error('address') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            @error('password') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Re-Type Password">
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


                        <!-- <div class="col-md-6">
                            <label for="dealer_ids" class="form-label">Select Dealers</label>
                            <select name="dealer_ids[]" id="dealer-select" class="form-select select2" multiple="multiple">
                                @foreach($dealers as $dealer)
                                <option value="{{ $dealer->id }}">{{ $dealer->name }}</option>
                                @endforeach
                            </select>
                        </div> -->


                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-12 d-flex justify-content-end gap-2">
                            <a href="{{ route('masters.executives.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-sm">Add Executive</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {

        // $(document).ready(function() {
        //     $('#dealer-select').select2({
        //         placeholder: "Select Dealers",
        //         allowClear: true,
        //         closeOnSelect: false,
        //         width: '100%'
        //     });
        // });

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
<!-- @push('styles')
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
</style>
@endpush -->