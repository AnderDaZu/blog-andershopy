<?php

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/tags', function (Request $request) {
    $term = $request->term ?? '';
    return Tag::select('id', 'name as text')
        ->where('name', 'like', "%$term%")
        ->limit(10)
        ->get();
})->name('api.tags.index');