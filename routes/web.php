<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceiptController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SinglePOS Web Routes
|--------------------------------------------------------------------------
*/

// Guest redirect: login page or POS
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('pos');
    }
    return redirect()->route('login');
});

// Dashboard for admin
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role:admin'])->name('admin.dashboard');

/*
|--------------------------------------------------------------------------
| POS Routes (Cashier + Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,cashier'])->group(function () {
    Route::get('/pos', function () {
        return view('pos');
    })->name('pos');
});

/*
|--------------------------------------------------------------------------
| Receipt (Authenticated)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/receipt/{sale}', [ReceiptController::class, 'show'])->name('receipt.show');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/products', function () {
        return view('admin.products');
    })->name('products');

    Route::get('/categories', function () {
        return view('admin.categories');
    })->name('categories');

    Route::get('/sales', function () {
        return view('admin.sales');
    })->name('sales');

    Route::get('/shifts', function () {
        return view('admin.shifts');
    })->name('shifts');

    Route::get('/users', function () {
        return view('admin.users');
    })->name('users');
});

/*
|--------------------------------------------------------------------------
| Profile Routes (Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/jalankan-migrasi', function() {
    try {
        \Artisan::call('migrate:fresh', ['--seed' => true]);
        return 'Migrasi dan Seeding database berhasil!';
    } catch (\Exception $e) {
        return 'Gagal: ' . $e->getMessage();
    }
});

