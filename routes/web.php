
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;



// Halaman About
Route::get('/about', function () {
    return '<h1>Barokah Mart</h1>
            <p>Toko kelontong terpercaya di lingkungan Anda sejak 2010.</p>
            <p>Menyediakan kebutuhan sehari-hari dengan harga terjangkau.</p>';
});

// Authentication
Route::get('/login', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest')
    ->name('login.store');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Route khusus Admin
Route::middleware(['auth', 'role:admin'])->group(function () {

Route::get('/reports/sales', [ReportController::class, 'sales'])
    ->name('report.sales');

Route::get('/reports/sales/export', [ReportController::class, 'export'])
    ->name('report.export');

    // Jumlah produk per kategori
    Route::get('/categories/product-count', [
        CategoryController::class,
        'productCount'
    ])->name('categories.product-count');

    // Data kategori dan produk
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);

    // Supplier
    Route::resource('suppliers', SupplierController::class);

    // Laporan penjualan
    Route::get('/reports/sales', [ReportController::class, 'sales'])
        ->name('report.sales');

    // Manajemen pengguna
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');
});

// Route Admin dan Kasir
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {

Route::get('/pos', [PosController::class, 'index'])
    ->name('pos.index');

Route::post('/pos', [PosController::class, 'store'])
    ->name('pos.store');

Route::get('/pos/{transaction}/struk', [PosController::class, 'struk'])
    ->name('pos.struk');

    // Halaman Riwayat Saya (sementara)
Route::get('/transaksi-saya', [PosController::class, 'myTransactions'])
    ->name('pos.my-transactions');

    // Halaman POS
    Route::get('/pos', [PosController::class, 'index'])
        ->name('pos.index');
});

// Route pengujian middleware
Route::get('/tes-admin', function () {
    return 'Berhasil! Anda memiliki akses Admin.';
})->middleware(['auth', 'role:admin']);

Route::get('/tes-kasir', function () {
    return 'Berhasil! Anda memiliki akses Kasir.';
})->middleware(['auth', 'role:kasir']);
