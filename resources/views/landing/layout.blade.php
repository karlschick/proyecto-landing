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
</body>
</html>
