@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Product')

@section('content')
<h5 class="py-3 mb-4"><span class="text-muted fw-light">Masters /</span> Edit Product</h5>

<div class="row">
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Edit Product</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('masters.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}">
                            @error('product_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Product Code</label>
                            <input type="text" name="product_code" class="form-control" value="{{ old('product_code', $product->product_code) }}">
                            @error('product_code') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Points</label>
                            <input type="text" name="points" class="form-control" value="{{ old('points', $product->points) }}">
                            <small class="text-muted d-block fw-bold"><span class="text-danger">*</span> Please enter only numeric values.</small>
                            @error('points') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <!-- <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Product Image</label>
                            <input type="file" name="img_path" class="form-control" onchange="previewImage(event)">
                            <small class="text-muted d-block fw-bold"><span class="text-danger">*</span>Image size must not exceed 2MB.</small>
                            @error('img_path') <small class="text-danger">{{ $message }}</small> @enderror
                           
                            <div class="mt-2">
                                <div class="card" id="imageCard">
                                    <img id="imagePreview" src="{{ $product->img_path ? asset('storage/' . $product->img_path) : '#' }}" alt="Product Image" class="card-img-top">
                                </div>
                            </div>
                        </div>
                    </div> -->

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
                                <div class="card" id="imageCard" style="display: {{ $product->img_path ? 'block' : 'none' }}">
                                    <img id="imagePreview"
                                        src="{{ $product->img_path ? asset('storage/' . $product->img_path) : '' }}"
                                        alt="Product Image"
                                        class="card-img-top"
                                        style="max-height: 200px; object-fit: contain;">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 d-flex justify-content-center">
                            <div class="form-check form-switch d-flex align-items-center mb-5">
                                <input class="form-check-input big-switch me-2 mb-5" type="checkbox" id="availabilitySwitch"
                                    data-product-id="{{ $product->id }}"
                                    {{ $product->availability ? 'checked' : '' }}>
                                <label class="form-check-label fs-8 mb-5" for="availabilitySwitch">Product Availability</label>
                            </div>
                        </div>

                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-12 d-flex justify-content-end gap-2">
                            <a href="{{ route('masters.products.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-sm">Update Product</button>
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

    $(document).ready(function() {
        $('#availabilitySwitch').on('change', function() {
            let productId = $(this).data('product-id');
            console.log(productId);
            let availability = $(this).is(':checked') ? 1 : 0;
            console.log(availability);
            let url = '{{ url('
            masters / product - upload / update - availability ') }}/' + productId;

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    availability: availability
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            toast: true,
                            position: 'bottom-end',
                            icon: 'success',
                            title: 'Availability updated successfully!',
                            background: '#d4edda',
                            color: '#155724',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true
                        });
                    } else {
                        Swal.fire({
                            toast: true,
                            position: 'bottom-end',
                            icon: 'error',
                            title: 'Failed to update availability.',
                            background: '#f8d7da',
                            color: '#721c24',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        icon: 'error',
                        title: 'An error occurred!',
                        background: '#f8d7da',
                        color: '#721c24',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true
                    });
                }
            });
        });
    });
</script>


@endpush