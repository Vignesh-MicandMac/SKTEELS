<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- Brand -->
    <div class="app-brand demo">
        <a href="{{url('/')}}" class="app-brand-link">
            <span class="app-brand-logo demo me-1">
                <div class="image">
                    <img src="{{ asset('logo.webp') }}" alt="Logo" class="img-fluid" style="width: 100  %; height: auto;">
                </div>
            </span>
            <span class="app-brand-text demo menu-text fw-semibold ms-2">SK STEELS TECH</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        @if(hasPermission(['view_dashboard']))
        <!-- Dashboard -->
        <li class="menu-item">
            <a href="{{ url('/dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-home-outline"></i>
                <div>Dashboard</div>
            </a>
        </li>
        @endif

        @if(hasPermission(['view_dealers','view_executives','view_executive_mapping','view_product_upload','view_promotors_type','view_promotors','view_brands']))
        <!-- Masters -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-account-outline"></i>
                <div>Masters</div>
            </a>
            <ul class="menu-sub">
                @if(hasPermission(['view_dealers']))
                <li class="menu-item"><a href="{{ url('masters/dealers') }}" class="menu-link">
                        <div>Dealers</div>
                    </a></li>
                @endif

                @if(hasPermission(['view_executives','add_executives','edit_executives']))
                <li class="menu-item"><a href="{{ url('masters/executives') }}" class="menu-link">
                        <div>Executives</div>
                    </a></li>
                @endif

                @if(hasPermission(['view_executive_mapping']))
                <li class="menu-item"><a href="{{ url('masters/executive-mapping') }}" class="menu-link">
                        <div>Executive Mapping</div>
                    </a></li>
                @endif

                @if(hasPermission(['view_product_upload']))
                <li class="menu-item"><a href="{{ url('masters/product-upload') }}" class="menu-link">
                        <div>Product Upload</div>
                    </a></li>
                @endif

                @if(hasPermission(['view_promotors_type']))
                <li class="menu-item"><a href="{{ url('masters/promotors_type') }}" class="menu-link">
                        <div>Promotors Type</div>
                    </a></li>
                @endif

                @if(hasPermission(['view_promotors']))
                <li class="menu-item"><a href="{{ url('masters/promotors') }}" class="menu-link">
                        <div>Promotors</div>
                    </a></li>
                @endif

                @if(hasPermission(['view_brands']))
                <li class="menu-item"><a href="{{ url('masters/brands') }}" class="menu-link">
                        <div>Brands</div>
                    </a></li>
                @endif
            </ul>
        </li>
        @endif


        <!-- Activity -->
        @if(hasPermission(['view_stock_points','view_add_stock','view_edit_stock','view_closing_stock_update','view_sale_entry_approval','view_promotors_approval','view_redeem_approval']))
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-cube-outline"></i>
                <div>Activity</div>
            </a>
            <ul class="menu-sub">
                @if(hasPermission(['view_stock_points']))
                <li class="menu-item"><a href="{{ url('activity/points') }}" class="menu-link">
                        <div>Stock Points</div>
                    </a></li>
                @endif

                @if(hasPermission(['view_add_stock']))
                <li class="menu-item"><a href="{{ url('activity/stocks/add-stocks') }}" class="menu-link">
                        <div>Add Stock</div>
                    </a></li>
                @endif

                @if(hasPermission(['view_edit_stock']))
                <li class="menu-item"><a href="{{ url('activity/edit-stock') }}" class="menu-link">
                        <div>Edit Stock</div>
                    </a></li>
                @endif

                @if(hasPermission(['view_closing_stock_update']))
                <li class="menu-item"><a href="{{ url('activity/stocks/closing-stock') }}" class="menu-link">
                        <div>Closing Stock Update</div>
                    </a></li>
                @endif

                @if(hasPermission(['view_sale_entry_approval']))
                <li class="menu-item"><a href="{{ url('activity/stocks/sale-entry') }}" class="menu-link">
                        <div>Sale Entry Approval</div>
                    </a></li>
                @endif

                @if(hasPermission(['view_promotors_approval']))
                <li class="menu-item"><a href="{{ url('activity/stocks/promotors-approval') }}" class="menu-link">
                        <div>Promotors Approval</div>
                    </a></li>
                @endif

                @if(hasPermission(['view_redeem_approval']))
                <li class="menu-item"><a href="{{ url('activity/Redeem-approval') }}" class="menu-link">
                        <div>Redeem Approval</div>
                    </a></li>
                @endif
            </ul>
        </li>
        @endif


        <!-- User Management -->
        @if(hasPermission(['view_roles','view_users','view_user_role_permission']))
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-account-key"></i>
                <div>User Management</div>
            </a>
            <ul class="menu-sub">
                @if(hasPermission(['view_roles']))
                <li class="menu-item"><a href="{{ url('users/role') }}" class="menu-link">
                        <div>Roles</div>
                    </a></li>
                @endif

                @if(hasPermission(['view_users']))
                <li class="menu-item"><a href="{{ url('user') }}" class="menu-link">
                        <div>User</div>
                    </a></li>
                @endif

                @if(hasPermission(['view_user_role_permission']))
                <li class="menu-item"><a href="{{ url('users/permissions') }}" class="menu-link">
                        <div>User Role Permission</div>
                    </a></li>
                @endif

            </ul>
        </li>
        @endif

        <!-- Report -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-form-select"></i>
                <div>Report</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item"><a href="report/redeem-list" class="menu-link">
                        <div>Redeem List</div>
                    </a></li>
                <li class="menu-item"><a href="report/executive-site-visit" class="menu-link">
                        <div>Executive Site Visit</div>
                    </a></li>
                <li class="menu-item"><a href="report/stock-management" class="menu-link">
                        <div>Stock Management</div>
                    </a></li>
                <li class="menu-item"><a href="report/received-product-list" class="menu-link">
                        <div>Recived Product List</div>
                    </a></li>
            </ul>
        </li>

        <!-- Apps & Pages -->
        <!-- <li class="menu-header fw-medium mt-4"><span class="menu-header-text">Apps & Pages</span></li> -->

        <!-- Account Settings -->
        <!-- <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-account-outline"></i>
                <div>Account Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item"><a href="pages/account-settings-account" class="menu-link">
                        <div>Account</div>
                    </a></li>
                <li class="menu-item"><a href="pages/account-settings-notifications" class="menu-link">
                        <div>Notifications</div>
                    </a></li>
                <li class="menu-item"><a href="pages/account-settings-connections" class="menu-link">
                        <div>Connections</div>
                    </a></li>
            </ul>
        </li> -->

        <!-- Authentications -->
        <!-- <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-lock-open-outline"></i>
                <div>Authentications</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item"><a href="auth/login-basic" target="_blank" class="menu-link">
                        <div>Login</div>
                    </a></li>
                <li class="menu-item"><a href="auth/register-basic" target="_blank" class="menu-link">
                        <div>Register</div>
                    </a></li>
                <li class="menu-item"><a href="auth/forgot-password-basic" target="_blank" class="menu-link">
                        <div>Forgot Password</div>
                    </a></li>
            </ul>
        </li> -->

        <!-- Misc -->
        <!-- <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-cube-outline"></i>
                <div>Misc</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item"><a href="pages/misc-error" target="_blank" class="menu-link">
                        <div>Error</div>
                    </a></li>
                <li class="menu-item"><a href="pages/misc-under-maintenance" target="_blank" class="menu-link">
                        <div>Under Maintenance</div>
                    </a></li>
            </ul>
        </li> -->


    </ul>
</aside>
@push('scripts')
<script>
    let currentPath = window.location.pathname.replace(/\/$/, "");
    document.querySelectorAll('.menu-link').forEach(function(link) {
        let linkPath = new URL(link.href).pathname.replace(/\/$/, "");
        if (linkPath === currentPath) {
            link.closest('.menu-item').classList.add('active');
            let parentMenu = link.closest('.menu-sub');
            if (parentMenu) {
                parentMenu.closest('.menu-item').classList.add('open', 'active');
            }
        }
    });
</script>

@endpush