<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Registro Académico</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Editar Alumno y Calificación</h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('academic.update', $record) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700">Nombre completo</label>
                <input type="text" name="name" value="{{ old('name', $record->student->name) }}" required class="mt-1 w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                <input type="email" name="email" value="{{ old('email', $record->student->email) }}" required class="mt-1 w-full border rounded p-2">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Número de faltas</label>
                    <input type="number" name="absences" value="{{ old('absences', $record->absences) }}" min="0" max="100" required class="mt-1 w-full border rounded p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Calificación (0 - 10)</label>
                    <input type="number" step="0.1" name="grade" value="{{ old('grade', $record->grade) }}" min="0" max="10" required class="mt-1 w-full border rounded p-2">
                </div>
            </div>
            <div class="text-sm text-gray-600">
                Equivalencia actual: <x-equivalence-badge :equivalence="$record->equivalence" />
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <a href="{{ route('academic.index') }}" class="px-4 py-2 bg-gray-200 rounded text-sm">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm font-semibold">Actualizar</button>
            </div>
        </form>
    </div>
</body>
</html>