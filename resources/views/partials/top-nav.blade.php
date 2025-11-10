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

    /* Estilos mejorados para menú móvil */
    .mobile-menu-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 998;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .mobile-menu-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .mobile-menu-container {
        position: fixed;
        top: 0;
        right: -100%;
        width: 80%;
        max-width: 300px;
        height: 100vh;
        background: white;
        z-index: 999;
        transition: right 0.3s ease;
        overflow-y: auto;
        box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .mobile-menu-container.active {
        right: 0;
    }

    .mobile-menu-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #eee;
        background: var(--om-salvia);
    }

    .mobile-menu-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--om-carbon);
    }

    .mobile-menu-content {
        padding: 1rem;
    }

    .mobile-menu-link {
        display: block;
        padding: 0.75rem 0;
        color: var(--om-carbon);
        text-decoration: none;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.2s ease;
    }

    .mobile-menu-link:hover {
        color: var(--om-rosa);
        padding-left: 0.5rem;
    }

    .mobile-menu-link:last-child {
        border-bottom: none;
    }

    .mobile-menu-trigger {
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 4px;
        background: rgba(255, 255, 255, 0.6);
        transition: background 0.2s ease;
    }

    .mobile-menu-trigger:hover {
        background: rgba(255, 255, 255, 0.8);
    }
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
                   
                    <li><a href="{{ route('Sobre-mi')}}" class="om-link">Sobre mi</a></li>
                    <li><a href="#" class="om-link">Blog personal</a></li>
                    <li><a href="#" class="om-link">Videos</a></li>
                    <li><a href="#" class="om-link">Noticias</a></li>
                    <li><a href="#" class="om-link">Preguntas frecuentes</a></li>
                    <li><a href="#" class="om-link">Encuestas</a></li>
                    <li><a href="#" class="om-link">Resultados</a></li>
                    <li><a href="#" class="om-link">Contacto</a></li>
                </ul>
            </nav>

            {{-- Menú móvil mejorado --}}
            <div class="md:hidden">
                <button class="mobile-menu-trigger" id="mobileMenuTrigger">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Menú móvil desplegable --}}
    <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>
    <div class="mobile-menu-container" id="mobileMenuContainer">
        <div class="mobile-menu-header">
            <h3 class="font-semibold text-lg">Menú</h3>
            <button class="mobile-menu-close" id="mobileMenuClose">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        <div class="mobile-menu-content">
            
            <a href="{{ route('Sobre-mi')}}" class="mobile-menu-link">Sobre mi</a>
            <a href="#" class="mobile-menu-link">Blog personal</a>
            <a href="#" class="mobile-menu-link">Videos</a>
            <a href="#" class="mobile-menu-link">Noticias</a>
            <a href="#" class="mobile-menu-link">Preguntas frecuentes</a>
            <a href="#" class="mobile-menu-link">Encuestas</a>
            <a href="#" class="mobile-menu-link">Resultados</a>
            <a href="#" class="mobile-menu-link">Contacto</a>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuTrigger = document.getElementById('mobileMenuTrigger');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
        const mobileMenuContainer = document.getElementById('mobileMenuContainer');
        const mobileMenuClose = document.getElementById('mobileMenuClose');
        
        // Abrir menú
        mobileMenuTrigger.addEventListener('click', function() {
            mobileMenuOverlay.classList.add('active');
            mobileMenuContainer.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevenir scroll del body
        });
        
        // Cerrar menú
        function closeMobileMenu() {
            mobileMenuOverlay.classList.remove('active');
            mobileMenuContainer.classList.remove('active');
            document.body.style.overflow = ''; // Restaurar scroll del body
        }
        
        mobileMenuClose.addEventListener('click', closeMobileMenu);
        mobileMenuOverlay.addEventListener('click', closeMobileMenu);
        
        // Cerrar menú al hacer clic en un enlace
        const mobileMenuLinks = document.querySelectorAll('.mobile-menu-link');
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });
    });
</script>