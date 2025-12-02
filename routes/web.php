<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\AdminController;       // <--- NUOVO
use App\Http\Controllers\ReservationController; // <--- NUOVO

// 1. HOME E DETTAGLI (Pubbliche)
Route::get('/', [HotelController::class, 'index'])->name('home');
Route::get('/hotel/{id}', [HotelController::class, 'show'])->name('hotel.show');

// 2. AUTH (Login/Register)
require __DIR__ . '/auth.php';

// 3. UTENTE LOGGATO (Dashboard e Prenotazioni)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HotelController::class, 'dashboard'])->name('dashboard');

    // Gestione Profilo
    Route::put('/profile/update', [HotelController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profile/destroy', [HotelController::class, 'destroyProfile'])->name('profile.destroy');

    // Gestione Prenotazioni (Spostate nel ReservationController)
    Route::post('/reserve', [ReservationController::class, 'store'])->name('reserve');
    Route::delete('/reservation/{id}/cancel', [ReservationController::class, 'destroy'])->name('reservation.cancel');
});

// 4. ADMIN
Route::middleware(['auth', 'is_admin'])->group(function () {
    // Dashboard Admin
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.home');

    // Gestione Hotel (CRUD)
    Route::post('/admin/hotel', [AdminController::class, 'storeHotel'])->name('admin.hotel.store');
    Route::get('/admin/hotel/{id}/edit', [AdminController::class, 'editHotel'])->name('admin.hotel.edit');
    Route::put('/admin/hotel/{id}', [AdminController::class, 'updateHotel'])->name('admin.hotel.update');
    Route::delete('/admin/hotel/{id}', [AdminController::class, 'destroyHotel'])->name('admin.hotel.delete');

    // Gestione Utenti
    Route::get('/admin/users', [AdminController::class, 'usersIndex'])->name('admin.users');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.delete');
});
