    <?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AddOnBilliardController;
use App\Http\Controllers\AddOnController;
use App\Http\Controllers\AssetManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartOrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardServerController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ListStockController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OtherSettingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportAbsensiController;
use App\Http\Controllers\ReportPenjualanController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockInProductController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\StockOutProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TagController;

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

Route::get('/', function () {
    return view('auth.login');
});

    Auth::routes();

    Route::middleware('auth:web')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/tes', [DashboardController::class, 'tes'])->name('tes');

        // Dashboard Analytic
        Route::get('/dashboard-analytic', [DashboardController::class, 'dashboardAnalytic'])->name('dashboard-analytic');

            // Master-data
            Route::get('/master-data', function () {
                return view('master-data.index');
            })->name('master-data.index');

            // Absen
            Route::get('/absens', [AbsenController::class,'index'])->name('absens.index');
            Route::post('/absens-masuk', [AbsenController::class,'absenMasuk'])->name('absens-masuk');
            Route::post('/absens-keluar', [AbsenController::class,'absenKeluar'])->name('absens-keluar');

            // Shop
            Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
            Route::get('/shop/detail/{id}', [DetailController::class, 'index'])->name('detail-restaurant');


            // Cart
            Route::get('/cart',[CartOrderController::class, 'index'])->name('cart');
            Route::get('/add-cart-restaurant/{id}',[CartOrderController::class, 'addCartRestaurant'])->name('add-cart');
            Route::get('/delete-chart/{id}',[CartOrderController::class, 'deleteCartRestaurant'])->name('delete-cart');

            // Checkout
            Route::post('/checkout/{token}',[OrderController::class,'checkout'])->name('checkout-order');
            Route::post('/checkout/checkout-waiters/{token}',[OrderController::class,'checkoutWaiters'])->name('checkout-waiters');


            Route::prefix('master-data')->name('master-data.')->group(function () {

                // User
                Route::patch('change-password', [UserController::class, 'changePassword'])->name('users.change-password');
                Route::resource('users', UserController::class)->except([
                    'show'
                ]);

                Route::get('/user-profile/{id}', [UserController::class, 'userProfile'])->name('users.user-profile');        


                // // departement
                Route::resource('/departements', DepartementController::class);

                Route::post('/customer-import', [AbsenController::class, 'import'])->name('customer.import');


                // // Material
                Route::resource('/materials', MaterialController::class);

                // // Asset Management
                Route::resource('/asset-managements', AssetManagementController::class);

                // // Tag
                Route::resource('/tags', TagController::class);

                // // Discount
                Route::resource('/discounts', DiscountController::class);

                // // Management Supplier
                Route::resource('/suppliers', SupplierController::class);

                // Other Setting
                Route::get('/other-settings', [OtherSettingController::class, 'index'])->name('other-settings.index');
                Route::post('/other-settings/{id}', [OtherSettingController::class, 'update'])->name('other-settings.update');

                 // // Add On
                Route::resource('/add-ons', AddOnController::class);
                
            });
            
            // Management Product
            Route::resource('/products', ProductController::class);

             // // Inventory
            Route::get('/list-stocks', [ListStockController::class, 'index'])->name('inventory.list-stock.index');

            // inventory Stok In
            Route::resource('/stock-ins', StockInController::class);

            // inventory Stok In
            Route::resource('/stock-in-products', StockInProductController::class);

            // inventory Stok Out
            Route::resource('/stock-out-products', StockOutProductController::class);

            // // inventory Stok Keluar
            Route::resource('/stock-outs', StockOutController::class);

            // // Report Penjualan
            Route::get('/report-penjualan', [ReportPenjualanController::class, 'index'])->name('report-penjualan'); 
            
            // Report Penjualan
            Route::get('/report-absensi', [ReportAbsensiController::class, 'index'])->name('report-absensi'); 
            
            
        });

        // dashboard Server
        Route::prefix('kasir')->name('kasir.')->group(function () {
            Route::get('/dashboard', [DashboardServerController::class, 'index'])->name('dashboard.server');
            Route::post('/dashboard-status', [DashboardServerController::class, 'statusDashboard'])->name('status-dashboard');
            Route::post('/dashboard-status-all', [DashboardServerController::class, 'statusDashboardAll'])->name('status-server-dashboard-all');
            Route::get('/dashboard-detail/{id}', [DashboardServerController::class, 'detail'])->name('dashboard.detail');
            Route::post('/status-update', [DashboardServerController::class, 'statusUpdate'])->name('status-update');
            Route::get('/change-open-bill/{id}', [DashboardServerController::class, 'changeOpenBill'])->name('change-open-bill');
            Route::get('/print-otomatis', [DashboardServerController::class, 'autoPrintButton'])->name('autoPrintButton');
            Route::resource('/dashboard-detail-kasir', DashboardServerController::class);
            Route::patch('/dashboard-update-payment/{id}', [DashboardServerController::class, 'updatePayment'])->name('update-payment');
            Route::patch('/dashboard-update-order/{id}', [DashboardServerController::class, 'updateOrder'])->name('update-order');

        });

         // dashboard Waiters
        Route::prefix('waiters')->name('waiters.')->group(function () {
        Route::get('/dashboard', [DashboardWaiterController::class, 'index'])->name('dashboard.waiters');
        Route::post('/dashboard-status', [DashboardWaiterController::class, 'statusDashboard'])->name('status-dashboard');
        Route::post('/dashboard-status-all', [DashboardWaiterController::class, 'statusDashboardAll'])->name('status-waiters-dashboard-all');
        Route::get('/dashboard-detail/{id}', [DashboardWaiterController::class, 'detail'])->name('dashboard.detail');
        Route::post('/status-update', [DashboardWaiterController::class, 'statusUpdate'])->name('status-update');
        Route::post('/tes', [DashboardWaiterController::class, 'tes'])->name('tes');
        });
