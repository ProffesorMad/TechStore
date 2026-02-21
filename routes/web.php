<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| API
|--------------------------------------------------------------------------
*/

Route::get('/api/products', [ProductController::class, 'index']);
Route::get('/api/products/{id}', [ProductController::class, 'show']);

Route::post('/api/orders', [OrderController::class, 'store']);
Route::get('/api/orders', [OrderController::class, 'index']);
Route::get('/api/orders/{id}', [OrderController::class, 'show']);

Route::get('/api/admin/orders', [OrderController::class, 'adminIndex'])
    ->middleware(['auth', 'admin']);

Route::put('/api/admin/orders/{id}', [OrderController::class, 'updateStatus'])
    ->middleware(['auth', 'admin']);

/*
|--------------------------------------------------------------------------
| Laravel Auth
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| SPA Catch-All
|--------------------------------------------------------------------------
*/

Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!api|dashboard|profile|login|register).*$');
