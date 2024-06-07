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
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        // return $request->all();
        $request->validate([
            'title' => 'required|string|max:255',
            // 'slug' => 'required|unique:posts,slug,' . $post->id,
            'category_id' => 'required|exists:categories,id',
            'excerpt' => $request['is_published'] ? 'required' : 'nullable',
            'body' => $request['is_published'] ? 'required' : 'nullable',
            'is_published' => 'required|boolean'
        ]);

        $post->update( $request->all() );

        session()->flash('swal', [
            'position' => "top-end",
            'icon' => "success",
            'title' => "¡Artículo ha sido actualizado!",
            'showConfirmButton' => false,
            'padding' => '1em',
            'timer' => 1500
        ]);

        return redirect()->route('admin.posts.edit', $post);
    }

    public function destroy(Post $post)
    {
        //
    }
}
