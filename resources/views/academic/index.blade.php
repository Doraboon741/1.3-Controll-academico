<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Académico - UTT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-5xl mx-auto bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center border-b pb-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Control Académico</h1>
                <p class="text-sm text-gray-500">
                    Usuario: <strong>{{ auth()->user()->name }}</strong> ({{ ucfirst(auth()->user()->role) }})
                </p>
            </div>
            <div class="flex gap-3">
                @if(auth()->user()->role === 'profesor')
                    <a href="{{ route('academic.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded text-sm font-semibold hover:bg-blue-700">
                        + Registrar Alumno
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-300">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-sm">{{ session('success') }}</div>
        @endif

        @if(auth()->user()->role === 'profesor')
            <div class="flex flex-wrap items-center gap-2 mb-4 text-sm">
                <span class="font-semibold text-gray-600">Ordenar por:</span>
                @php
                    $nextDir = $direction === 'asc' ? 'desc' : 'asc';
                @endphp
                <a href="{{ route('academic.index', ['sort' => 'name', 'direction' => $sort === 'name' ? $nextDir : 'asc']) }}"
                   class="px-3 py-1 rounded border {{ $sort === 'name' ? 'bg-blue-50 border-blue-400 text-blue-700 font-semibold' : 'bg-gray-50' }}">
                    Nombre {{ $sort === 'name' ? ($direction === 'asc' ? '↑' : '↓') : '' }}
                </a>
                <a href="{{ route('academic.index', ['sort' => 'grade', 'direction' => $sort === 'grade' ? $nextDir : 'desc']) }}"
                   class="px-3 py-1 rounded border {{ $sort === 'grade' ? 'bg-blue-50 border-blue-400 text-blue-700 font-semibold' : 'bg-gray-50' }}">
                    Calificación {{ $sort === 'grade' ? ($direction === 'asc' ? '↑' : '↓') : '' }}
                </a>
                <a href="{{ route('academic.index', ['sort' => 'absences', 'direction' => $sort === 'absences' ? $nextDir : 'desc']) }}"
                   class="px-3 py-1 rounded border {{ $sort === 'absences' ? 'bg-blue-50 border-blue-400 text-blue-700 font-semibold' : 'bg-gray-50' }}">
                    Faltas {{ $sort === 'absences' ? ($direction === 'asc' ? '↑' : '↓') : '' }}
                </a>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b text-gray-600 text-sm uppercase">
                        <th class="p-3">Nombre del Alumno</th>
                        <th class="p-3 text-center">Número de Faltas</th>
                        <th class="p-3 text-center">Calificación</th>
                        <th class="p-3 text-center">Equivalencia</th>
                        @if(auth()->user()->role === 'profesor')
                            <th class="p-3 text-right">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y text-sm">
                    @forelse($records as $record)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-medium text-gray-800">
                                {{ $record->student->name }}
                                <span class="block text-xs text-gray-400">{{ $record->student->email }}</span>
                            </td>
                            <td class="p-3 text-center">{{ $record->absences }}</td>
                            <td class="p-3 text-center font-semibold">{{ number_format($record->grade, 1) }}</td>
                            <td class="p-3 text-center">
                                <x-equivalence-badge :equivalence="$record->equivalence" />
                            </td>
                            @if(auth()->user()->role === 'profesor')
                                <td class="p-3 text-right space-x-2">
                                    <a href="{{ route('academic.edit', $record) }}" class="text-blue-600 hover:underline font-medium">Editar</a>
                                    <form action="{{ route('academic.destroy', $record) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este alumno?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline font-medium">Eliminar</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">No hay registros académicos disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>