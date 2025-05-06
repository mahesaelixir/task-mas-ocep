<?php

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;
use App\Exports\ProdukExport;
use App\Imports\ProdukImport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('welcome');
});
// ProdukController
Route::get('/produk', [ProdukController::class, 'index'])->name('index');
Route::get('/create', [ProdukController::class,'kategori'])->name('kategori');
Route::post('/create', [ProdukController::class,'store'])->name('store');
Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('edit');
Route::put('/produk/{produk}/update', [ProdukController::class, 'update'])->name('update');
Route::delete('/produk/{produk}/delete', [ProdukController::class, 'destroy'])->name('delete');
Route::post('/produk/import', [ProdukController::class, 'import'])->name('import');
Route::get('/produk/export', [ProdukController::class, 'export'])->name('export');

// KategoriController
Route::get('/kategori', [KategoriController::class,'view'])->name('kt');
Route::get('/kategori/data', [KategoriController::class,'index'])->name('kd');
Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('ke');
Route::put('/kategori/{id}/update', [KategoriController::class, 'update'])->name('ku');
Route::delete('/kategori/{id}/delete', [KategoriController::class, 'destroy'])->name('kdel');
Route::get('/ck', [KategoriController::class,'create'])->name('ck');
Route::post('/ck', [KategoriController::class,'store'])->name('sk');

// DetailsController
Route::get('/details', [DetailsController::class,'index'])->name('dp');
Route::get('/cd', [DetailsController::class,'create'])->name('cd');
Route::post('/cd', [DetailsController::class,'store'])->name('sd');
Route::get('/details/data', [DetailsController::class, 'getData'])->name('details.data');
Route::get('/details/{id}/edit', [DetailsController::class, 'edit'])->name('details.edit');
Route::put('/details/{id}/update', [DetailsController::class, 'update'])->name('details.update');
Route::delete('/details/{id}/delete', [DetailsController::class, 'destroy'])->name('details.delete');

// Dashboard Controller
Route::get('/dashboard', [DashboardController::class,'dashboard'])->name('dashboard');

Auth::routes();

// Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
