<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Models\Document;
use App\Models\Category;
use App\Models\Department;
use App\Models\Tag;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuditController;

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
    return redirect('/login'); // arahkan ke login jika belum login
});

// Semua route penting dibungkus dalam middleware 'auth'
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/kategori', [CategoryController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/{category}', [CategoryController::class, 'show'])->name('kategori.show');

    Route::get('/pengguna', [UserController::class, 'index'])->name('pengguna.index');
    Route::get('/pengguna/{user}/edit', [UserController::class, 'edit'])->name('pengguna.edit');
    Route::put('/pengguna/{user}', [UserController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{user}', [UserController::class, 'destroy'])->name('pengguna.destroy');

    Route::get('/arsip', function () {
        return view('arsip');
    });

    Route::get('/pengaturan', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/pengaturan', [SettingController::class, 'update'])->name('settings.update');

    Route::get('/audit', function () {
        return view('audit');
    });
    Route::get('/audit-logs', [AuditController::class, 'showAuditLogs'])->name('audit.logs');

    Route::get('/upload', [DocumentsController::class, 'create'])->name('documents.create');
    Route::post('/upload', [DocumentsController::class, 'store'])->name('documents.store');

    Route::get('/documents', [DocumentsController::class, 'index'])->name('documents.index');
    Route::get('/documents/{document}/edit', [DocumentsController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{document}', [DocumentsController::class, 'update'])->name('documents.update');

    Route::get('/documents/file/{filename}', [DocumentsController::class, 'getFile'])->where('filename', '.*')->name('documents.file');
    Route::get('/documents/download/{filename}', [DocumentsController::class, 'download'])->name('documents.download'); 
    Route::get('/documents/preview/{filename}', [DocumentsController::class, 'previewExcel'])->where('filename', '.*')->name('documents.preview.excel');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');

    Route::get('/api/chart-data/category-documents', [LaporanController::class, 'getCategoryDocumentsChartData']);
    Route::get('/api/chart-data/department-documents', [LaporanController::class, 'chartDepartment']);
});

require __DIR__.'/auth.php';