<?php

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/tags', function (Request $request) {
    $term = $request->term ?? '';
    return Tag::select('name')
        ->where('name', 'like', "%$term%")
        ->limit(10)
        ->get()->map(function ($tag) {
            return [
                'id' => $tag->name,
                'text' => $tag->name
            ];
        });
})->name('api.tags.index');

// Archivos y directorios
Route::get('/files', function (Request $request) {
    // método para obtener todos los archivos del directorio especificado
    // Storage::files('posts'); // public/storage/posts
    // método para obtener todos los archivos del directorio y subdirectorios del directorio especificado 
    // Storage::allFiles('posts'); // public/storage/posts
    // metodo para obtener todos los directorios del directorio especificado
    // Storage::directories('posts');
    // metodo para obtener todos los directorios del directorio y subdirectorios del directorio especificado
    // Storage::allDirectories('posts');
})->name('api.files.index');
