<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    // variable de sesión de un unico proposito
    // session()->flash('swal', [
    //     'title' => "Good job!",
    //     'text' => "You clicked the button!",
    //     'icon' => "success"
    // ]);

    return view('admin.dashboard');
})->name('admin.dashboard');