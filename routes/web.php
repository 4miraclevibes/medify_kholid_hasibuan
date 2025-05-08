<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MasterItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Models\Supplier;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/suppliers', function () {
    $items = Supplier::all();
    return view('pages.backend.suppliers.index', compact('items'));
})->middleware(['auth', 'verified'])->name('suppliers.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Master Item
    Route::resource('master-items', MasterItemController::class);
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
});

require __DIR__.'/auth.php';
