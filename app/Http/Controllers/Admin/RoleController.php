<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        $role = Role::create([
            'name' => $request->name
        ]);

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
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        //
    }

    public function destroy(Role $role)
    {
        //
    }
}
