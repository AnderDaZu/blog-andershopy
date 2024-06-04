<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
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

        return redirect()->route('admin.categories.index')->with('info', 'Categoría actualizada con éxito');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('info', 'Categoría eliminada con éxito');
    }
}
