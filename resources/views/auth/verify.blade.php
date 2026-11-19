<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Administrador</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Verificación en dos pasos</h2>
        <p class="text-sm text-gray-600 mb-6">
            Ingresa el código de 6 dígitos enviado a tu correo electrónico. Tienes <strong>5 minutos</strong> antes de que expire.
        </p>

        @if (session('status'))
            <div class="bg-blue-100 text-blue-800 p-3 rounded mb-4 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('verify.code') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Código de verificación</label>
                <input type="text" name="code" id="code" maxlength="6" required autofocus
                    placeholder="000000"
                    class="mt-1 block w-full text-center tracking-widest text-2xl font-mono border border-gray-300 rounded-md p-2.5 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2.5 rounded-md font-semibold hover:bg-blue-700 transition">
                Verificar y acceder
            </button>
        </form>
    </div>
</body>
</html>