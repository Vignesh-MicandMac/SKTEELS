<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\MdiIcons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\masters\BrandController;
use App\Http\Controllers\masters\DealersController;
use App\Http\Controllers\masters\DealersStockManagementController;
use App\Http\Controllers\masters\ExecutiveDealerMappingController;
use App\Http\Controllers\masters\ExecutivesController;
use App\Http\Controllers\masters\ProductController;
use App\Http\Controllers\masters\PromotorController;
use App\Http\Controllers\masters\PromotorTypeController;
use App\Http\Controllers\masters\StockPointsController;
use App\Http\Controllers\masters\StocksManagementController;
use App\Http\Controllers\MastersController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\UserController;

// Main Page Route
// Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');

// // pages
// Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
// Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
// Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
// Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
// Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

// // authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
// Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
// Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

// // cards
// Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

// // User Interface
// Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
// Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
// Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
// Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
// Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
// Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
// Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
// Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
// Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
// Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
// Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
// Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
// Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
// Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
// Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
// Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
// Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
// Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
// Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

// // extended ui
// Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
// Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

// // icons
// Route::get('/icons/icons-mdi', [MdiIcons::class, 'index'])->name('icons-mdi');

// // form elements
// Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
// Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

// // form layouts
// Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
// Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');

// // tables
// Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');


// Login Routes
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    //Dashboard
    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');
    //Masters Menu

    //Dealers
    Route::prefix('masters/dealers')->name('masters.dealers.')->group(function () {
        Route::get('/', [DealersController::class, 'index'])->name('index');
        Route::get('/create', [DealersController::class, 'create'])->name('create');
        Route::post('/store', [DealersController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [DealersController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [DealersController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [DealersController::class, 'destroy'])->name('destroy');
        Route::get('/get-districts/{state_id}', [DealersController::class, 'getDistricts']);
    });

    //Executives
    Route::prefix('masters/executives')->name('masters.executives.')->group(function () {
        Route::get('/', [ExecutivesController::class, 'index'])->name('index');
        Route::get('/create', [ExecutivesController::class, 'create'])->name('create');
        Route::post('/store', [ExecutivesController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ExecutivesController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ExecutivesController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [ExecutivesController::class, 'destroy'])->name('destroy');
        Route::get('/get-districts/{state_id}', [ExecutivesController::class, 'getDistricts']);
    });

    //Executive Mapping 
    Route::prefix('masters/executive-mapping')->name('masters.executive.mapping.')->group(function () {
        Route::get('/', [ExecutiveDealerMappingController::class, 'index'])->name('index');
        Route::post('/store', [ExecutiveDealerMappingController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ExecutiveDealerMappingController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ExecutiveDealerMappingController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [ExecutiveDealerMappingController::class, 'destroy'])->name('destroy');
        Route::delete('/delete/{id}', [ExecutiveDealerMappingController::class, 'delete'])->name('delete');
    });

    //Products 
    Route::prefix('masters/product-upload')->name('masters.products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy');
        Route::post('/update-availability/{product}', [ProductController::class, 'updateAvailability']);
    });

    //Promotors Type
    Route::prefix('masters/promotors_type')->name('masters.pro_type.')->group(function () {
        Route::get('/', [PromotorTypeController::class, 'index'])->name('index');
        Route::post('/store', [PromotorTypeController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PromotorTypeController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [PromotorTypeController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [PromotorTypeController::class, 'destroy'])->name('destroy');
    });

    //Promotors 
    Route::prefix('masters/promotors')->name('masters.promotors.')->group(function () {
        Route::get('/', [PromotorController::class, 'index'])->name('index');
        Route::get('/create', [PromotorController::class, 'create'])->name('create');
        Route::post('/store', [PromotorController::class, 'store'])->name('store');
        Route::post('/mapping-dealers', [PromotorController::class, 'mapping_dealers'])->name('mapping_dealers');
        Route::get('/edit/{id}', [PromotorController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [PromotorController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [PromotorController::class, 'destroy'])->name('destroy');
    });

    //Brands
    Route::prefix('masters/brands')->name('masters.brands.')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::post('/store', [BrandController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [BrandController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [BrandController::class, 'destroy'])->name('destroy');
    });

    //Stocks Points
    Route::prefix('activity/points')->name('activity.points.')->group(function () {
        Route::get('/', [StockPointsController::class, 'index'])->name('index');
        Route::post('/store', [StockPointsController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [StockPointsController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [StockPointsController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [StockPointsController::class, 'destroy'])->name('destroy');
    });

    //Stocks Management
    Route::prefix('activity/stocks')->name('activity.stocks.')->group(function () {
        Route::get('/add-stocks', [DealersStockManagementController::class, 'index'])->name('index');
        Route::post('/store', [DealersStockManagementController::class, 'store'])->name('store');
        Route::get('/closing-stock', [DealersStockManagementController::class, 'closing_stock_index'])->name('closing_stock_index');
        Route::post('/closing-stock-update', [DealersStockManagementController::class, 'closing_stock_update'])->name('closing_stock_update');
        Route::get('/edit/{id}', [DealersStockManagementController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [DealersStockManagementController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [DealersStockManagementController::class, 'destroy'])->name('destroy');
        Route::get('/dealer-stock/{id}', [DealersStockManagementController::class, 'getDealerStock'])->name('dealer.stock');
        Route::get('/sale-entry', [DealersStockManagementController::class, 'sale_entry'])->name('sale_entry');
        Route::post('/sale-entry-update/{id}', [DealersStockManagementController::class, 'sale_entry_update'])->name('sale_entry_update');
        Route::get('/promotors-approval', [DealersStockManagementController::class, 'promotors_approval_list'])->name('promotors_approval');
        Route::post('/promotors-approval-update/{id}', [DealersStockManagementController::class, 'promotors_approval_update'])->name('promotors_approval_update');
    });

    Route::prefix('users/role')->name('users.role.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/store', [RoleController::class, 'store'])->name('store');
        Route::put('/update/{id}', [RoleController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
        Route::delete('/destroy/{id}', [RoleController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('user')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('users/permissions')->name('users.permissions.')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::post('/store', [PermissionController::class, 'store'])->name('store');
    });
});

// Route::middleware(['auth'])->group(function () {

// //User Role and Permissions

//     Route::prefix('users/role')->name('users.role.')->group(function () {
//         Route::get('/', [RoleController::class, 'index'])->name('index');
//         Route::get('/create', [RoleController::class, 'create'])->name('create');
//         Route::post('/store', [RoleController::class, 'store'])->name('store');
//     });
//     Route::prefix('user')->name('users.')->group(function () {
//         Route::get('/', [UserController::class, 'index'])->name('index');
//         Route::get('/add-user/create', [UserController::class, 'create'])->name('create');
//         Route::post('/add-user/store', [UserController::class, 'store'])->name('store');
//     });
//     Route::prefix('users/permissions')->name('users.permissions.')->group(function () {
//         Route::get('/', [PermissionController::class, 'index'])->name('index');
//         Route::post('/store', [PermissionController::class, 'store'])->name('store');
//     });

// //User Role and Permissions

//     //Dashboard
//     Route::get('/', [DashBoardController::class, 'index'])->name('dashboard');

//     //Masters Menu

//     //Dealers
//     Route::prefix('masters/dealers')->name('masters.dealers.')->group(function () {
//         Route::get('/', [DealersController::class, 'index'])->name('index');
//         Route::get('/create', [DealersController::class, 'create'])->name('create');
//         Route::post('/store', [DealersController::class, 'store'])->name('store');
//         Route::get('/edit/{id}', [DealersController::class, 'edit'])->name('edit');
//         Route::put('/update/{id}', [DealersController::class, 'update'])->name('update');
//         Route::delete('/destroy/{id}', [DealersController::class, 'destroy'])->name('destroy');
//         Route::get('/get-districts/{state_id}', [DealersController::class, 'getDistricts']);
//     });

//     //Executives
//     Route::prefix('masters/executives')->name('masters.executives.')->group(function () {
//         Route::get('/', [ExecutivesController::class, 'index'])->name('index');
//         Route::get('/create', [ExecutivesController::class, 'create'])->name('create');
//         Route::post('/store', [ExecutivesController::class, 'store'])->name('store');
//         Route::get('/edit/{id}', [ExecutivesController::class, 'edit'])->name('edit');
//         Route::put('/update/{id}', [ExecutivesController::class, 'update'])->name('update');
//         Route::delete('/destroy/{id}', [ExecutivesController::class, 'destroy'])->name('destroy');
//         Route::get('/get-districts/{state_id}', [ExecutivesController::class, 'getDistricts']);
//     });

//     //Executive Mapping 
//     Route::prefix('masters/executive-mapping')->name('masters.executive.mapping.')->group(function () {
//         Route::get('/', [ExecutiveDealerMappingController::class, 'index'])->name('index');
//         Route::post('/store', [ExecutiveDealerMappingController::class, 'store'])->name('store');
//         Route::get('/edit/{id}', [ExecutiveDealerMappingController::class, 'edit'])->name('edit');
//         Route::put('/update/{id}', [ExecutiveDealerMappingController::class, 'update'])->name('update');
//         Route::delete('/destroy/{id}', [ExecutiveDealerMappingController::class, 'destroy'])->name('destroy');
//         Route::delete('/delete/{id}', [ExecutiveDealerMappingController::class, 'delete'])->name('delete');
//     });
// });
