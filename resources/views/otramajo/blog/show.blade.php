@extends('layouts.app')

@section('title', 'OtraMajo – ' . $articulo->titulo)

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

    .article-section {
        position: relative;
        overflow: hidden;
        padding: 3rem 0;
    }

    .photo-frame,
    .photo-frame-inline {
        position: relative;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        transition: all 0.4s ease;
        background: var(--om-blanco);
        border: 1px solid var(--om-gris-claro);
    }

    .photo-frame {
        height: 500px;
    }

    .photo-frame-inline {
        height: 360px;
        margin-top: 2rem;
    }

    .photo-frame::before,
    .photo-frame-inline::before {
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

    .photo-frame::after,
    .photo-frame-inline::after {
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

    .photo-frame:hover,
    .photo-frame-inline:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    }

    .photo-frame img,
    .photo-frame-inline img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .photo-frame:hover img,
    .photo-frame-inline:hover img {
        transform: scale(1.05);
    }

    .text-content {
        background: var(--om-blanco);
        padding: 3rem;
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid var(--om-gris-claro);
        position: relative;
        height: fit-content;
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

    .chip-date {
        display: inline-block;
        background: var(--om-blanco);
        border: 1px solid var(--om-gris-claro);
        border-radius: 999px;
        padding: .5rem 1rem;
        font-size: .9rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .06);
        margin: 1rem 0;
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

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        border: 1px solid var(--om-gris-claro);
        background: var(--om-blanco);
        color: var(--om-carbon);
        transition: all 0.3s ease;
        text-decoration: none;
        font-weight: 500;
        margin-top: 2rem;
    }

    .back-button:hover {
        background: var(--om-salvia);
        color: #1f2a1f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(168, 195, 160, 0.3);
    }

    .article-body {
        overflow-wrap: break-word;
        word-wrap: break-word;
        word-break: break-word;
    }

    .article-body p,
    .article-body ul,
    .article-body ol {
        overflow-wrap: break-word;
        word-wrap: break-word;
        word-break: break-word;
        margin-bottom: 1.5rem;
        line-height: 1.7;
    }

    .conclusion {
        background: var(--om-salvia);
        color: #1f2a1f;
        padding: 1.5rem;
        border-radius: .75rem;
        border: 1px solid #9fc09a;
        margin-top: 2rem;
        overflow-wrap: break-word;
        word-wrap: break-word;
        word-break: break-word;
    }

    @media (max-width: 768px) {
        .text-content {
            padding: 2rem 1.5rem;
        }

        .photo-frame {
            margin-bottom: 2rem;
            height: 300px;
        }

        .photo-frame-inline {
            height: 260px;
        }

        .floating-element {
            display: none;
        }

        .pt-header {
            padding-top: 120px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .photo-frame, .photo-frame-inline, .floating-element {
            animation: none !important;
            transform: none !important;
        }
    }
</style>

@include('partials.top-nav')

<main class="pt-header">
    <section class="article-section bg-gradient-to-br from-[color:var(--om-blanco)] to-[color:var(--om-rosa)]/20">
        <div class="floating-element floating-1"></div>
        <div class="floating-element floating-2"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Título y fecha --}}
            <div class="text-center mb-12">
                <h1 class="om-brand text-4xl md:text-5xl lg:text-6xl font-semibold mb-6">{{ $articulo->titulo }}</h1>
                <div class="om-sep max-w-md mx-auto"></div>
                <div class="mt-6">
                    @php
                        $fecha = \Carbon\Carbon::parse($articulo->fecha_publicacion)
                            ->locale('es')
                            ->translatedFormat('d \\de F, Y');
                    @endphp
                    <span class="chip-date">{{ $fecha }}</span>
                </div>
            </div>

            {{-- Contenido Principal: texto (2 col) – portada (1 col) --}}
            <div class="grid lg:grid-cols-3 gap-12 items-start">
                {{-- Columna texto --}}
                <div class="lg:col-span-2">
                    <div class="text-content section-fade-in">
                        <article class="article-body prose max-w-none">
                            @if ($articulo->descripcion)
                                <div class="highlight-text">
                                    {{ $articulo->descripcion }}
                                </div>
                            @endif

                            {{-- Imagen secundaria 2 debajo de la descripción --}}
                            @if ($articulo->imagen_secundaria2)
                                @php
                                    $img2 = $articulo->imagen_secundaria2;
                                    $isUrl2 = $img2 && \Illuminate\Support\Str::startsWith($img2, ['http://', 'https://']);
                                    $src2 = $isUrl2 ? $img2 : asset('storage/' . $img2);
                                @endphp
                                <div class="photo-frame-inline">
                                    <img src="{{ $src2 }}" alt="Imagen secundaria 2 {{ $articulo->titulo }}">
                                </div>
                            @endif

                            {{-- Cuerpo --}}
                            {!! $articulo->cuerpo !!}

                            {{-- Conclusión --}}
                            @if ($articulo->conclusion)
                                <div class="conclusion">
                                    <strong>Cierre:</strong> {{ $articulo->conclusion }}
                                </div>
                            @endif

                            {{-- Imagen secundaria 3 debajo de la conclusión --}}
                            @if ($articulo->imagen_secundaria3)
                                @php
                                    $img3 = $articulo->imagen_secundaria3;
                                    $isUrl3 = $img3 && \Illuminate\Support\Str::startsWith($img3, ['http://', 'https://']);
                                    $src3 = $isUrl3 ? $img3 : asset('storage/' . $img3);
                                @endphp
                                <div class="photo-frame-inline">
                                    <img src="{{ $src3 }}" alt="Imagen secundaria 3 {{ $articulo->titulo }}">
                                </div>
                            @endif
                        </article>

                        {{-- Botón Volver --}}
                        <div class="text-center mt-8">
                            <a href="{{ route('blog.index') }}" class="back-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                </svg>
                                Volver
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Columna derecha: portada + secundaria1 debajo --}}
                @php
                    $img = $articulo->imagen_portada;
                    $isUrl = $img && \Illuminate\Support\Str::startsWith($img, ['http://', 'https://']);
                    $src = $isUrl ? $img : ($img ? asset('storage/' . $img) : asset('images/placeholder-om.jpg'));
                @endphp
                <div class="lg:col-span-1">
                    <div class="photo-frame sticky top-24">
                        <img src="{{ $src }}" alt="Portada {{ $articulo->titulo }}" class="w-full h-full object-cover">
                    </div>

                    {{-- Imagen secundaria 1 debajo de la portada --}}
                    @if ($articulo->imagen_secundaria1)
                        @php
                            $img1 = $articulo->imagen_secundaria1;
                            $isUrl1 = $img1 && \Illuminate\Support\Str::startsWith($img1, ['http://', 'https://']);
                            $src1 = $isUrl1 ? $img1 : asset('storage/' . $img1);
                        @endphp
                        <div class="photo-frame-inline">
                            <img src="{{ $src1 }}" alt="Imagen secundaria 1 {{ $articulo->titulo }}">
                        </div>
                    @endif
                </div>
            </div>

            {{-- Artículos relacionados --}}
            @if (isset($relacionados) && $relacionados->isNotEmpty())
                <div class="mt-16">
                    <div class="text-center mb-8">
                        <h3 class="om-brand text-3xl mb-4">También podría interesarte</h3>
                        <div class="om-sep max-w-md mx-auto"></div>
                    </div>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($relacionados as $r)
                            @php
                                $rimg = $r->imagen_portada;
                                $rurl = $rimg && \Illuminate\Support\Str::startsWith($rimg, ['http://', 'https://'])
                                    ? $rimg
                                    : ($rimg ? asset('storage/' . $rimg) : asset('images/placeholder-om.jpg'));
                                $rfecha = \Carbon\Carbon::parse($r->fecha_publicacion)
                                    ->locale('es')
                                    ->translatedFormat('d \\de F, Y');
                            @endphp
                            <a href="{{ route('blog.show', $r->id) }}" 
                               class="block border border-[color:var(--om-gris-claro)] rounded-xl overflow-hidden hover:shadow-lg transition duration-300 bg-white">
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ $rurl }}" alt="Portada {{ $r->titulo }}" 
                                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                                </div>
                                <div class="p-4">
                                    <div class="text-sm opacity-70 mb-2">{{ $rfecha }}</div>
                                    <h4 class="font-semibold text-lg mb-2 line-clamp-2">{{ $r->titulo }}</h4>
                                    <div class="opacity-80 text-sm line-clamp-3">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($r->descripcion), 120) }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
</main>

@include('partials.bottom-nav')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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

