<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $order = 'desc';
        $categories = [];

        if( $request->order ) $order = ( $request->order == 'new' ) ? 'desc' : 'asc';

        $posts = Post::where('is_published', true)
            ->orderBy('published_at', $order)
            ->orderBy('id', 'desc')
            ->paginate(10);

        $categories = Category::all();

        return view('welcome', compact('posts', 'categories'));
    }
}
