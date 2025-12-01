<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;

// 1. HOME E DETTAGLI (Pubbliche)
Route::get('/', [HotelController::class, 'index'])->name('home');
Route::get('/hotel/{id}', [HotelController::class, 'show'])->name('hotel.show');

// 2. AUTH (Login/Register - file separato)
require __DIR__ . '/auth.php';

// 3. UTENTE LOGGATO (Dashboard e Prenotazione)
Route::middleware(['auth'])->group(function () {
    // ATTENZIONE: Questa riga comanda. Non ce ne devono essere altre con '/dashboard'
    Route::get('/dashboard', [HotelController::class, 'dashboard'])->name('dashboard');

    Route::post('/reserve', [HotelController::class, 'storeReservation'])->name('reserve');
    Route::put('/profile/update', [HotelController::class, 'updateProfile'])->name('profile.update');
});

// 4. ADMIN
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [HotelController::class, 'adminHome'])->name('admin.home');
    Route::get('/admin/users', [HotelController::class, 'adminUsers'])->name('admin.users');
    Route::post('/admin/hotel', [HotelController::class, 'storeHotel'])->name('admin.hotel.store');
    Route::delete('/admin/hotel/{id}', [HotelController::class, 'deleteHotel'])->name('admin.hotel.delete');
    // Rotte per la Modifica
    Route::get('/admin/hotel/{id}/edit', [HotelController::class, 'edit'])->name('admin.hotel.edit');
    Route::put('/admin/hotel/{id}', [HotelController::class, 'update'])->name('admin.hotel.update');
});
