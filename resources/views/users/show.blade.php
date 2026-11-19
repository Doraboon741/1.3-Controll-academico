@extends('layouts.app')

@section('title', 'Detalles del Usuario')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-xl shadow-sm border border-slate-200">
    <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
        <h2 class="text-xl font-bold text-slate-800">Detalles del Usuario</h2>
        <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-slate-200 text-slate-700">
            ID #{{ $user->id }}
        </span>
    </div>

    <dl class="space-y-4 text-sm">
        <div class="flex justify-between">
            <dt class="text-slate-500 font-medium">Nombre:</dt>
            <dd class="text-slate-800 font-semibold">{{ $user->name }}</dd>
        </div>

        <div class="flex justify-between">
            <dt class="text-slate-500 font-medium">Correo electrónico:</dt>
            <dd class="text-slate-800">{{ $user->email }}</dd>
        </div>

        <div class="flex justify-between">
            <dt class="text-slate-500 font-medium">Rol asignado:</dt>
            <dd class="text-slate-800 uppercase">{{ $user->role }}</dd>
        </div>

        <div class="flex justify-between">
            <dt class="text-slate-500 font-medium">Fecha de registro:</dt>
            <dd class="text-slate-800">{{ $user->created_at->format('d/m/Y H:i') }}</dd>
        </div>
    </dl>

    <div class="mt-8 pt-4 border-t border-slate-100 flex justify-between items-center">
        <a href="{{ route('users.index') }}" class="text-sm text-slate-600 hover:underline">← Volver al listado</a>
        <a href="{{ route('users.edit', $user) }}" class="bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            Editar Usuario
        </a>
    </div>
</div>
@endsection