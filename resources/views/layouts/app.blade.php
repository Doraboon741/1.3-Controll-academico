<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Usuarios')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col">

    <nav class="bg-emerald-900 text-white shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('academic.index') }}" class="text-lg font-bold tracking-wide text-red-400">
                CONTROL ESCOLAR <span class="text-white font-normal">| Escuela De Perfección</span>
            </a>

            @auth
                <div class="flex items-center gap-4">
                    <div class="text-sm flex items-center gap-2">
                        <span class="text-slate-300">{{ auth()->user()->name }}</span>
                        <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full 
                            {{ auth()->user()->role === 'admin' ? 'bg-amber-400 text-slate-900' : 'bg-sky-500 text-white' }}">
                            {{ strtoupper(auth()->user()->role) }}
                        </span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" 
                            class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-medium px-3 py-1.5 rounded transition">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    <!-- Lo principal -->
    <main class="max-w-6xl w-full mx-auto px-4 py-8 flex-grow">
        
        <!-- Alertas extras -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-emerald-100 border border-emerald-300 text-emerald-800 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-lg bg-rose-100 border border-rose-300 text-rose-800 text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>