@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-primary to-secondary bg-gray-900 rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold mb-2 text-white/90" >
                    ¡Bienvenido, {{ Auth::user()->name }}!
                </h3>
                <p class="text-white/90">
                    Este es tu panel de administración. Gestiona todo el contenido de tu landing page.
                </p>
            </div>
            <div class="hidden md:block">
                <svg class="w-24 h-24 text-white/20" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        @php
            $servicesCount = \App\Models\Service::count();
            $projectsCount = \App\Models\Project::count();
            $testimonialsCount = \App\Models\Testimonial::count();
            $galleryCount = \App\Models\GalleryImage::count();
        @endphp

        <!-- Servicios -->
        <x-admin.card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Servicios</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $servicesCount }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.services.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Gestionar →
                </a>
            </div>
        </x-admin.card>

        <!-- Proyectos -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Proyectos</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $projectsCount }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.projects.index') }}" class="text-sm text-green-600 hover:text-green-800 font-medium">
                    Gestionar →
                </a>
            </div>
        </div>

        <!-- Testimonios -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Testimonios</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $testimonialsCount }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.testimonials.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                    Gestionar →
                </a>
            </div>
        </div>

        <!-- Galería -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Galería</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $galleryCount }}</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.gallery.index') }}" class="text-sm text-orange-600 hover:text-orange-800 font-medium">
                    Gestionar →
                </a>
            </div>
        </div>
    </div>
    <!-- Leads (AGREGAR ESTO) -->
<div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600">Leads</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">
                @php
                    $leadsCount = \App\Models\Lead::count();
                @endphp
                {{ $leadsCount }}
            </p>
        </div>
        <div class="bg-indigo-100 p-3 rounded-full">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('admin.leads.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
            Gestionar →
        </a>
    </div>
    @php
        $unreadLeads = \App\Models\Lead::unread()->count();
    @endphp
    @if($unreadLeads > 0)
    <div class="mt-3 pt-3 border-t">
        <p class="text-sm text-red-600 font-semibold">
            🔴 {{ $unreadLeads }} sin leer
        </p>
    </div>
    @endif
</div>

<div class="bg-white shadow rounded-lg p-6 text-center hover:shadow-lg transition">
    <h3 class="text-gray-700 font-semibold text-lg mb-2">Productos</h3>
    <p class="text-3xl font-bold text-blue-600">{{ \App\Models\Product::count() }}</p>
    <a href="{{ route('admin.products.index') }}" class="mt-3 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        Gestionar
    </a>
</div>

div class="bg-white shadow rounded-lg p-6 text-center hover:shadow-lg transition">
    <h3 class="text-gray-700 font-semibold text-lg mb-2">Órdenes</h3>
    @php
        $ordersCount = \App\Models\Order::count();
        $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
    @endphp
    <p class="text-3xl font-bold text-purple-600">{{ $ordersCount }}</p>
    @if($pendingOrders > 0)
    <p class="text-sm text-orange-600 font-semibold mt-2">
        🔔 {{ $pendingOrders }} pendiente{{ $pendingOrders > 1 ? 's' : '' }}
    </p>
    @endif
    <a href="{{ route('admin.orders.index') }}" class="mt-3 inline-block bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
        Gestionar
    </a>
</div>

<!-- Pagos Pendientes (Daviplata) -->
<div class="bg-white shadow rounded-lg p-6 text-center hover:shadow-lg transition border-l-4 border-orange-500">
    <h3 class="text-gray-700 font-semibold text-lg mb-2">Pagos QR Daviplata</h3>
    @php
        $qrPending = \App\Models\Payment::where('payment_method', 'qr_payment')
                                        ->where('status', 'pending')
                                        ->count();
    @endphp
    <p class="text-3xl font-bold text-orange-600">{{ $qrPending }}</p>
    <p class="text-xs text-gray-500 mt-1">Por verificar</p>
    <a href="{{ route('admin.payments.pending') }}" class="mt-3 inline-block bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
        Verificar Pagos
    </a>
</div>


    <!-- Quick Actions & Info -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Acciones Rápidas -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Acciones Rápidas
            </h4>
            <div class="space-y-3">
                <a href="{{ route('admin.services.create') }}"
                   class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-blue-50 hover:border-blue-200 border-2 border-transparent transition group">
                    <div class="bg-blue-100 p-2 rounded-lg group-hover:bg-blue-200 transition">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <span class="ml-3 text-gray-700 font-medium">Agregar Servicio</span>
                </a>

                <a href="{{ route('admin.projects.create') }}"
                   class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-green-50 hover:border-green-200 border-2 border-transparent transition group">
                    <div class="bg-green-100 p-2 rounded-lg group-hover:bg-green-200 transition">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <span class="ml-3 text-gray-700 font-medium">Agregar Proyecto</span>
                </a>

                <a href="{{ route('admin.testimonials.create') }}"
                   class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-purple-50 hover:border-purple-200 border-2 border-transparent transition group">
                    <div class="bg-purple-100 p-2 rounded-lg group-hover:bg-purple-200 transition">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <span class="ml-3 text-gray-700 font-medium">Agregar Testimonio</span>
                </a>

                <a href="{{ route('admin.settings.index') }}"
                   class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 hover:border-gray-300 border-2 border-transparent transition group">
                    <div class="bg-gray-200 p-2 rounded-lg group-hover:bg-gray-300 transition">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="ml-3 text-gray-700 font-medium">Configuración General</span>
                </a>
            </div>
        </div>

        <!-- Sistema Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Información del Sistema
            </h4>
            <div class="space-y-3">
                <div class="flex justify-between items-center py-3 border-b">
                    <span class="text-sm text-gray-600">Laravel:</span>
                    <span class="font-semibold text-gray-800 bg-gray-100 px-3 py-1 rounded-full text-sm">
                        {{ app()->version() }}
                    </span>
                </div>
                <div class="flex justify-between items-center py-3 border-b">
                    <span class="text-sm text-gray-600">PHP:</span>
                    <span class="font-semibold text-gray-800 bg-gray-100 px-3 py-1 rounded-full text-sm">
                        {{ PHP_VERSION }}
                    </span>
                </div>
                <div class="flex justify-between items-center py-3 border-b">
                    <span class="text-sm text-gray-600">Entorno:</span>
                    <span class="px-3 py-1 text-xs rounded-full font-semibold
                        {{ config('app.env') === 'production' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ strtoupper(config('app.env')) }}
                    </span>
                </div>
                <div class="flex justify-between items-center py-3">
                    <span class="text-sm text-gray-600">Tu Rol:</span>
                    <span class="px-3 py-1 text-xs rounded-full bg-primary text-white font-semibold">
                        {{ strtoupper(Auth::user()->role) }}
                    </span>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t">
                <a href="{{ route('home') }}" target="_blank"
                   class="w-full bg-gradient-to-r from-primary to-secondary text-white px-4 py-3 rounded-lg font-semibold text-center block hover:shadow-lg transition">
                    Ver Sitio Web →
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
