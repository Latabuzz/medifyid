<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriItemController;
use App\Http\Controllers\MasterItemsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/master-items/export-excel', [MasterItemsController::class, 'exportExcel'])->name('master-items.export-excel');
Route::get('/master-items', [MasterItemsController::class, 'index'])->name('master-items.index');
Route::get('/master-items/search', [MasterItemsController::class, 'search'])->name('master-items.search');
Route::get('/master-items/form/{method}/{id?}', [MasterItemsController::class, 'formView'])->name('master-items.form');
Route::post('/master-items/form/{method}/{id?}', [MasterItemsController::class, 'formSubmit'])->name('master-items.submit');

Route::get('/master-items/view/{kode}', [MasterItemsController::class, 'singleView'])->name('master-items.view');
Route::get('/master-items/delete/{id}', [MasterItemsController::class, 'delete'])->name('master-items.delete');

Route::get('/kategori-items/{kategoriItem}/pdf', [KategoriItemController::class, 'downloadPdf'])->name('kategori-items.pdf');
Route::resource('kategori-items', KategoriItemController::class)->parameters([
    'kategori-items' => 'kategoriItem',
]);

Route::get('/master-items/update-random-data', [MasterItemsController::class, 'updateRandomData']);
