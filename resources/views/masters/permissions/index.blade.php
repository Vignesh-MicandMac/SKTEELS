@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Permissions')

@section('content')
@php
$userPermissions = session('user_permissions', []);
@endphp
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="py-3 mb-0"><span class="text-muted fw-light">Masters /</span> User Role Permissions</h5>
</div>

<div class="permissions">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 permission">Manage Role Permissions</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.permissions.store') }}" method="POST">
                @csrf
                <div class="mb-4 col-md-6">
                    <label for="role-select" class="form-label fw-semibold">Select Role</label>
                    <select name="role_id" id="role-select" class="form-select" required>
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <h5 class="fw-semibold mb-3">Menu Permissions</h5>
                    <div class="row g-4">
                        <!-- Dashboard -->
                        <div class="col-12">
                            <div class="card p-3 border-light shadow-sm">
                                <h6 class="fw-semibold mb-3">Dashboard</h6>
                                <div class="form-check">
                                    @php
                                    $dashboardPerm = $permissions->firstWhere('name', 'view_dashboard');
                                    @endphp
                                    <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $dashboardPerm->id }}" id="view_dashboard" @if( in_array('view_dashboard', $userPermissions) ) checked @endif>
                                    <label class="form-check-label" for="view_dashboard">{{ $dashboardPerm->label }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Masters -->
                        <div class="col-12">
                            <div class="card p-3 border-light shadow-sm">
                                <h6 class="fw-semibold mb-3">Masters</h6>

                                <!-- Main Select All Checkbox -->
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input select-all" id="masters_select_all">
                                    <label class="form-check-label" for="masters_select_all">Select All</label>
                                </div>

                                <div class="row g-3">
                                    @foreach(['dealers', 'executives', 'executive_mapping', 'product_upload', 'promotors_type', 'promotors', 'brands'] as $menu)
                                    <div class="col-md-6 col-lg-3">
                                        <div class="mb-3">
                                            <h6 class="fw-semibold">{{ ucwords(str_replace('_', ' ', $menu)) }}</h6>
                                            @foreach(['view', 'add', 'edit', 'delete'] as $action)
                                            @php
                                            $permName = "{$action}_{$menu}";
                                            $permission = $permissions->firstWhere('name', $permName);
                                            @endphp
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input masters-permission" name="permissions[]" value="{{ $permission->id }}" id="{{ $permName }}" @if(in_array($permName, $userPermissions)) checked @endif>
                                                <label class="form-check-label" for="{{ $permName }}">{{ $permission->label }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Activity -->
                        <div class="col-12">
                            <div class="card p-3 border-light shadow-sm">
                                <h6 class="fw-semibold mb-3">Activity</h6>

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input select-all" id="activity_select_all">
                                    <label class="form-check-label" for="activity_select_all">Select All</label>
                                </div>

                                <div class="row g-2">
                                    @foreach(['stock_points', 'add_stock', 'edit_stock', 'closing_stock_update', 'sale_entry_approval', 'promotors_approval', 'redeem_approval'] as $menu)
                                    <div class="col-md-6 col-lg-3">
                                        <div class="mb-3">
                                            <h6 class="fw-semibold">{{ ucwords(str_replace('_', ' ', $menu)) }}</h6>
                                            @foreach(['view', 'add', 'edit', 'delete'] as $action)
                                            @php
                                            $permName = "{$action}_{$menu}";
                                            $permission = $permissions->firstWhere('name', $permName);
                                            @endphp
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input activity-permissions" name="permissions[]" value="{{ $permission->id }}" id="{{ $permName }}" @if(in_array($permName, $userPermissions)) checked @endif>
                                                <label class="form-check-label" for="{{ $permName }}">{{ $permission->label }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- User Management -->
                        <div class="col-12">
                            <div class="card p-3 border-light shadow-sm">
                                <h6 class="fw-semibold mb-3">User Management</h6>

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input select-all" id="users_select_all">
                                    <label class="form-check-label" for="users_select_all">Select All</label>
                                </div>


                                <div class="row g-2">
                                    @foreach(['roles', 'users', 'user_role_permission'] as $menu)
                                    <div class="col-md-6 col-lg-3">
                                        <div class="mb-3">
                                            <h6 class="fw-semibold">{{ ucwords(str_replace('_', ' ', $menu)) }}</h6>
                                            @foreach(['view', 'add', 'edit', 'delete'] as $action)
                                            @php
                                            $permName = "{$action}_{$menu}";
                                            $permission = $permissions->firstWhere('name', $permName);
                                            @endphp
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input users-permissions" name="permissions[]" value="{{ $permission->id }}" id="{{ $permName }}" @if(in_array($permName, $userPermissions)) checked @endif>
                                                <label class="form-check-label" for="{{ $permName }}">{{ $permission->label }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end mt-4">
                    <div class="col-sm-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('users.permissions.index') }}" class="btn btn-outline-dark btn-sm">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all toggle for Masters menu
        const mastersSelectAll = document.getElementById('masters_select_all');
        const mastersCheckboxes = document.querySelectorAll('.masters-permission');

        mastersSelectAll.addEventListener('change', function() {
            mastersCheckboxes.forEach(cb => cb.checked = mastersSelectAll.checked);
        });

        // Optional: If all individual checkboxes are checked manually, main checkbox auto checks
        mastersCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                mastersSelectAll.checked = [...mastersCheckboxes].every(c => c.checked);
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Select all toggle for Masters menu
        const mastersSelectAll = document.getElementById('activity_select_all');
        const mastersCheckboxes = document.querySelectorAll('.activity-permissions');

        mastersSelectAll.addEventListener('change', function() {
            mastersCheckboxes.forEach(cb => cb.checked = mastersSelectAll.checked);
        });

        // Optional: If all individual checkboxes are checked manually, main checkbox auto checks
        mastersCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                mastersSelectAll.checked = [...mastersCheckboxes].every(c => c.checked);
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        // Select all toggle for Masters menu
        const mastersSelectAll = document.getElementById('users_select_all');
        const mastersCheckboxes = document.querySelectorAll('.users-permissions');

        mastersSelectAll.addEventListener('change', function() {
            mastersCheckboxes.forEach(cb => cb.checked = mastersSelectAll.checked);
        });

        // Optional: If all individual checkboxes are checked manually, main checkbox auto checks
        mastersCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                mastersSelectAll.checked = [...mastersCheckboxes].every(c => c.checked);
            });
        });
    });
</script>

@endpush