<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    // A partir de laravel 11 toca aagregar manualmente este acceso
    use AuthorizesRequests;
}
