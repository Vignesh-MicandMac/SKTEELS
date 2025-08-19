<div class="modal-header">
    <h5 class="modal-title">Edit Promotor Type</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form action="{{ route('masters.pro_type.update', $promotor_type->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="mb-3">
            <label for="role_name" class="form-label">Promotor Type Name</label>
            <input type="text" name="promotor_type" class="form-control" value="{{ $promotor_type->promotor_type }}" required>
            @error('promotor_type') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm">Update</button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>