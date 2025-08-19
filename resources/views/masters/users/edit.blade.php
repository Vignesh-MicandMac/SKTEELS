<div class="modal-header">
    <h5 class="modal-title">Edit User</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="row">
            <!-- Name -->
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}" required>
            </div>

            <!-- Email -->
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}" required>
            </div>

            <!-- Password -->
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <!-- Mobile -->
            <div class="col-md-6 mb-3">
                <label for="mobile" class="form-label">Mobile</label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="{{$user->mobile}}" required>
            </div>

            <!-- Role Selection -->
            <div class="col-md-6 mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-control" id="role" name="role_id" required>
                    <option value="">Select Role</option>
                    @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm">Update</button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>