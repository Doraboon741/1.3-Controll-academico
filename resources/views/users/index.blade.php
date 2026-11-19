@extends('layouts.app')

@section('title', 'Listado de Usuarios')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Usuarios Registrados</h1>
        <a href="{{ route('users.create') }}" 
           class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow-sm transition">
            Nuevo Usuario
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500 font-semibold">
                    <th class="py-3 px-4">ID</th>
                    <th class="py-3 px-4">Nombre</th>
                    <th class="py-3 px-4">Correo</th>
                    <th class="py-3 px-4">Rol</th>
                    <th class="py-3 px-4">Estado</th>
                    <th class="py-3 px-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 text-sm">
                @foreach($users as $user)
                    <tr class="{{ $user->trashed() ? 'bg-rose-50/50 text-slate-400' : 'hover:bg-slate-50' }} transition">
                        <td class="py-3 px-4">{{ $user->id }}</td>
                        <td class="py-3 px-4 font-medium {{ $user->trashed() ? 'line-through' : 'text-slate-800' }}">
                            {{ $user->name }}
                        </td>
                        <td class="py-3 px-4">{{ $user->email }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 text-xs font-medium rounded bg-slate-200 text-slate-700">
                                {{ strtoupper($user->role) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            @if($user->trashed())
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-rose-100 text-rose-700">
                                    Deshabilitado
                                </span>
                            @else
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700">
                                    Activo
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 flex justify-end items-center gap-3">
                            @if(!$user->trashed())
                                <a href="{{ route('users.show', $user) }}" class="text-sky-600 hover:underline">Ver</a>
                                <a href="{{ route('users.edit', $user) }}" class="text-amber-600 hover:underline">Editar</a>

                                {{-- Opciones exclusivas de Administrador para usuarios activos --}}
                                @if(auth()->user()->role === 'admin' && auth()->id() !== $user->id)
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-orange-600 hover:underline">
                                            Deshabilitar
                                        </button>
                                    </form>

                                    <form action="{{ route('users.forceDelete', $user->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('¿Eliminar definitivamente de la base de datos? Esta acción no se puede deshacer.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:underline font-medium">
                                            Eliminar
                                        </button>
                                    </form>
                                @endif
                            @else
                                {{-- Opciones exclusivas de Administrador para usuarios con Soft Delete --}}
                                @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('users.restore', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-emerald-600 hover:underline font-medium">
                                            Restaurar
                                        </button>
                                    </form>

                                    <form action="{{ route('users.forceDelete', $user->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('¿Eliminar definitivamente de la base de datos?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:underline font-medium">
                                            Borrar Permanente
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection