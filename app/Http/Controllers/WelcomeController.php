<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        $posts = Post::where('is_published', true)
            ->when(request('categories'), function($query){
                $query->whereIn('category_id', request('categories'));
            })
            ->when(request('order') ?? 'new', function($query, $order){
                $sort = $order === 'new' ? 'desc' : 'asc';
                $query->orderBy('published_at', $sort);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $categories = Category::all();

        return view('welcome', compact('posts', 'categories'));
    }
}
