@extends('layouts/contentNavbarLayout')

@section('title', 'Add Product')

@section('content')
<h5 class="py-3 mb-4"><span class="text-muted fw-light">Masters /</span> Add New Product</h5>

<div class="row">
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Product Details</h5>
            </div>
            <div class="card-body">

                <form action="{{ route('masters.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control" value="{{old('product_name')}}">
                            @error('product_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Product Code</label>
                            <input type="text" name="product_code" class="form-control" value="{{old('product_code')}}">
                            @error('product_code') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Points</label>
                            <input type="text" name="points" class="form-control" value="{{old('points')}}">
                            <small class="text-muted d-block fw-bold"><span class="text-danger">*</span>Please enter only numeric values.</small>
                            @error('points') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Product Image</label>
                            <input type="file" name="img_path" class="form-control" onchange="previewImage(event)">
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
                            <a href="{{ route('masters.products.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-sm">Add Product</button>
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
</script>

@endpush