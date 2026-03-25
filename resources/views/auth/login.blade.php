<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-sm">

        <!-- Logo / Nombre -->
        @php $settings = \App\Models\Setting::getSettings(); @endphp
        <div class="text-center mb-6">
            @if($settings->getLogoUrl())
                <img src="{{ $settings->getLogoUrl() }}" alt="{{ $settings->site_name }}" class="h-16 mx-auto mb-3">
            @endif
            <h1 class="text-white text-2xl font-bold">{{ $settings->site_name }}</h1>
            @if($settings->site_slogan)
                <p class="text-gray-400 text-sm mt-1">{{ $settings->site_slogan }}</p>
            @endif
        </div>

        <!-- Card -->
        <div class="bg-gray-900 border border-gray-700 rounded-xl shadow-xl p-6">
            <h2 class="text-white text-lg font-semibold mb-4 text-center">Iniciar sesión</h2>

            <!-- Session Status -->
            @if(session('status'))
                <div class="mb-4 text-sm text-green-400 text-center">{{ session('status') }}</div>
            @endif

            <!-- Errores -->
            @if($errors->any())
                <div class="mb-4 text-sm text-red-400 text-center">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-3">
                @csrf

                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="Correo electrónico" required autofocus
                       class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-sm text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                <input type="password" name="password"
                       placeholder="Contraseña" required
                       class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-sm text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-400 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-600 text-blue-500">
                        Recordarme
                    </label>

                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-blue-400 hover:underline">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-medium transition">
                    Entrar
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="text-xs text-gray-500 hover:text-gray-300 transition">
                    ← Volver al inicio
                </a>
            </div>
        </div>
    </div>

</body>
</html>
