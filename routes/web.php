<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierTypesController;
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


// Routes for Items
Route::get('/item-show', [ItemController::class,'itemShow'])->middleware(['auth', 'verified'])->name('item-show');
Route::get('/dropdown-item-types', [ItemController::class,'DropdownItemTypes'])->middleware(['auth', 'verified'])->name('dropdown-item-types');
Route::get('/item-table-data', [ItemController::class,'listItemData'])->middleware(['auth', 'verified'])->name('item-table-data');
Route::get('/add-item', [ItemController::class,'create'])->middleware(['auth', 'verified'])->name('add-item');
Route::get('/item/{id}/edit', [ItemController::class,'itemEdit'])->middleware(['auth', 'verified'])->name('edit-item');
Route::post('/store-item', [ItemController::class,'store'])->middleware(['auth', 'verified'])->name('store-item');
Route::post('/item-edit', [ItemController::class,'itemEdit'])->middleware(['auth', 'verified'])->name('item-edit');
Route::put('/item-update/{id}', [ItemController::class,'update'])->middleware(['auth', 'verified'])->name('item-update');
Route::delete('/item-table-delete/{id}', [ItemController::class, 'destroy'])->middleware(['auth', 'verified'])->name('item-table-delete');

// Routes for Item Types
Route::get('/item-types', [ItemTypeController::class,'index'])->middleware(['auth', 'verified'])->name('item-types');
Route::get('/item-types-table', [ItemTypeController::class,'listTable'])->middleware(['auth', 'verified'])->name('item-types-table');
Route::get('/add-item-types', [ItemTypeController::class,'create'])->middleware(['auth', 'verified'])->name('add-item-types');
Route::post('/add-item-types', [ItemTypeController::class,'store'])->middleware(['auth', 'verified'])->name('store-item-types');
Route::put('/item-types-table-update/{id}', [ItemTypeController::class,'update'])->middleware(['auth', 'verified'])->name('item-types-table-update');
Route::delete('/item-types-table-delete/{id}', [ItemTypeController::class, 'destroy'])->middleware(['auth', 'verified'])->name('item-types-table-delete');


// Routes for Supplier
Route::get('/dropdown-supplier-types', [SupplierController::class,'DropdownSupplierTypes'])->middleware(['auth', 'verified'])->name('dropdown-supplier-types');
Route::get('/supplier-table-data', [SupplierController::class,'supplierListJson'])->middleware(['auth', 'verified'])->name('supplier-table-data');
Route::get('/suppliers', [SupplierController::class,'index'])->middleware(['auth', 'verified'])->name('suppliers');
Route::get('/supplier/{id}/edit', [SupplierController::class,'edit'])->middleware(['auth', 'verified'])->name('supplier-item');
Route::get('/add-supplier', [SupplierController::class,'create'])->middleware(['auth', 'verified'])->name('add-supplier');
Route::post('/add-supplier', [SupplierController::class,'store'])->middleware(['auth', 'verified'])->name('store-supplier');
Route::put('/supplier-update/{id}', [SupplierController::class,'update'])->middleware(['auth', 'verified'])->name('supplier-update');
Route::delete('/supplier-table-delete/{id}', [SupplierController::class, 'destroy'])->middleware(['auth', 'verified'])->name('supplier-table-delete');


// Routes for SupplierTypes
Route::get('/supplier-types', function () {
    return Inertia::render('SupplierTypes/List');
})->middleware(['auth', 'verified'])->name('supplier-types');

Route::get('/suppliers-types', [SupplierTypesController::class,'index'])->middleware(['auth', 'verified'])->name('suppliers-types');
Route::get('/add-supplier-types', [SupplierTypesController::class,'create'])->middleware(['auth', 'verified'])->name('add-supplier-types');
Route::get('/supplier-types-table', [SupplierTypesController::class,'show'])->middleware(['auth', 'verified'])->name('supplier-types-table');
Route::get('/supplier-types/{id}/edit', [SupplierTypesController::class,'edit'])->middleware(['auth', 'verified'])->name('edit-supplier-types');
Route::post('/store-supplier-types', [SupplierTypesController::class,'store'])->middleware(['auth', 'verified'])->name('store-supplier-types');
Route::put('/supplier-type-update/{id}', [SupplierTypesController::class,'update'])->middleware(['auth', 'verified'])->name('supplier-type-update');
Route::delete('/supplier-types-table-delete/{id}', [SupplierTypesController::class, 'destroy'])->middleware(['auth', 'verified'])->name('supplier-types-table');

// Routes for Location
Route::get('/locations', function () {
    return Inertia::render('Locations/List');
})->middleware(['auth', 'verified'])->name('locations');

Route::get('/location-types', function () {
    return Inertia::render('LocationTypes/List');
})->middleware(['auth', 'verified'])->name('location-types');
