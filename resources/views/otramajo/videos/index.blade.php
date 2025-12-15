@extends('layouts.app')

@section('title', 'OtraMajo – Videos')

@section('content')
    <style>
        :root {
            --om-blanco: #FAF9F6;
            --om-salvia: #A8C3A0;
            --om-rosa: #D4A8A1;
            --om-gris-claro: #D3D3D3;
            --om-arena: #F4E1A1;
            --om-carbon: #4A4A4A;
        }

        body {
            background: var(--om-blanco);
            color: var(--om-carbon);
        }

        .pt-header {
            padding-top: 140px;
        }

        .om-sep {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(74, 74, 74, .25), transparent);
        }

        .om-brand {
            font-family: "Cormorant Garamond", serif;
        }

        .om-nav {
            font-family: "Quicksand", system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
        }

        .about-section {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--om-blanco) 0%, rgba(212, 168, 161, .10) 100%);
        }

        .floating-element {
            position: absolute;
            border-radius: 50%;
            opacity: .08;
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

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .hero-band {
            background: linear-gradient(135deg, var(--om-rosa) 0%, var(--om-arena) 100%);
            border: 1px solid rgba(212, 168, 161, 0.3);
            border-radius: 1.5rem;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, .08);
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .hero-band::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM90 14c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM40 21c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM63 10c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM57 70c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM86 92c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 4.999-2.24 4.999-5s-2.239-5-4.999-5-5 2.24-5 5 2.24 5 5 5zM88 50c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM79 29c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: .3;
            z-index: -1;
        }

        .hero-band h2 {
            font-family: "Cormorant Garamond", serif;
            font-size: 2rem;
            margin-bottom: .5rem;
            font-weight: 600;
        }

        .hero-band p {
            font-size: 1.05rem;
            opacity: .9;
        }

        .filter-wrap {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: .75rem;
            margin-top: 1.25rem;
        }

        .filter-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            padding: .75rem 1.1rem;
            border-radius: 999px;
            border: 1px solid var(--om-gris-claro);
            background: rgba(250, 249, 246, .85);
            backdrop-filter: blur(10px);
            color: var(--om-carbon);
            text-decoration: none;
            font-weight: 600;
            transition: all .25s ease;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .06);
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            border-color: var(--om-salvia);
            box-shadow: 0 14px 36px rgba(0, 0, 0, .10);
        }

        .filter-btn.active {
            background: var(--om-salvia);
            border-color: var(--om-salvia);
            color: #1f2a1f;
            box-shadow: 0 10px 24px rgba(168, 195, 160, .35);
        }

        .filter-btn.secondary.active {
            background: var(--om-arena);
            border-color: var(--om-arena);
            color: #2b2413;
            box-shadow: 0 10px 24px rgba(244, 225, 161, .35);
        }

        .section-hint {
            text-align: center;
            font-size: .95rem;
            opacity: .75;
            margin-top: .75rem;
        }

        @media (max-width:768px) {
            .pt-header {
                padding-top: 100px;
            }

            .hero-band {
                padding: 1.5rem;
            }

            .hero-band h2 {
                font-size: 1.55rem;
            }

            .floating-element {
                display: none;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .floating-element {
                animation: none !important;
            }

            .filter-btn:hover {
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
                <div class="text-center mb-10">
                    <h1 class="om-brand text-4xl md:text-5xl font-semibold mb-4">Videos</h1>
                    <div class="om-sep max-w-md mx-auto"></div>

                    <p class="mt-6 text-lg opacity-80 max-w-3xl mx-auto">
                        Este espacio es para compartir videos que puedan ayudar a los demás en lo referente a
                        <strong>ejercicios y rehabilitación</strong>, utilidades para personas con secuelas de
                        <strong>accidentes cerebrovasculares</strong>, herramientas y recursos prácticos.
                        También voy a subir videos de mi pasión: <strong>los viajes</strong>, con tips para viajar y
                        recomendaciones de lugares adaptados.
                    </p>
                </div>

                {{-- Cintillo destacado --}}
                <div class="hero-band mb-10">
                    <h2 class="text-2xl md:text-3xl mb-2">“Compartir para que sea más fácil”</h2>
                    <p>Elegí una categoría para ver el contenido</p>

                    <div class="filter-wrap">
                        <a href="{{ route('videos.ejercicios') }}" class="filter-btn">
                            🧘‍♀️ Ejercicios
                        </a>

                        <a href="{{ route('videos.viajes') }}" class="filter-btn secondary">
                            ✈️ Viajes
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.bottom-nav')
@endsection
