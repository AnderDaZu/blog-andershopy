<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest('id')->paginate(7);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($request->all());

        session()->flash('swal', [
            'position' => "top-end",
            'icon' => "success",
            'title' => "¡Categoría ha sido creada!",
            'showConfirmButton' => false,
            'padding' => '1em',
            'timer' => 1500
        ]);

        return redirect()->route('admin.categories.index');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
        ]);

        session()->flash('swal', [
            'position' => "top-end",
            'icon' => "success",
            'title' => "¡Categoría ha sido actualizada!",
            'showConfirmButton' => false,
            'padding' => '1em',
            'timer' => 1500
        ]);
        
        $category->update($request->all());

        return redirect()->route('admin.categories.index');
    }

    public function destroy(Category $category)
    {
        // si la categoría tiene posts asociados no se puede eliminar
        // $posts = Post::where('category_id', $category->id)->exists();
        // if ( $posts ) {
        if ( $category->posts->count() > 0 ) {
            session()->flash('swal', [
                'position' => "top-end",
                'icon' => "error",
                'title' => "¡No se puede eliminar la categoría \"$category->name\" porque tiene posts asociados!",
                'showConfirmButton' => false,
                'padding' => '1em',
                'timer' => 4000
            ]);

            return redirect()->route('admin.categories.index');
        }

        $name = $category->name;

        $category->delete();

        session()->flash('swal', [
            'position' => "top-end",
            'icon' => "success",
            'title' => "¡Categoría \"$name\" ha sido eliminada!",
            'showConfirmButton' => false,
            'padding' => '1em',
            'timer' => 2000
        ]);

        return redirect()->route('admin.categories.index');
    }
}
