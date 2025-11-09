{{-- Header fijo con dos franjas: social + navegación/logo --}}
@php
    $logo = $logo ?? asset('images/otramajo-logo.png'); // PNG transparente con el nombre incluido
@endphp

{{-- Tipografías serenas (para nav) --}}
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=Quicksand:wght@400;600&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
    :root {
        --om-rosa: #E9C7C1;
        --om-salvia: #A8C3A0;
        --om-carbon: #4A4A4A;
    }

    .om-nav {
        font-family: "Quicksand", system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
    }

    /* Links más oscuros + dinamismo */
    .om-link {
        position: relative;
        color: #2f2f2f;                 /* un poco más oscuro */
        transition: transform .18s ease, color .18s ease;
    }
    .om-link::after {
        content: "";
        position: absolute;
        left: 0; right: 0; bottom: -3px; height: 2px;
        background: currentColor;
        transform: scaleX(0);
        transform-origin: left;
        transition: transform .18s ease;
    }
    .om-link:hover {
        color: #1f1f1f;
        transform: translateY(-1px);
    }
    .om-link:hover::after {
        transform: scaleX(1);
    }

    /* Hover suave del logo */
    img[alt="OtraMajo"] { transition: transform .25s ease; }
    img[alt="OtraMajo"]:hover { transform: scale(1.03); }
</style>

<header class="site-header fixed top-0 inset-x-0 z-50">
    {{-- Franja superior (social) --}}
    <div class="w-full" style="background: var(--om-rosa); color:var(--om-carbon);">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-10 flex items-center justify-end gap-4 text-sm">
            <a href="#" aria-label="Instagram" class="hover:opacity-80"><i class="fab fa-instagram"></i></a>
            <a href="#" aria-label="Facebook" class="hover:opacity-80"><i class="fab fa-facebook"></i></a>
            <a href="#" aria-label="YouTube" class="hover:opacity-80"><i class="fab fa-youtube"></i></a>
            <a href="#" aria-label="TikTok" class="hover:opacity-80"><i class="fab fa-tiktok"></i></a>
            <a href="#" aria-label="X / Twitter" class="hover:opacity-80"><i class="fab fa-x-twitter"></i></a>
            <a href="#" aria-label="WhatsApp" class="hover:opacity-80"><i class="fab fa-whatsapp"></i></a>
        </div>
    </div>

    {{-- Franja principal (logo grande + navegación) --}}
    <div class="w-full border-b" style="background: var(--om-salvia); border-color:#98b691">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-24 flex items-center justify-between">
            {{-- Solo logo (más grande SIN afectar el alto del nav) --}}
            <a href="{{ route('home', absolute: false) ?? '#' }}" class="block">
                <img
                    src="{{ $logo }}"
                    alt="OtraMajo"
                    class="max-h-24 md:max-h-[220px] w-auto object-contain -mt-2 drop-shadow-sm"
                />
            </a>

            {{-- Navegación escritorio --}}
            <nav class="hidden md:block om-nav">
                <ul class="flex flex-wrap items-center gap-x-4 gap-y-1 text-[15px]">
                    <li><a href="#" class="om-link">Hola</a></li>
                    <li><a href="#" class="om-link">Sobre mi</a></li>
                    <li><a href="#" class="om-link">Blog personal</a></li>
                    <li><a href="#" class="om-link">Videos</a></li>
                    <li><a href="#" class="om-link">Noticias</a></li>
                    <li><a href="#" class="om-link">Preguntas frecuentes</a></li>
                    <li><a href="#" class="om-link">Encuestas</a></li>
                    <li><a href="#" class="om-link">Resultados</a></li>
                    <li><a href="#" class="om-link">Contacto</a></li>
                </ul>
            </nav>

            {{-- Menú móvil --}}
            <div class="md:hidden">
                <details>
                    <summary class="cursor-pointer px-3 py-2 rounded-md bg-white/60 hover:bg-white/80">
                        <i class="fa-solid fa-bars"></i>
                    </summary>
                    <div class="mt-2 bg-white rounded-lg shadow p-3 om-nav text-sm">
                        <a href="#" class="block py-1 om-link">Hola</a>
                        <a href="#" class="block py-1 om-link">Sobre mi</a>
                        <a href="#" class="block py-1 om-link">Blog personal</a>
                        <a href="#" class="block py-1 om-link">Videos</a>
                        <a href="#" class="block py-1 om-link">Noticias</a>
                        <a href="#" class="block py-1 om-link">Preguntas frecuentes</a>
                        <a href="#" class="block py-1 om-link">Encuestas</a>
                        <a href="#" class="block py-1 om-link">Resultados</a>
                        <a href="#" class="block py-1 om-link">Contacto</a>
                    </div>
                </details>
            </div>
        </div>
    </div>
</header>
