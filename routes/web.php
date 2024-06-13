<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;
use App\Models\Image;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('posts/{post}/image', [PostController::class, 'image'])->name('posts.image');

Route::post('images/upload', [ImageController::class, 'upload'])->name('images.upload');

// borrar imagenes
// Route::get('delete-images', function () {
//     $files = Storage::files('images');
//     $images = Image::pluck('path')->toArray();
//     Storage::delete(array_diff($files, $images));
// });