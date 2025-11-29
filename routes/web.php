<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;

Route::get('/', [HotelController::class, 'index'])->name('home');
Route::get('/hotel/{id}', [HotelController::class, 'show'])->name('hotel.show');

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HotelController::class, 'dashboard'])->name('dashboard');
    Route::post('/reserve', [HotelController::class, 'storeReservation'])->name('reserve');
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [HotelController::class, 'adminHome'])->name('admin.home');
    Route::get('/admin/users', [HotelController::class, 'adminUsers'])->name('admin.users');
    Route::post('/admin/hotel', [HotelController::class, 'storeHotel'])->name('admin.hotel.store');
    Route::delete('/admin/hotel/{id}', [HotelController::class, 'deleteHotel'])->name('admin.hotel.delete');
});