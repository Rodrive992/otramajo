<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/site.webmanifest') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"> {{-- fallback opcional --}}

    <title>@yield('title', 'OtraMajo')</title>

    {{-- Tailwind rápido (CDN). Luego se puede migrar a Vite si querés. --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Paleta y utilidades globales --}}
    <style>
        :root{
            --om-blanco: #FAF9F6;  /* blanco cálido */
            --om-salvia: #A8C3A0;  /* verde salvia */
            --om-rosa:   #E9C7C1;  /* rosa empolvado */
            --om-gris:   #D3D3D3;  /* gris piedra claro */
            --om-arena:  #F4E1A1;  /* arena dorada */
            --om-carbon: #4A4A4A;  /* gris carbón suave */
        }
        html, body { background: var(--om-blanco); color: var(--om-carbon); }
        /* Correcciones de enfoque/acentos en botones y links */
        a:focus-visible, button:focus-visible {
            outline: 2px dashed var(--om-salvia);
            outline-offset: 2px;
        }
    </style>

    {{-- Hook para estilos extra por vista --}}
    @stack('styles')
</head>
<body class="min-h-full antialiased selection:bg-[#F4E1A1] selection:text-[#4A4A4A]">

    {{-- 
        Los partials de top y bottom se incluyen desde cada vista.
        Si preferís, podemos moverlos acá y que solo hagas @yield('content').
    --}}

    <div id="app" class="min-h-full">
        @yield('content')
    </div>

    {{-- Hook para modales/scripts por vista --}}
    @stack('modals')
    @stack('scripts')
</body>
</html>
