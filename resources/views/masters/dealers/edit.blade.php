@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
<h5 class="py-3 mb-4"><span class="text-muted fw-light">Masters/</span> Update Dealer</h5>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Dealer Profile</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('masters.dealers.update', $dealer->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your Name" value="{{ old('name',$dealer->name) }}">
                            @error('name') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mobile Number</label>
                            <input type="text" name="mobile" class="form-control" placeholder="Enter 10-digit mobile number" value="{{ old('mobile',$dealer->mobile) }}">
                            @error('mobile') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Enter your Address" value="{{ old('address',$dealer->address) }}">
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
                            <select name="state" id="state-select" class="form-control">
                                <option value="">Select State</option>
                                @foreach($states as $state)
                                <option value="{{ $state->id }}" {{ old('state_id',$dealer->state) == $state->id ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                @endforeach
                            </select>
                            @error('state') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">District</label>
                            <select name="district" id="district-select" class="form-control">
                                <option value="">Select District</option>
                                @foreach($districts as $district)
                                <option value="{{ $district->id }}" {{ old('district', $dealer->district) == $district->id ? 'selected' : '' }}>
                                    {{ $district->district_name }}
                                </option>
                                @endforeach
                            </select>

                            @error('district') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Area Name</label>
                            <input type="text" name="area" class="form-control" placeholder="Enter your Area" value="{{ old('area',$dealer->area) }}">
                            @error('area') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Pin Code</label>
                            <input type="text" name="pincode" class="form-control" placeholder="Enter 6-digit PIN" value="{{ old('pincode',$dealer->pincode) }}">
                            @error('pincode') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">GST No</label>
                            <input type="text" name="gst_no" class="form-control" placeholder="Enter your GST Number (Optional)" value="{{ old('gst_no',$dealer->gst_no) }}">
                            @error('gst_no') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-12 d-flex justify-content-end gap-2">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Dealer</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
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