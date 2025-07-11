<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use App\Models\Document;
use App\Models\Category;
use App\Models\Department;
use App\Models\Tag;
use App\Http\Controllers\DocumentsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

// Route::get('/documents', function () {
//     return view('documents/documents');
// });

Route::get('/laporan', function () {
    return view('laporan');
});

/*
*/

Route::get('/kategori', [CategoryController::class, 'index'])->name('kategori.index');
Route::get('/kategori/{category}', [CategoryController::class, 'show'])->name('kategori.show');

Route::get('/pengguna', function () {
    return view('pengguna');
});

Route::get('/arsip', function () {
    return view('arsip');
});

Route::get('/upload', [DocumentsController::class, 'create'])->name('documents.create');
Route::post('/upload', [DocumentsController::class, 'store'])->name('documents.store');

Route::get('/documents', [DocumentsController::class, 'index'])->name('documents.index');

Route::get('/documents/{document}/edit', [DocumentsController::class, 'edit'])->name('documents.edit');
Route::put('/documents/{document}', [DocumentsController::class, 'update'])->name('documents.update');

Route::get('/documents/file/{filename}', [DocumentsController::class, 'getFile'])->where('filename', '.*')->name('documents.file');
