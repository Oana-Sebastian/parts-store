<?php
use App\Http\Controllers\PartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('parts.index');
});


Route::get('/parts', [PartController::class, 'index'])->name('parts.index');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/parts/create', [PartController::class, 'create'])->name('parts.create');
    Route::post('/parts', [PartController::class, 'store'])->name('parts.store');
    Route::get('/parts/{id}/edit', [PartController::class, 'edit'])->name('parts.edit');
    Route::put('/parts/{id}', [PartController::class, 'update'])->name('parts.update');
    Route::delete('/parts/{id}', [PartController::class, 'destroy'])->name('parts.destroy');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::patch('/admin/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update-status');
    Route::delete('/admin/orders/{id}', [AdminController::class, 'deleteOrder'])->name('admin.orders.delete');
});

Route::get('/parts/{id}', [PartController::class, 'show'])->name('parts.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

require __DIR__ . '/auth.php';