<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array'
        ]);

        $role = Role::create([
            'name' => $request->name
        ]);

        $role->permissions()->sync($request->permissions);

        session()->flash('swal', [
            'position' => "top-end",
            'icon' => "success",
            'title' => "Rol ha sido creado!",
            'showConfirmButton' => false,
            'padding' => '1em',
            'timer' => 1500
        ]);

        return redirect()->route('admin.roles.edit', compact('role'));
    }

    public function show(Role $role)
    {
        //
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        // return $request->all();
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array'
        ]);

        $role->update([
            'name' => $request->name
        ]);

        $role->permissions()->sync($request->permissions);

        session()->flash('swal', [
            'position' => "top-end",
            'icon' => "success",
            'title' => "Rol ha sido actualizado!",
            'showConfirmButton' => false,
            'padding' => '1em',
            'timer' => 1500
        ]);

        return redirect()->route('admin.roles.edit', compact('role'));
    }

    public function destroy(Role $role)
    {
        $name = $role->name;
        $role->delete();
        session()->flash('swal', [
            'position' => "top-end",
            'icon' => "success",
            'title' => "¡Rol \"$name\" ha sido eliminado!",
            'showConfirmButton' => false,
            'padding' => '1em',
            'timer' => 1500
        ]);

        return redirect()->route('admin.roles.index');
    }
}
