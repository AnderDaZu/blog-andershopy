<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        // $tags = Tag::all();
        // return $post->tags->pluck('id');
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
            'is_published' => 'required|boolean',
            'tags' => 'nullable|array',
            'image' => 'nullable|image',
        ]);

        $data = $request->all();

        $tags = [];

        foreach ($request->tags ?? [] as $name) {
            // firstOrCreate -> busca si hay algún registro en la db que coincida, de no existir lo crea
            $tag = Tag::firstOrCreate(['name' => $name]);
            $tags[] = $tag->id;
        }

        $post->tags()->sync($tags);

        if( $request->file('image') ) 
        {
            if ( $post->image_path ) Storage::delete($post->image_path);

            $file_name = $post->slug . '.' . $request->file('image')->getClientOriginalExtension();

            // put -> permite subir imagenes | puFileAs -> permite subir y definir el nombre de la imagen
            $data['image_path'] = Storage::putFileAs('posts', $request->image, $file_name);
        }

        $post->update( $data );

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
        $title = $post->title;

        $post->delete();

        session()->flash('swal', [
            'position' => "top-end",
            'icon' => "success",
            'title' => "¡Artículo \"$title\" ha sido eliminado!",
            'showConfirmButton' => false,
            'padding' => '1em',
            'timer' => 3000
        ]);

        return redirect()->route('admin.posts.index');
    }
}
