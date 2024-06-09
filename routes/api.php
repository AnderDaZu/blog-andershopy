<?php

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
