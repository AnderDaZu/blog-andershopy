<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('id', 'desc')->paginate(10);
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $permission = Permission::create($request->all());

        session()->flash('swal', [
            'position' => "top-end",
            'icon' => "success",
            'title' => "¡Permiso \"$permission->name\" ha sido creado!",
            'showConfirmButton' => false,
            'padding' => '1em',
            'timer' => 1500
        ]);
        
        return redirect()->route('admin.permissions.edit', compact('permission'));
    }

    public function show( Permission $permission )
    {
        //
    }

    public function edit( Permission $permission )
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request,  Permission $permission )
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update($request->all());

        session()->flash('swal', [
            'position' => "top-end",
            'icon' => "success",
            'title' => "¡Permiso \"$permission->name\" ha sido actualizado!",
            'showConfirmButton' => false,
            'padding' => '1em',
            'timer' => 1500
        ]);

        return redirect()->route('admin.permissions.edit', compact('permission'));
    }

    public function destroy( Permission $permission )
    {
        $name = $permission->name;

        $permission->delete();

        session()->flash('swal', [
            'position' => "top-end",
            'icon' => "success",
            'title' => "¡Permiso \"$name\" ha sido eliminado!",
            'showConfirmButton' => false,
            'padding' => '1em',
            'timer' => 1500
        ]);

        return redirect()->route('admin.permissions.index');
    }
}
