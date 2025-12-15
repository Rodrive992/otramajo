@extends('layouts.app')

@section('title', 'OtraMajo – Sobre Mí')

@section('content')
<style>
    :root{
        --om-blanco:#FAF9F6; --om-salvia:#A8C3A0; --om-rosa:#D4A8A1;
        --om-gris-claro:#D3D3D3; --om-arena:#F4E1A1; --om-carbon:#4A4A4A;
    }
    body{ background: var(--om-blanco); color: var(--om-carbon); }

    .pt-header{ padding-top: 140px; }
    .om-sep{ height:1px; background:linear-gradient(90deg,transparent,rgba(74,74,74,.25),transparent); }
    .om-brand{ font-family:"Cormorant Garamond", serif; }
    .om-nav{ font-family:"Quicksand", system-ui, -apple-system, Segoe UI, Roboto, sans-serif; }

    /* Estilos específicos para Sobre Mí */
    .about-section {
        position: relative;
        overflow: hidden;
    }

    .photo-frame {
        position: relative;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        transition: all 0.4s ease;
        background: var(--om-blanco);
        border: 1px solid var(--om-gris-claro);
    }

    .photo-frame::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(45deg, var(--om-salvia), var(--om-rosa), var(--om-arena));
        border-radius: 1.6rem;
        z-index: -1;
        opacity: 0.7;
    }

    .photo-frame::after {
        content: '';
        position: absolute;
        top: 8px;
        left: 8px;
        right: 8px;
        bottom: 8px;
        border: 2px solid var(--om-blanco);
        border-radius: 1.2rem;
        pointer-events: none;
        z-index: 2;
    }

    .photo-frame:hover {
        transform: translateY(-10px) rotate(1deg);
        box-shadow: 0 30px 60px rgba(0,0,0,0.15);
    }

    .photo-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .photo-frame:hover img {
        transform: scale(1.05);
    }

    .text-content {
        background: var(--om-blanco);
        padding: 3rem;
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid var(--om-gris-claro);
        position: relative;
    }

    .text-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, var(--om-salvia), var(--om-rosa));
        border-radius: 2px;
    }

    .highlight-text {
        background: linear-gradient(135deg, var(--om-rosa) 0%, var(--om-arena) 100%);
        padding: 2rem;
        border-radius: 1rem;
        margin: 2rem 0;
        border-left: 4px solid var(--om-salvia);
        position: relative;
    }

    .highlight-text::before {
        content: '"';
        position: absolute;
        top: 0.5rem;
        left: 1rem;
        font-size: 4rem;
        color: rgba(74,74,74,0.1);
        font-family: serif;
    }

    .timeline-item {
        position: relative;
        padding-left: 2rem;
        margin-bottom: 2rem;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0.5rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--om-salvia);
        border: 2px solid var(--om-blanco);
        box-shadow: 0 0 0 2px var(--om-salvia);
    }

    .timeline-item::after {
        content: '';
        position: absolute;
        left: 5px;
        top: 1.5rem;
        bottom: -2rem;
        width: 2px;
        background: var(--om-salvia);
        opacity: 0.3;
    }

    .timeline-item:last-child::after {
        display: none;
    }

    .floating-element {
        position: absolute;
        border-radius: 50%;
        opacity: 0.1;
        z-index: 0;
    }

    .floating-1 {
        width: 100px;
        height: 100px;
        background: var(--om-salvia);
        top: 10%;
        left: 5%;
        animation: float 6s ease-in-out infinite;
    }

    .floating-2 {
        width: 150px;
        height: 150px;
        background: var(--om-rosa);
        bottom: 10%;
        right: 5%;
        animation: float 8s ease-in-out infinite reverse;
    }

    .floating-3 {
        width: 80px;
        height: 80px;
        background: var(--om-arena);
        top: 50%;
        left: 90%;
        animation: float 7s ease-in-out infinite 1s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .section-fade-in {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }

    .section-visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .text-content {
            padding: 2rem 1.5rem;
        }
        
        .photo-frame {
            margin-bottom: 2rem;
        }
        
        .floating-element {
            display: none;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .photo-frame, .floating-element {
            animation: none !important;
            transform: none !important;
        }
    }
</style>

{{-- Header fijo (top) --}}
@include('partials.top-nav')

<main class="pt-header">
    {{-- HERO SOBRE MÍ --}}
    <section class="about-section py-20 bg-gradient-to-br from-[color:var(--om-blanco)] to-[color:var(--om-rosa)]/20">
        <div class="floating-element floating-1"></div>
        <div class="floating-element floating-2"></div>
        <div class="floating-element floating-3"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="om-brand text-4xl md:text-5xl lg:text-6xl font-semibold mb-6">Sobre Mí</h1>
                <div class="om-sep max-w-md mx-auto"></div>
                <p class="text-xl text-[color:var(--om-carbon)]/80 mt-6 max-w-3xl mx-auto">
                    Un recorrido por mi camino, mis transformaciones y lo que me define hoy
                </p>
            </div>

            {{-- Contenido Principal --}}
            <div class="grid lg:grid-cols-3 gap-12 items-start">
                {{-- Columna Izquierda - Imagen 1 --}}
                <div class="lg:col-span-1">
                    <div class="photo-frame h-96 lg:h-[500px] sticky top-24">
                        <img src="{{ asset('images/majo1.jpeg') }}" alt="Majo - Antes del ACV" class="w-full h-full object-cover">
                    </div>
                </div>

                {{-- Columna Central - Texto Principal --}}
                <div class="lg:col-span-2">
                    <div class="text-content section-fade-in">
                        <h2 class="om-brand text-3xl mb-6 text-[color:var(--om-salvia)]">Mi Transformación</h2>
                        
                        <p class="text-lg leading-relaxed mb-6">
                            Después de un ACV mi vida cambió mucho y también la forma en que me veo a mí misma. No soy la misma de antes, pero sigo siendo yo, con otras prioridades, otros ritmos y muchas ganas de seguir.
                        </p>
                        
                        <p class="text-lg leading-relaxed mb-6">
                            Hoy me sigo descubriendo, paso a paso, aprendiendo a convivir con lo nuevo y valorando lo que permanece. Escribo porque poner en palabras lo vivido me ayuda a entender, agradecer, acompañar. Esta página es una manera de contar, compartir y seguir aprendiendo.
                        </p>

                        <div class="highlight-text">
                            <p class="text-lg italic leading-relaxed">
                                "Así soy hoy. Pero no siempre fui así. Antes de mi ACV tenía otro ritmo, otras prioridades y muchas cosas que daba por sentadas. Mirando hacia atrás, me gusta recordar cómo era todo antes - no con nostalgia, sino para entender mi camino."
                            </p>
                        </div>

                        <h3 class="om-brand text-2xl mb-6 mt-10 text-[#C9796B]">Mi Vida Antes del ACV</h3>
                        
                        <p class="text-lg leading-relaxed mb-6">
                            Para comprender mi presente necesito contarles un poco de cómo era mi vida antes del ACV. Porque nada empezó de cero aquel día: había una historia, una forma de vivir, un ritmo de trabajo, afectos y una vida que también formaron parte de mí, aunque hoy la mire desde otro lugar.
                        </p>

                        <div class="grid md:grid-cols-2 gap-8 mt-10">
                            {{-- Timeline de Vida Profesional --}}
                            <div>
                                <h4 class="om-brand text-xl mb-4 text-[color:var(--om-salvia)]">Mi Trayectoria</h4>
                                <div class="timeline-item">
                                    <h5 class="font-semibold">25 años en la Universidad</h5>
                                    <p class="text-sm opacity-80">Comencé a los 23 años</p>
                                    <p class="mt-2">Toda mi vida laboral fue de la mano de mi vida personal</p>
                                </div>
                                <div class="timeline-item">
                                    <h5 class="font-semibold">Familia y Crecimiento</h5>
                                    <p>Allí me casé, llegaron mis 3 hijos varones, después mi nieta</p>
                                </div>
                                <div class="timeline-item">
                                    <h5 class="font-semibold">Desarrollo Profesional</h5>
                                    <p>Nodocente con la suerte de poder profesionalizarme en mi carrera</p>
                                </div>
                            </div>

                            {{-- Timeline de Educación --}}
                            <div>
                                <h4 class="om-brand text-xl mb-4 text-[color:var(--om-rosa)]">Mi Formación</h4>
                                <div class="timeline-item">
                                    <h5 class="font-semibold">Tecnicatura en Administración</h5>
                                    <p class="text-sm opacity-80">Educación Superior</p>
                                </div>
                                <div class="timeline-item">
                                    <h5 class="font-semibold">Licenciatura en Gestión de la Educación Superior</h5>
                                    <p class="mt-2">En este camino nació mi vocación por la docencia</p>
                                </div>
                                <div class="timeline-item">
                                    <h5 class="font-semibold">Pasión por la Enseñanza</h5>
                                    <p>Amaba mi trabajo y me sentía orgullosa de lo que hacía</p>
                                </div>
                            </div>
                        </div>

                        <h3 class="om-brand text-2xl mb-6 mt-12 text-[#D1B55C]">Mi Ritmo y Pasiones</h3>
                        
                        <p class="text-lg leading-relaxed mb-6">
                            Mi cabeza siempre estaba llena de proyectos y pendientes. Mis días solían comenzar temprano y terminar tarde, entre clases, reuniones, compromisos y tareas. Descansaba poco, sentía que todo tenía que hacerlo ya, sin pausas, como si el tiempo se me escapara.
                        </p>
                        
                        <p class="text-lg leading-relaxed mb-6">
                            Entre trabajo, la familia y el estudio los días pasaban volando. Era una vida llena, aunque a veces no me daba tiempo para detenerme.
                        </p>

                        <div class="bg-[color:var(--om-salvia)]/10 p-6 rounded-xl border border-[color:var(--om-salvia)]/20 mt-8">
                            <h4 class="om-brand text-xl mb-4 text-[#96BD8C]">Mi Gran Pasión: Viajar</h4>
                            <p class="text-lg leading-relaxed">
                                No hablo únicamente de grandes viajes, sino de escapadas cortas, de momentos en los que uno se permite cambiar de ambiente, respirar otro aire y mirar la vida desde otro lugar.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Imagen Inferior --}}
            <div class="mt-16 max-w-2xl mx-auto">
                <div class="photo-frame h-80">
                    <img src="{{ asset('images/majo2.jpeg') }}" alt="Majo - Hoy" class="w-full h-full object-cover">
                    <div class="absolute bottom-4 left-4 bg-[color:var(--om-blanco)]/90 backdrop-blur-sm px-4 py-2 rounded-lg">
                        <p class="text-sm font-semibold text-[color:var(--om-carbon)]">Hoy, redescubriéndome cada día</p>
                    </div>
                </div>
            </div>

            {{-- Cierre Inspirador --}}
            <div class="text-center mt-16 max-w-3xl mx-auto">
                <div class="bg-gradient-to-r from-[color:var(--om-salvia)]/20 to-[color:var(--om-rosa)]/20 p-8 rounded-2xl border border-[color:var(--om-salvia)]/30">
                    <h3 class="om-brand text-2xl mb-4 text-[color:var(--om-carbon)]">Sigo Aquí, Sigo Creciendo</h3>
                    <p class="text-lg leading-relaxed">
                        Cada experiencia, cada aprendizaje, cada cambio me ha llevado a ser quien soy hoy. 
                        Sigo caminando, con nuevos ritmos pero con la misma esencia, compartiendo este viaje con ustedes.
                    </p>
                </div>
            </div>
        </div>
    </section>
</main>

{{-- Footer (bottom) --}}
@include('partials.bottom-nav')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animación de aparición de secciones
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

    document.querySelectorAll('.section-fade-in').forEach(section => {
        observer.observe(section);
    });

    // Smooth scroll para navegación interna
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
});
</script>
@endpush