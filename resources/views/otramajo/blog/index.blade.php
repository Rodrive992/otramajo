@extends('layouts.app')

@section('title', 'OtraMajo – Blog')

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

    .about-section { 
        position: relative; 
        overflow: hidden;
        background: linear-gradient(135deg, var(--om-blanco) 0%, var(--om-rosa)/10 100%);
    }

    .floating-element {
        position: absolute;
        border-radius: 50%;
        opacity: 0.08;
        z-index: 0;
        pointer-events: none;
    }
    .floating-1 {
        width: 120px;
        height: 120px;
        background: var(--om-salvia);
        top: 15%;
        left: 8%;
        animation: float 8s ease-in-out infinite;
    }
    .floating-2 {
        width: 80px;
        height: 80px;
        background: var(--om-rosa);
        bottom: 20%;
        right: 10%;
        animation: float 6s ease-in-out infinite reverse;
    }
    .floating-3 {
        width: 100px;
        height: 100px;
        background: var(--om-arena);
        top: 60%;
        left: 85%;
        animation: float 7s ease-in-out infinite 2s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .card-post{
        background: var(--om-blanco);
        border: 1px solid var(--om-gris-claro);
        border-radius: 1.25rem;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,.06);
        transition: all 0.4s ease;
        position: relative;
        z-index: 1;
    }
    .card-post:hover{
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,.12);
        border-color: var(--om-salvia);
    }

    .card-img-container {
        position: relative;
        overflow: hidden;
        height: 220px;
    }

    .card-img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .card-post:hover .card-img {
        transform: scale(1.08);
    }

    .card-body{ 
        padding: 1.5rem 1.5rem 1.75rem; 
        position: relative; 
    }

    /* Número de orden */
    .order-num{
        font-size: 1.50rem;
        font-weight: 600;
        color: var(--om-carbon);
        opacity: 0.8;
        margin-bottom: 0.25rem;
    }

    .chip-date{
        position: absolute; 
        top: -14px; 
        left: 1.5rem;
        background: var(--om-blanco);
        border: 1px solid var(--om-gris-claro);
        border-radius: 999px;
        padding: 0.4rem 0.9rem;
        font-size: 0.8rem;
        box-shadow: 0 4px 12px rgba(0,0,0,.08);
        z-index: 2;
    }

    .card-title{
        font-family: "Cormorant Garamond", serif;
        font-size: 1.4rem;
        line-height: 1.3;
        margin-bottom: 0.75rem;
        font-weight: 600;
    }

    .card-desc{ 
        color: rgba(74,74,74,.85); 
        line-height: 1.6;
        margin-bottom: 1.25rem;
    }

    .hero-band{
        background: linear-gradient(135deg, var(--om-rosa) 0%, var(--om-arena) 100%);
        border: 1px solid rgba(212, 168, 161, 0.3);
        border-radius: 1.5rem;
        text-align: center;
        box-shadow: 0 15px 35px rgba(0,0,0,.08);
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .hero-band::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.3;
        z-index: -1;
    }

    .hero-band h2{
        font-family: "Cormorant Garamond", serif;
        font-size: 2rem;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .hero-band p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .read-more-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.2rem;
        border-radius: 0.75rem;
        border: 1px solid var(--om-gris-claro);
        background: var(--om-blanco);
        color: var(--om-carbon);
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .read-more-btn:hover {
        background: var(--om-salvia);
        color: #1f2a1f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(168, 195, 160, 0.3);
        border-color: var(--om-salvia);
    }

    .pagination-container {
        background: var(--om-blanco);
        border: 1px solid var(--om-gris-claro);
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0,0,0,.05);
    }

    @media (max-width: 768px){
        .pt-header{ padding-top: 100px; }
        .card-img-container {
            height: 180px;
        }
        .hero-band {
            padding: 1.5rem;
        }
        .hero-band h2 {
            font-size: 1.5rem;
        }
        .floating-element {
            display: none;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .card-post, .floating-element {
            animation: none !important;
            transform: none !important;
        }
        .card-post:hover {
            transform: none;
        }
    }
</style>

@include('partials.top-nav')

<main class="pt-header">
    <section class="about-section py-14">
        <div class="floating-element floating-1"></div>
        <div class="floating-element floating-2"></div>
        <div class="floating-element floating-3"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            {{-- Encabezado --}}
            <div class="text-center mb-12">
                <h1 class="om-brand text-4xl md:text-5xl font-semibold mb-4">Blog</h1>
                <div class="om-sep max-w-md mx-auto"></div>
                <p class="mt-6 text-lg opacity-80 max-w-2xl mx-auto">
                    Relatos y aprendizajes en el camino de mi nueva vida.
                </p>
            </div>

            {{-- Cintillo destacado --}}
            <div class="hero-band mb-12">
                <h2 class="text-2xl md:text-3xl mb-2">"Todo final también es un inicio"</h2>
                <p class="opacity-90 text-lg">Caminando juntos mi nueva vida</p>
            </div>

            {{-- Grilla de artículos --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($articulos as $post)
                    @php
                        $img = $post->imagen_portada;
                        $isUrl = $img && (Str::startsWith($img, ['http://','https://']));
                        $src = $isUrl ? $img : ($img ? asset('storage/'.$img) : asset('images/placeholder-om.jpg'));
                        $fecha = \Carbon\Carbon::parse($post->fecha_publicacion)->locale('es')->translatedFormat('d \\de F, Y');
                    @endphp

                    <article class="card-post">
                        <a href="{{ route('blog.show', $post->id) }}" class="block card-img-container">
                            <img class="card-img" src="{{ $src }}" alt="Portada {{ $post->titulo }}">
                        </a>
                        <div class="card-body">
                            @if($post->orden_articulos)
                                <div class="order-num">#{{ $post->orden_articulos }}</div>
                            @endif
                            <span class="chip-date">{{ $fecha }}</span>
                            <h3 class="card-title">
                                <a href="{{ route('blog.show', $post->id) }}" class="hover:text-[color:var(--om-salvia)] transition-colors">
                                    {{ $post->titulo }}
                                </a>
                            </h3>
                            <p class="card-desc">
                                {{ Str::limit(strip_tags($post->descripcion), 140) }}
                            </p>
                            <div class="mt-2">
                                <a href="{{ route('blog.show', $post->id) }}" class="read-more-btn">
                                    Leer más
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 18l6-6-6-6"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3">
                        <div class="bg-white border border-[color:var(--om-gris-claro)] rounded-xl p-12 text-center">
                            <p class="text-lg opacity-70">No hay artículos publicados por ahora.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Paginación --}}
            @if($articulos->hasPages())
                <div class="mt-12 pagination-container">
                    {{ $articulos->links() }}
                </div>
            @endif
        </div>
    </section>
</main>

@include('partials.bottom-nav')
@endsection
