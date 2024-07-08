<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;


abstract class Controller extends BaseController
{
    // A partir de laravel 11 toca aagregar manualmente este acceso
    use AuthorizesRequests;
}
