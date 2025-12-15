@extends('layouts.app')

@section('title', 'Panel de Administrador – OtramaJo')

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

        .panel-card {
            background: var(--om-blanco);
            border: 1px solid var(--om-gris-claro);
            border-radius: 1rem;
            padding: 1.25rem;
            text-align: center;
            transition: transform .2s ease, box-shadow .2s ease;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .06);
        }

        .panel-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 36px rgba(0, 0, 0, .08);
        }
    </style>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <h1 class="om-brand text-3xl">Panel de Administrador OtraMajo</h1>
            <form method="POST" action="{{ route('otramajoadmin.logout') }}">
                @csrf
                <button class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Salir</button>
            </form>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('otramajoadmin.blog.index') }}" class="panel-card">
                <div class="text-xl font-semibold mb-1">Blog</div>
                <div class="opacity-70">Cargar y administrar artículos</div>
            </a>

            <a href="{{ route('otramajoadmin.videos.index') }}" class="panel-card">
                <div class="text-xl font-semibold mb-1">Videos</div>
                <div class="opacity-70">Cargar y administrar videos</div>
            </a>

            <a href="#" class="panel-card">
                <div class="text-xl font-semibold mb-1">Encuestas</div>
                <div class="opacity-70">Próximamente</div>
            </a>

            <a href="#" class="panel-card">
                <div class="text-xl font-semibold mb-1">Noticias</div>
                <div class="opacity-70">Próximamente</div>
            </a>
        </div>
    </div>
@endsection
