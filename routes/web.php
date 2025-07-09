<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', function () {
    $totalDocuments = App\Models\Document::count();
    $totalCategories = App\Models\Category::count();
    $totalTags = App\Models\Tag::count();
    return view('home', compact('totalDocuments', 'totalCategories', 'totalTags'));
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('welcome');
});

Route::resource('categories', App\Http\Controllers\CategoryController::class);

// Document management routes
Route::resource('documents', App\Http\Controllers\DocumentController::class);

// Removed duplicate /home route
Route::get('/home', function () {
    return view('home');
});