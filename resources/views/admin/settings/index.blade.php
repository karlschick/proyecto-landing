@extends('admin.layout')

@section('title', 'Configuración General')
@section('page-title', 'Configuración General')

@section('content')
<div class="bg-white rounded-lg shadow" x-data="{ activeTab: 'identity' }">

    <!-- Navigation Tabs -->
    @include('admin.settings.partials.tabs')

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT')

        <!-- Tab Content: Identidad -->
        @include('admin.settings.partials.identity')

        <!-- Tab Content: Colores -->
        @include('admin.settings.partials.colors')

        <!-- Tab Content: Secciones -->
        @include('admin.settings.partials.sections')

        <!-- Tab Content: Redes Sociales -->
        @include('admin.settings.partials.social')

        <!-- Tab Content: Contacto -->
        @include('admin.settings.partials.contact')

        <!-- Tab Content: Footer -->
        @include('admin.settings.partials.footer')

        <!-- Tab Content: SEO -->
        @include('admin.settings.partials.seo')

        <!-- Action Buttons -->
        @include('admin.settings.partials.actions')
    </form>
</div>
@endsection
