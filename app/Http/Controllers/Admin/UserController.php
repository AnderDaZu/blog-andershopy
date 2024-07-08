<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,{$user->id}",
            'password' => 'nullable|string|min:8|max:255|confirmed',
            'roles' => 'nullable|array',
        ]);

        if ($request->password ) 
        {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

        } else {
            $user->update($request->only(['name', 'email']));
        }
        
        if( count($request->roles) )
        {
            $user->roles()->sync($request->roles);
        }

        session()->flash('swal', [
            'position' => "top-end",
            'icon' => "success",
            'title' => "Usuario \"$user->name\" ha sido actualizado!",
            'showConfirmButton' => false,
            'padding' => '1em',
            'timer' => 1500
        ]);

        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user)
    {
        //
    }
}
