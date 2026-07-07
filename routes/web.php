<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// ============ ROUTE YANG PERLU LOGIN ============
Route::middleware(['auth'])->group(function () {

    // Dashboard (otomatis redirect ke admin/user)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin', [DashboardController::class, 'admin'])->name('admin.dashboard');

    // ====== ROUTE CUSTOMER ======
    // Packages (public)
    Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
    Route::get('/packages/{package}', [PackageController::class, 'show'])->name('packages.show');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // Payments
    Route::get('/orders/{order}/payment', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/orders/{order}/payment', [PaymentController::class, 'store'])->name('payments.store');

    // Tracking
    Route::get('/orders/{order}/tracking', [TrackingController::class, 'show'])->name('tracking.show');

    // ====== ROUTE ADMIN ======
    Route::middleware(['isAdmin'])->group(function () {

        // Package Management (CRUD)
        Route::get('/admin/packages/create', [PackageController::class, 'create'])->name('packages.create');
        Route::post('/admin/packages', [PackageController::class, 'store'])->name('packages.store');
        Route::get('/admin/packages/{package}/edit', [PackageController::class, 'edit'])->name('packages.edit');
        Route::put('/admin/packages/{package}', [PackageController::class, 'update'])->name('packages.update');
        Route::delete('/admin/packages/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');

        // Order Management
        Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
        Route::put('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

        // Payment Management
        Route::get('/admin/payments', [PaymentController::class, 'index'])->name('admin.payments.index');
        Route::put('/admin/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('admin.payments.verify');
        Route::put('/admin/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('admin.payments.reject');
    });
});