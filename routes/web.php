<?php

use App\Http\Controllers\CustomerController;
use App\Http\Livewire\Administrators\AdminAddAdministratorComponent;
use App\Http\Livewire\Administrators\AdminAdministratorComponent;
use App\Http\Livewire\Administrators\AdminEditAdministratorComponent;
use App\Http\Livewire\AdminProfileAdminComponent;
use App\Http\Livewire\Blogs\AdminAddBlogCategoryComponent;
use App\Http\Livewire\Blogs\AdminBlogCategoryComponent;
use App\Http\Livewire\Blogs\AdminEditBlogCategoryComponent;
use App\Http\Livewire\Blogs\AdminAddBlogComponent;
use App\Http\Livewire\Blogs\AdminBlogComponent;
use App\Http\Livewire\Blogs\AdminEditBlogComponent;
use App\Http\Livewire\Categories\AdminAddCategoryComponent;
use App\Http\Livewire\Categories\AdminCategoryComponent;
use App\Http\Livewire\Categories\AdminEditCategoryComponent;
use App\Http\Livewire\Commands\AdminCommandComponent;
use App\Http\Livewire\Customers\AdminCustomerComponent;
use App\Http\Livewire\DashboardComponent;
use App\Http\Livewire\Grants\AdminAddGrantPermissionComponent;
use App\Http\Livewire\Grants\AdminEditGrantPermissionComponent;
use App\Http\Livewire\Grants\AdminGrantPermissionComponent;
// use App\Http\Livewire\Homeslider\AdminAddHomeSliderComponent;
// use App\Http\Livewire\Homeslider\AdminEditHomeSliderComponent;
// use App\Http\Livewire\Homeslider\AdminHomeSliderComponent;
use App\Http\Livewire\Products\AdminAddProductComponent;
use App\Http\Livewire\Products\AdminEditProductComponent;
use App\Http\Livewire\Products\AdminProductComponent;
use App\Http\Livewire\Suppliers\AdminAddSupplierComponent;
use App\Http\Livewire\Suppliers\AdminEditSupplierComponent;
use App\Http\Livewire\Suppliers\AdminSupplierComponent;
use App\Http\Livewire\Orders\AdminOrderComponent;
use App\Http\Livewire\Payments\AdminAddPaymentComponent;
use App\Http\Livewire\Payments\AdminEditPaymentComponent;
use App\Http\Livewire\Payments\AdminPaymentComponent;
use App\Http\Livewire\Warehouse\AdminAddImportComponent;
use App\Http\Livewire\Warehouse\AdminImportComponent;
use App\Http\Livewire\Warehouse\AdminExportComponent;
use App\Http\Livewire\Permission\AdminPermissionComponent;
use App\Http\Livewire\Roles\AdminAddRoleComponent;
use App\Http\Livewire\Roles\AdminEditRoleComponent;
use App\Http\Livewire\Roles\AdminRoleComponent;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Vouchers\AdminAddVoucherComponent;
use App\Http\Livewire\Vouchers\AdminVoucherComponent;
use App\Http\Livewire\Vouchers\AdminEditVoucherComponent;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'handle-author-admin'
])->group(function () {
    Route::get('/', DashboardComponent::class);
    Route::get('/dashboard', DashboardComponent::class)->name('dashboard');
    Route::get('/profile', AdminProfileAdminComponent::class)->name('profile');

    // Route group for categories
    Route::get('/categories', AdminCategoryComponent::class)->name('categories');
    Route::get('/categories/add', AdminAddCategoryComponent::class)->name('addcategory');
    Route::get('/categories/edit/{cate_slug}', AdminEditCategoryComponent::class)->name('editcategory');

    // Route group for suppliers
    Route::get('/suppliers', AdminSupplierComponent::class)->name('suppliers');
    Route::get('/suppliers/add', AdminAddSupplierComponent::class)->name('addsupplier');
    Route::get('/suppliers/edit/{sup_slug}', AdminEditSupplierComponent::class)->name('editsupplier');

    // Route group for products
    Route::get('/products', AdminProductComponent::class)->name('products');
    Route::get('/products/add', AdminAddProductComponent::class)->name('addproduct');
    Route::get('/products/edit/{product_slug}', AdminEditProductComponent::class)->name('editproduct');

    // Route group for orders
    Route::get('/orders', AdminOrderComponent::class)->name('orders');

    // Route group for payments
    Route::get('/payments', AdminPaymentComponent::class)->name('payments');
    Route::get('/payments/add', AdminAddPaymentComponent::class)->name('addpayment');
    Route::get('/payments/edit/{paymenttype_slug}', AdminEditPaymentComponent::class)->name('editpayment');

    // Route group for sliders
    // Route::get('/homeslider', AdminHomeSliderComponent::class)->name('homeslider');
    // Route::get('/homeslider/add', AdminAddHomeSliderComponent::class)->name('addhomeslider');
    // Route::get('/homeslider/edit/{slider_slug}', AdminEditHomeSliderComponent::class)->name('edithomeslider');

    // Route group for blog categories
    Route::get('/blogcategories', AdminBlogCategoryComponent::class)->name('blogcategories');
    Route::get('/blogcategories/add', AdminAddBlogCategoryComponent::class)->name('addblogcategory');
    Route::get('/blogcategories/edit/{category_slug}', AdminEditBlogCategoryComponent::class)->name('editblogcategory');

	// Route group for blog categories
    Route::get('/blogs', AdminBlogComponent::class)->name('blogs');
    Route::get('/blogs/add', AdminAddBlogComponent::class)->name('addblog');
    Route::get('/blogs/edit/{blog_slug}', AdminEditBlogComponent::class)->name('editblog');

    // Route group for customers
    Route::get('/customers', AdminCustomerComponent::class)->name('customers');
    Route::get('customers/export/', [CustomerController::class, 'export'])->name('customers-export');

    // Route group for warehouse
    Route::get('/import', AdminImportComponent::class)->name('import');
    Route::get('/import/add', AdminAddImportComponent::class)->name('addimport');
    Route::get('/export', AdminExportComponent::class)->name('export');
    // Route group for authorization
    Route::get('/roles', AdminRoleComponent::class)->name('roles');
    Route::get('/roles/add', AdminAddRoleComponent::class)->name('addrole');
    Route::get('/roles/edit/{role_slug}', AdminEditRoleComponent::class)->name('editrole');
    Route::get('/permissions', AdminPermissionComponent::class)->name('permissions');
    Route::get('/commands', AdminCommandComponent::class)->name('commands');
    Route::get('/grant-permissions', AdminGrantPermissionComponent::class)->name('grant-permissions');
    Route::get('/grant-permissions/add', AdminAddGrantPermissionComponent::class)->name('add-grant-permissions');
    Route::get('/grant-permissions/edit/{grant_id}', AdminEditGrantPermissionComponent::class)->name('edit-grant-permissions');

    // Route group for administrators
    Route::get('/administrators', AdminAdministratorComponent::class)->name('administrators');
    Route::get('/administrators/add', AdminAddAdministratorComponent::class)->name('addadministrator');
    Route::get('/administrators/edit/{id}', AdminEditAdministratorComponent::class)->name('editadministrator');

    // Route group for categories
    Route::get('/vouchers', AdminVoucherComponent::class)->name('vouchers');
    Route::get('/vouchers/add', AdminAddVoucherComponent::class)->name('addvoucher');
    Route::get('/vouchers/edit/{voucher_slug}', AdminEditVoucherComponent::class)->name('editvoucher');

});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/queue', function () {
    $exitCode = Artisan::call('queue:work --stop-when-empty', []);

    return 'Queue started.';
});

Route::get('/queue-restart', function () {
    Artisan::call('queue:restart');

});