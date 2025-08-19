<div class="modal-header">
    <h5 class="modal-title">Edit Brand</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form action="{{ route('activity.points.update', $stock_details->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="mb-3">
            <label for="role_name" class="form-label">Kg</label>
            <input type="text" name="kg" class="form-control" value="{{ $stock_details->kg }}" required>
            @error('kg') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="role_name" class="form-label">Points</label>
            <input type="text" name="points" class="form-control" value="{{ $stock_details->points }}" required>
            @error('points') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm">Update</button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>