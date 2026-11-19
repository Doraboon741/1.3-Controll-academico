<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        $users = Auth::user()->role === 'admin'
            ? User::withTrashed()->get()
            : User::all();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role'     => 'required|in:admin,empleado',
        ]);

        //Aqui la contraseña se encripta sola por el hash que puse anteriormente 
        User::create($data);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:admin,empleado',
            'password' => 'nullable|min:8',
        ]);

        // Aqui es para que si no se escribe la contraseña, no se ponga un valor nulo
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    // Aqui se implementa el soft delete, solo el admin
    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'No puedes deshabilitar tu propia cuenta.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario deshabilitado (Soft Delete).');
    }

    // Restaurar usuario deshabilitado, solo el admin
    public function restore($id)
    {
        User::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('users.index')->with('success', 'Usuario restaurado correctamente.');
    }

    // Eliminación permanente, solo el admin tmb
    public function forceDelete($id)
    {
        if (Auth::id() == $id) {
            return redirect()->route('users.index')->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        User::withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado permanentemente.');
    }
}
