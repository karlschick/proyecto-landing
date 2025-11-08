<!DOCTYPE html>
<html lang="es">
@include('landing.head')

<body class="bg-gray-50">

    @include('landing.navbar')

    <main>
        @yield('content')
    </main>

    @include('landing.footer')

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
