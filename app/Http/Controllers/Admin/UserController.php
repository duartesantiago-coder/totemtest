<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id')->get();
        return view('admin.users.index', compact('users'));
    }

    public function toggleEditor(User $user)
    {
        $user->is_editor = ! $user->is_editor;
        $user->save();
        return redirect()->back()->with('success', 'Permiso de editor actualizado.');
    }

    public function toggleAdmin(User $user)
    {
        // Evitar que un admin se remueva a si mismo
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'No puedes cambiar tu propio estado de administrador.');
        }

        $user->is_admin = ! $user->is_admin;
        $user->save();
        return redirect()->back()->with('success', 'Permiso de administrador actualizado.');
    }
}
