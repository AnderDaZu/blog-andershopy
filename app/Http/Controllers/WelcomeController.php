<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        // return request()->all();
        $posts = Post::filter(request()->all())
        // $posts = Post::where('is_published', true) // este filtro se realiza desde el query scope global
            // los filtros que ejecuta filter() se definio en el módelo con el método scopeFilter
            // ->filter(request()->all())
            ->orderBy('id', 'desc')
            ->paginate(10);

        $categories = Category::all();

        return view('welcome', compact('posts', 'categories'));
    }
}
