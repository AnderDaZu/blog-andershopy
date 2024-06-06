<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest('id')->paginate(4);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|unique:posts,slug',
            'category_id' => 'required|exists:categories,id',
        ]);

        $user_id = auth()->id();

        $post = Post::create( $request->all() );

        session()->flash('swal', [
            'position' => "top-end",
            'icon' => "success",
            'title' => "¡Artículo ha sido creado!",
            'showConfirmButton' => false,
            'padding' => '1em',
            'timer' => 1500
        ]);

        return redirect()->route('admin.posts.edit', $post);
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        //
    }

    public function destroy(Post $post)
    {
        //
    }
}
