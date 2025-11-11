@extends('layouts.app')

@section('title', 'OtraMajo – Inicio')

@section('content')
<style>
    :root{
        --om-blanco:#FAF9F6; --om-salvia:#A8C3A0; --om-rosa:#E9C7C1;
        --om-gris-claro:#D3D3D3; --om-arena:#F4E1A1; --om-carbon:#4A4A4A;
    }
    body{ background: var(--om-blanco); color: var(--om-carbon); }

    /* Compensa header fijo */
    .pt-header{ padding-top: 140px; }

    .om-sep{ height:1px; background:linear-gradient(90deg,transparent,rgba(74,74,74,.25),transparent); }
    .om-brand{ font-family:"Cormorant Garamond", serif; }
    .om-nav{ font-family:"Quicksand", system-ui, -apple-system, Segoe UI, Roboto, sans-serif; }

    /* ===== HERO MEJORADO ===== */
    .om-hero{
        position: relative;
        isolation: isolate;
        overflow: hidden;
        min-height: 85vh;
        width: 100%;
        background: var(--om-blanco);
    }
    .om-hero-img{
        position: absolute;
        inset: 0;
        background-image: url('{{ asset('images/birds.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transform: scale(var(--om-zoom, 1.08)) translate(var(--om-mouse-x, 0px), var(--om-mouse-y, 0px));
        transition: transform .15s ease-out;
        will-change: transform;
        filter: brightness(1) contrast(1);
    }
    .om-hero::before{
        content: "";
        position: absolute; inset: 0;
        background: rgba(255,255,255, .20);
        z-index: 0;
        pointer-events: none;
    }
    .om-hero::after{
        content:""; position:absolute; inset:0;
        background: linear-gradient(180deg,
            rgba(250,249,246,.85) 0%,
            rgba(244,225,161,.45) 100%
        );
        z-index: 0;
        pointer-events: none;
        backdrop-filter: brightness(1.06);
    }
    .om-hero-inner{ position: relative; z-index: 2; }

    /* Tarjeta principal mejorada */
    .hero-card {
        background: rgba(250, 249, 246, 0.92);
        backdrop-filter: blur(10px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 2rem;
        box-shadow: 
            0 20px 40px rgba(0, 0, 0, 0.08),
            0 8px 24px rgba(168, 195, 160, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.6);
        transform: translateY(0);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .hero-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.4),
            transparent
        );
        transition: left 0.7s ease;
    }

    .hero-card:hover::before {
        left: 100%;
    }

    .hero-card:hover {
        transform: translateY(-8px);
        box-shadow: 
            0 30px 60px rgba(0, 0, 0, 0.12),
            0 15px 35px rgba(168, 195, 160, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
    }

    /* Botones con animación suave */
    .om-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-family: "Quicksand", sans-serif;
    }
    .om-btn-primary {
        background: var(--om-salvia);
        color: var(--om-carbon);
        border: 1px solid #98b691;
    }
    .om-btn-primary:hover {
        background: #9ab894;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(168,195,160,0.3);
    }
    .om-btn-secondary {
        background: var(--om-rosa);
        color: var(--om-carbon);
        border: 1px solid #e7b5ad;
    }
    .om-btn-secondary:hover {
        background: #e6bfb9;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(233,199,193,0.3);
    }

    /* Secciones con animaciones sutiles */
    .section-fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .section-visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Tarjetas de contenido */
    .content-card {
        background: var(--om-blanco);
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.06);
        border: 1px solid var(--om-gris-claro);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .content-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .content-card-rosa {
        background: var(--om-rosa);
        border-color: #e7b5ad;
    }
    .content-card-salvia {
        background: var(--om-salvia);
        border-color: #98b691;
    }
    .content-card-arena {
        background: var(--om-arena);
        border-color: #ead894;
    }

    /* Iconos animados */
    .om-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: var(--om-carbon);
        transition: transform 0.3s ease;
    }
    .content-card:hover .om-icon {
        transform: scale(1.1);
    }

    /* Cita destacada */
    .highlight-quote {
        position: relative;
        padding: 2rem;
        border-radius: 1rem;
        background: linear-gradient(135deg, var(--om-rosa) 0%, var(--om-arena) 100%);
        border-left: 4px solid var(--om-salvia);
    }
    .highlight-quote::before {
        content: """;
        position: absolute;
        top: 0.5rem;
        left: 1rem;
        font-size: 4rem;
        color: rgba(74,74,74,0.1);
        font-family: serif;
    }

    /* Lista de características con iconos */
    .feature-list {
        list-style: none;
        padding: 0;
    }
    .feature-list li {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1rem;
        padding: 0.5rem 0;
    }
    .feature-list i {
        color: var(--om-salvia);
        margin-top: 0.25rem;
        flex-shrink: 0;
    }

    /* Efectos de texto mejorados */
    .om-hero-inner h1 {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        background: linear-gradient(135deg, var(--om-carbon) 0%, #2d2d2d 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Animación de entrada para el contenido */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hero-card > .relative {
        animation: fadeInUp 0.8s ease-out 0.3s both;
    }

    .hero-card h1 {
        animation: fadeInUp 0.8s ease-out 0.5s both;
    }

    .hero-card p {
        animation: fadeInUp 0.8s ease-out 0.7s both;
    }

    .hero-card .flex {
        animation: fadeInUp 0.8s ease-out 0.9s both;
    }

    @media (prefers-reduced-motion: reduce){
        .om-hero-img, .hero-card, .content-card, .om-icon { 
            transition: none !important; 
            transform: none !important;
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .om-hero { min-height: 70vh; }
        .pt-header { padding-top: 120px; }
        
        .om-hero-inner {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        
        .hero-card {
            padding: 2.5rem 1.5rem;
            margin: 0 1rem;
        }
        
        .om-hero-inner h1 {
            font-size: 3rem;
        }
        
        .om-hero-inner p {
            font-size: 1.25rem;
        }
        
        .flex.flex-wrap {
            flex-direction: column;
            align-items: center;
        }
        
        .om-btn {
            width: 100%;
            max-width: 280px;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .om-hero-inner h1 {
            font-size: 2.5rem;
        }
        
        .hero-card {
            padding: 2rem 1rem;
        }
    }
</style>

{{-- Header fijo (top) --}}
@include('partials.top-nav')

<main class="pt-header">
    {{-- HERO SIMPLIFICADO MEJORADO --}}
    <section class="om-hero flex items-center justify-center">
        <div class="om-hero-img"></div>

        <div class="om-hero-inner w-full max-w-6xl mx-auto px-6 sm:px-6 lg:px-8 py-20">
            <div class="hero-card p-10 md:p-16 max-w-4xl mx-auto text-center relative overflow-hidden">
                {{-- Efecto de partículas sutiles --}}
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute top-10 left-10 w-20 h-20 rounded-full bg-[color:var(--om-salvia)] blur-xl"></div>
                    <div class="absolute bottom-10 right-10 w-24 h-24 rounded-full bg-[color:var(--om-rosa)] blur-xl"></div>
                    <div class="absolute top-1/2 left-1/4 w-16 h-16 rounded-full bg-[color:var(--om-arena)] blur-lg"></div>
                </div>
                
                {{-- Borde sutil animado --}}
                <div class="absolute inset-0 rounded-2xl border-2 border-transparent bg-gradient-to-r from-[color:var(--om-salvia)]/20 via-[color:var(--om-rosa)]/10 to-[color:var(--om-arena)]/20 opacity-60"></div>
                
                {{-- Contenido --}}
                <div class="relative z-10">
                    <h1 class="om-brand text-5xl md:text-6xl lg:text-7xl font-semibold mb-6 text-[color:var(--om-carbon)] leading-tight">
                        Hola, soy <span class="text-[color:var(--om-salvia)]">Majo</span>
                    </h1>
                    
                    <div class="w-24 h-1 bg-gradient-to-r from-[color:var(--om-salvia)] to-[color:var(--om-rosa)] mx-auto mb-8 rounded-full"></div>
                    
                    <p class="text-2xl md:text-3xl leading-relaxed mb-8 text-[color:var(--om-carbon)]/90 font-light max-w-3xl mx-auto">
                        Comparto mi camino de recuperación después de un ACV, con <span class="font-medium text-[color:var(--om-salvia)]">esperanza</span> y <span class="font-medium text-[color:var(--om-rosa)]">aprendizajes</span> para quienes transitan experiencias similares.
                    </p>
                    
                    <div class="flex flex-wrap gap-6 justify-center mt-12">
                        <a href="#mi-historia" class="om-btn om-btn-primary text-lg px-8 py-4 group">
                            <span class="group-hover:translate-x-1 transition-transform duration-300">Conoce mi historia</span>
                            <i class="fas fa-arrow-down group-hover:translate-y-1 transition-transform duration-300"></i>
                        </a>
                        <a href="{{ route('Blog')}}" class="om-btn om-btn-secondary text-lg px-8 py-4 group">
                            <span class="group-hover:translate-x-1 transition-transform duration-300">Leer el blog</span>
                            <i class="fas fa-book-open group-hover:scale-110 transition-transform duration-300"></i>
                        </a>
                    </div>
                    
                    {{-- Scroll indicator --}}
                    <div class="mt-16 animate-bounce">
                        <a href="#mi-historia" class="inline-flex flex-col items-center text-[color:var(--om-carbon)]/60 hover:text-[color:var(--om-salvia)] transition-colors duration-300">
                            <span class="text-sm mb-2">Descubre más</span>
                            <i class="fas fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Efecto de overlay sutil en los bordes --}}
        <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at center, transparent 60%, var(--om-blanco) 100%);"></div>
    </section>

    {{-- SECCIÓN: MI HISTORIA --}}
    <section id="mi-historia" class="section-fade-in py-16 bg-[color:var(--om-blanco)]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="om-brand text-3xl md:text-4xl font-semibold mb-4">Mi Historia</h2>
                <div class="om-sep max-w-md mx-auto"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div class="content-card content-card-salvia">
                    <i class="om-icon fas fa-heartbeat"></i>
                    <h3 class="om-brand text-2xl mb-4">Un cambio inesperado</h3>
                    <p class="leading-relaxed mb-4">
                        Hace un tiempo mi vida cambió de forma que nunca imaginé: me desperté con un ACV (accidente cerebrovascular). 
                    </p>
                    <p class="leading-relaxed">
                        Esta página nace del deseo de compartir mi camino: mis miedos, avances, recaídas y los pequeños logros que me trajeron hasta acá.
                    </p>
                </div>

                <div class="content-card">
                    <i class="om-icon fas fa-hands-helping"></i>
                    <h3 class="om-brand text-2xl mb-4">Una mirada humana</h3>
                    <p class="leading-relaxed mb-4">
                        No soy médica ni especialista, solo una persona que quiere ofrecer una perspectiva real sobre la recuperación.
                    </p>
                    <p class="leading-relaxed">
                        Creo firmemente que incluso en medio de un golpe tan duro, es posible encontrar nuevos caminos y formas de amar la vida.
                    </p>
                </div>
            </div>

            <div class="mt-12 highlight-quote">
                <blockquote class="text-xl italic text-[color:var(--om-carbon)]/90 mb-4 text-center">
                    "La vida es un 10% lo que nos ocurre y un 90% cómo reaccionamos a ello."
                </blockquote>
                <p class="text-center font-medium">— Charles R. Swindoll</p>
            </div>
        </div>
    </section>

    {{-- SECCIÓN: QUÉ ENCONTRARÁS AQUÍ --}}
    <section id="que-encontraras" class="section-fade-in py-16" style="background: var(--om-rosa);">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="om-brand text-3xl md:text-4xl font-semibold mb-4">Qué encontrarás aquí</h2>
                <div class="om-sep max-w-md mx-auto"></div>
                <p class="text-lg max-w-2xl mx-auto mt-4">
                    Un espacio creado con cuidado para compartir recursos, experiencias y esperanza.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="content-card content-card-arena">
                    <i class="om-icon fas fa-pencil-alt"></i>
                    <h3 class="om-brand text-xl mb-3">Blog Personal</h3>
                    <p>Relatos sobre mi proceso de recuperación y reflexiones sobre el día a día.</p>
                </div>

                <div class="content-card">
                    <i class="om-icon fas fa-video"></i>
                    <h3 class="om-brand text-xl mb-3">Videos</h3>
                    <p>Registros y ejercicios que me han ayudado en mi rehabilitación.</p>
                </div>

                <div class="content-card content-card-salvia">
                    <i class="om-icon fas fa-newspaper"></i>
                    <h3 class="om-brand text-xl mb-3">Noticias</h3>
                    <p>Información útil y novedades relacionadas con ACV y recuperación.</p>
                </div>

                <div class="content-card">
                    <i class="om-icon fas fa-question-circle"></i>
                    <h3 class="om-brand text-xl mb-3">Preguntas Frecuentes</h3>
                    <p>Respuestas sencillas desde mi experiencia personal.</p>
                </div>

                <div class="content-card content-card-rosa">
                    <i class="om-icon fas fa-poll"></i>
                    <h3 class="om-brand text-xl mb-3">Encuestas</h3>
                    <p>Para escucharnos y aprender entre todos como comunidad.</p>
                </div>

                <div class="content-card">
                    <i class="om-icon fas fa-chart-line"></i>
                    <h3 class="om-brand text-xl mb-3">Resultados</h3>
                    <p>Lo que vamos construyendo y descubriendo juntos.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN: ESPERANZA Y COMUNIDAD --}}
    <section id="esperanza" class="section-fade-in py-16 bg-[color:var(--om-blanco)]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <i class="om-icon fas fa-dove text-5xl mb-6"></i>
            <h2 class="om-brand text-3xl md:text-4xl font-semibold mb-6">Un mensaje de esperanza</h2>
            
            <div class="content-card max-w-3xl mx-auto">
                <p class="text-lg leading-relaxed mb-6">
                    Si estás atravesando algo similar como paciente, familiar o amigo, o simplemente querés conocer una historia de resiliencia, te invito a acompañarme.
                </p>
                <p class="text-lg leading-relaxed mb-6">
                    Este espacio es para compartir, aprender y recordar que <strong>cada paso, por pequeño que sea, es importante</strong> en nuestra vida.
                </p>
                <p class="text-xl font-medium mt-6" style="color: var(--om-salvia);">
                    Gracias por estar aquí — Bienvenido a mi página.
                </p>
            </div>

            <div class="mt-12">
                <a href="#" class="om-btn om-btn-primary text-lg px-8 py-3">
                    <span>Ponte en contacto</span>
                    <i class="fas fa-envelope"></i>
                </a>
            </div>
        </div>
    </section>
</main>

{{-- Footer (bottom) --}}
@include('partials.bottom-nav')
@endsection

@push('scripts')
<script>
(function(){
    // Efecto parallax en el hero
    const hero = document.querySelector('.om-hero');
    const img  = document.querySelector('.om-hero-img');
    if (!hero || !img) return;

    hero.addEventListener('mousemove', (e) => {
        const rect = hero.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const nx = x / rect.width;
        const ny = y / rect.height;
        const MAX = 18;
        const moveX = (nx - 0.5) * MAX * -1;
        const moveY = (ny - 0.5) * MAX * -1;

        img.style.setProperty('--om-mouse-x', `${moveX.toFixed(1)}px`);
        img.style.setProperty('--om-mouse-y', `${moveY.toFixed(1)}px`);
        img.style.setProperty('--om-zoom', '1.10');
    });

    hero.addEventListener('mouseleave', () => {
        img.style.setProperty('--om-mouse-x', '0px');
        img.style.setProperty('--om-mouse-y', '0px');
        img.style.setProperty('--om-zoom', '1.08');
    });

    // Animación de aparición de secciones al hacer scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('section-visible');
            }
        });
    }, observerOptions);

    // Observar todas las secciones con animación
    document.querySelectorAll('.section-fade-in').forEach(section => {
        observer.observe(section);
    });

    // Smooth scroll para los enlaces internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
})();
</script>
@endpush