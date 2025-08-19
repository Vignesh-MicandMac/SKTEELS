@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
<h5 class="py-3 mb-4"><span class="text-muted fw-light">Masters/</span> Closing Stock Update</h5>


<div class="row justify-content-center">
    <div class="col-md-6">
        <div id="dealer-info-card" style="display:none;">
            <div class="card mb-4 border-primary text-center">
                <div class="card-body">
                    <h5 class="card-title">
                        Dealer Name: <strong id="dealer-name"></strong>
                    </h5>
                    <h5 class="mb-0">
                        Current Stock: <strong id="dealer-stock"></strong>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Closing Stock Update</h5>
            </div>
            <div class="card-body">
                {{-- @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}
            </div>
            @endif --}}

            <form method="POST" action="{{ route('activity.stocks.closing_stock_update') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="dealer_ids" class="form-label"> Dealers</label>
                        <select name="dealer_id" id="dealer-select" class="form-select select2">
                            <option value="">Select Dealer</option>
                            @foreach($dealers as $dealer)
                            <option value="{{ $dealer->id }}">{{ $dealer->name }}</option>
                            @endforeach
                        </select>
                        @error('dealer_id') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Update Stock</label>
                        <input type="text" name="stock" class="form-control" value="{{old('stock')}}">
                        <small class="text-muted d-block fw-bold"><span class="text-danger">*</span>Please enter only numeric values.</small>
                        @error('stock') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>


                </div>

                <div class="row justify-content-end">
                    <div class="col-sm-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('activity.stocks.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
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


    $('#dealer-select').on('change', function() {
        let dealerId = $(this).val();

        if (dealerId) {
            $.ajax({
                url: `/activity/stocks/dealer-stock/${dealerId}`,
                type: 'GET',
                dataType: 'json',
                data: dealerId,
                success: function(data) {
                    $('#dealer-name').text(data.name);
                    $('#dealer-stock').text(data.stock);
                    $('#dealer-info-card').show();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching dealer stock:', error);
                }
            });
        } else {
            $('#dealer-info-card').hide();
        }
    });
</script>
@endpush