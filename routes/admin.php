<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    // variable de sesión de un unico proposito
    // session()->flash('swal', [
    //     'title' => "Good job!",
    //     'text' => "You clicked the button!",
    //     'icon' => "success"
    // ]);

    return view('admin.dashboard');
})->name('dashboard')
->middleware('can:Acceso al dashboard');

// si donde registramos este archivo de rutas agregamos el name('admin.'), ya no es necesario agregar acá ->names('categories')
Route::resource('/categories', CategoryController::class)
->except('show')
->middleware('can:Gestión de categorías');

Route::resource('/posts', PostController::class)
->except('show')
->middleware('can:Gestión de artículos');

Route::resource('/roles', RoleController::class)
->except('show')
->middleware('can:Gestión de roles');

Route::resource('/permissions', PermissionController::class)
->except('show')
->middleware('can:Gestión de permisos');

Route::resource('/users', UserController::class)
    ->except('create', 'store', 'show');
// ->middleware('can:Gestión de usuarios'); // se agrego en el controlador