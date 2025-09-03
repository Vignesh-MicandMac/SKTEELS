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

<div class="row">
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Bulk Upload Closing Stocks</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ asset('storage/uploads/samples/closing_stocks_sample.xlsx') }}"
                        class="btn btn-primary btn-sm"
                        download>
                        Download Sample Excel
                    </a>
                </div>

                <form method="POST" action="{{ route('activity.stocks.closingStockBulkUpload' )}}" enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-8 mb-3">
                        <label class="form-label">Upload Excel File (.xlsx)</label>
                        <input type="file" name="file" class="form-control" required accept=".xlsx,.xls">
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('activity.stocks.closing_stock_index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm">Upload</button>
                    </div>
                </form>
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


<!-- stocks Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dealersTable">
                <thead class="table-light">
                    <tr>
                        <th># No</th>
                        <th>Dealer Name</th>
                        <th>Open Balance</th>
                        <th>Dispatch</th>
                        <th>Total Stock</th>
                        <th>Dispatch Date</th>
                        <th>Influencer Sales</th>
                        <th>Balance Stocks</th>
                        <th>Closing Stocks</th>
                        <th>Other Sales</th>
                        <th>Closing Updated At</th>
                        <th>Declined Stock</th>
                        <th>Date Of Declined</th>
                        <th>Updated Stock</th>
                        <th>Previous Total Current Stock</th>
                        <th>Total Current Stock</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($dealer_stocks as $key => $dealer_stock)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $dealer_stock->dealer->name ?? 'N/A'}}</td>
                        <td>{{ $dealer_stock->open_balance ?? 'N/A'}}</td>
                        <td>{{ $dealer_stock->dispatch ?? 'N/A'}}</td>
                        <td>{{ $dealer_stock->total_stock ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($dealer_stock->dispatch_date)->toDateString() ?? 'N/A'}}</td>
                        <td>{{ $dealer_stock->promoter_sales ?? 'N/A'}}</td>
                        <td>{{ $dealer_stock->balance_stock ?? 'N/A'}}</td>
                        <td>{{ $dealer_stock->closing_stock ?? 'N/A'}}</td>
                        <td>{{ $dealer_stock->other_sales ?? 'N/A'}}</td>
                        <td>{{ \Carbon\Carbon::parse($dealer_stock->closing_stock_updated_at)->toDateString() ?? 'N/A'}}</td>
                        <td>{{ $dealer_stock->declined_stock ?? 'N/A'}}</td>
                        <td>{{ \Carbon\Carbon::parse($dealer_stock->date_of_declined)->toDateString() ?? 'N/A'}}</td>
                        <td>{{ $dealer_stock->updated_stock ?? 'N/A'}}</td>
                        <td>{{ $dealer_stock->previous_total_current_stock ?? 'N/A'}}</td>
                        <td>{{ $dealer_stock->total_current_stock ?? 'N/A'}}</td>
                        <td>{{ \Carbon\Carbon::parse($dealer_stock->created_at)->toDateString() ?? 'N/A'}}</td>
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