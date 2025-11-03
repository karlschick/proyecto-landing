<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Título dinámico desde settings -->
    <title>@yield('title', 'Inicio') - {{ $settings->site_name ?? config('app.name') }}</title>

    <!-- SEO Meta Tags dinámicos -->
    <meta name="description" content="@yield('description', $settings->meta_description ?? 'Descripción de tu landing page')">
    <meta name="keywords" content="@yield('keywords', $settings->meta_keywords ?? 'landing, page, servicios')">
    <meta name="author" content="{{ $settings->site_name ?? config('app.name') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Inicio') - {{ $settings->site_name ?? config('app.name') }}">
    <meta property="og:description" content="@yield('description', $settings->meta_description ?? 'Descripción de tu landing page')">
    <meta property="og:image" content="@yield('og_image', $settings->getLogoUrl())">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Inicio') - {{ $settings->site_name ?? config('app.name') }}">
    <meta property="twitter:description" content="@yield('description', $settings->meta_description ?? 'Descripción de tu landing page')">
    <meta property="twitter:image" content="@yield('og_image', $settings->getLogoUrl())">

    <!-- Favicon dinámico -->
    @if($settings->favicon)
        <link rel="icon" type="image/x-icon" href="{{ $settings->getFaviconUrl() }}?v={{ time() }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ $settings->getFaviconUrl() }}?v={{ time() }}">
        <link rel="apple-touch-icon" href="{{ $settings->getFaviconUrl() }}?v={{ time() }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v={{ time() }}">
    @endif

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Colores Dinámicos -->
    <style>
        :root {
            --color-primary: {{ $settings->primary_color ?? '#3B82F6' }};
            --color-secondary: {{ $settings->secondary_color ?? '#8B5CF6' }};
            --color-accent: {{ $settings->accent_color ?? '#10B981' }};
        }

        /* Aplicar colores primarios */
        .bg-primary {
            background-color: var(--color-primary) !important;
        }

        .text-primary {
            color: var(--color-primary) !important;
        }

        .border-primary {
            border-color: var(--color-primary) !important;
        }

        /* Aplicar colores secundarios */
        .bg-secondary {
            background-color: var(--color-secondary) !important;
        }

        .text-secondary {
            color: var(--color-secondary) !important;
        }

        /* Aplicar colores de acento */
        .bg-accent {
            background-color: var(--color-accent) !important;
        }

        .text-accent {
            color: var(--color-accent) !important;
        }

        /* Botones primarios */
        .btn-primary {
            background-color: var(--color-primary) !important;
            color: white !important;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        /* Hero con gradiente dinámico */
        .hero-gradient {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
        }

        /* Links y elementos interactivos */
        a.link-primary {
            color: var(--color-primary) !important;
        }

        a.link-primary:hover {
            opacity: 0.8;
        }

        /* Tarjetas con hover de color primario */
        .card-hover:hover {
            border-color: var(--color-primary) !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Iconos y badges */
        .badge-primary {
            background-color: var(--color-primary) !important;
            color: white !important;
        }

        /* Override de Tailwind para botones azules por defecto */
        .bg-blue-600 {
            background-color: var(--color-primary) !important;
        }

        .bg-blue-600:hover, .hover\:bg-blue-700:hover {
            background-color: var(--color-primary) !important;
            opacity: 0.9;
        }

        .text-blue-600 {
            color: var(--color-primary) !important;
        }

        .border-blue-600 {
            border-color: var(--color-primary) !important;
        }

        /* Hover states */
        .hover\:text-blue-700:hover,
        .hover\:text-blue-800:hover {
            color: var(--color-primary) !important;
            opacity: 0.8;
        }

        /* Focus states para inputs */
        input:focus, textarea:focus, select:focus {
            border-color: var(--color-primary) !important;
            ring-color: var(--color-primary) !important;
        }

        .focus\:ring-blue-500:focus {
            --tw-ring-color: var(--color-primary) !important;
        }

        .focus\:border-blue-500:focus {
            border-color: var(--color-primary) !important;
        }
    </style>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Analytics (si está configurado) -->
    @if(!empty($settings->google_analytics_id))
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->google_analytics_id }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $settings->google_analytics_id }}');
    </script>
    @endif

    <!-- Facebook Pixel (si está configurado) -->
    @if(!empty($settings->facebook_pixel_id))
    <!-- Meta Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $settings->facebook_pixel_id }}');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
             src="https://www.facebook.com/tr?id={{ $settings->facebook_pixel_id }}&ev=PageView&noscript=1"/>
    </noscript>
    <!-- End Meta Pixel Code -->
    @endif

    @stack('styles')
</head>
