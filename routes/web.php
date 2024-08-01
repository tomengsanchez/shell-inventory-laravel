<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\SupplierController;
use App\Models\ItemType;
use App\Models\Supplier;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile',[ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



Route::get('/product-tracker', function () {
    return Inertia::render('ProductTracker/List');
})->middleware(['auth', 'verified'])->name('product-tracker');

Route::get('/items', function () {
    return Inertia::render('Items/List');
})->middleware(['auth', 'verified'])->name('items');

Route::get('/item-types', [ItemTypeController::class,'index'])->middleware(['auth', 'verified'])->name('item-types');
Route::get('/item-types-table', [ItemTypeController::class,'list_table'])->middleware(['auth', 'verified'])->name('item-types-table');
Route::get('/add-item-types', [ItemTypeController::class,'create'])->middleware(['auth', 'verified'])->name('add-item-types');
Route::post('/add-item-types', [ItemTypeController::class,'store'])->middleware(['auth', 'verified'])->name('store-item-types');


Route::post('/item-types-table-update/{id}', [ItemTypeController::class,'update'])->middleware(['auth', 'verified'])->name('item-types-table-update');
Route::delete('/item-types/{id}', [ItemTypeController::class, 'destroy']);

Route::get('/suppliers', [SupplierController::class,'index'])->middleware(['auth', 'verified'])->name('suppliers');

Route::get('/add-supplier', [SupplierController::class,'create'])->middleware(['auth', 'verified'])->name('add-supplier');
Route::get('/suppliers-resource', [SupplierController::class,'supplierListJson'])->middleware(['auth', 'verified'])->name('add-supplier');
Route::post('/add-supplier', [SupplierController::class,'store'])->middleware(['auth', 'verified'])->name('store-supplier');


Route::get('/locations', function () {
    return Inertia::render('Locations/List');
})->middleware(['auth', 'verified'])->name('locations');

Route::get('/location-types', function () {
    return Inertia::render('LocationTypes/List');
})->middleware(['auth', 'verified'])->name('location-types');
