@extends('layouts.app')

@section('title', 'Página no encontrada')

@section('content')
<section class="min-h-screen flex flex-col items-center justify-center bg-gray-900 text-white text-center">
    <h1 class="text-6xl font-bold mb-4">404</h1>
    <p class="text-xl mb-6">La página que buscas no existe o ha sido movida.</p>
    <a href="{{ route('home') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">
        Volver al inicio
    </a>
</section>
@endsection
