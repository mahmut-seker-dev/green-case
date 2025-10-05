<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Guest Routes (Login sayfası)
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

/*
|--------------------------------------------------------------------------
| Protected Routes (Login gerekli)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | 🧾 MÜŞTERİ İŞLEMLERİ
    |--------------------------------------------------------------------------
    */
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/data', [CustomerController::class, 'data'])->name('customers.data');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // ♻️ Silinen Müşteriler
    Route::get('/trash/customers', [TrashController::class, 'customers'])->name('trash.customers');
    Route::get('/trash/customers/data', [TrashController::class, 'dataCustomers'])->name('trash.customers.data');

    // ♻️ Silinen Kullanıcılar
    Route::get('/trash/users', [TrashController::class, 'users'])->name('trash.users');
    Route::get('/trash/users/data', [TrashController::class, 'dataUsers'])->name('trash.users.data');

    // ♻️ Ortak işlemler
    Route::post('/trash/{type}/{id}/restore', [TrashController::class, 'restore'])->name('trash.restore');
    Route::delete('/trash/{type}/{id}/force-delete', [TrashController::class, 'forceDelete'])->name('trash.forceDelete');

    /*
    |--------------------------------------------------------------------------
    | 👤 KULLANICI İŞLEMLERİ
    |--------------------------------------------------------------------------
    */
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/data', [UsersController::class, 'data'])->name('users.data');

    Route::middleware(['can:manage-users'])->group(function () {
        Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
        Route::post('/users', [UsersController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | 👤 PROFİL
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    /*
    |--------------------------------------------------------------------------
    | 🚪 ÇIKIŞ
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Default Route
|--------------------------------------------------------------------------
*/
Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
