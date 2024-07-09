<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        $posts = Post::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('welcome', compact('posts'));
    }
}
