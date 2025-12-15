    @extends('layouts.app')

    @section('title','Admin Blog – OtramaJo')

    @section('content')
    <style>
    :root{
        --om-blanco:#FAF9F6; --om-salvia:#A8C3A0; --om-rosa:#D4A8A1;
        --om-gris-claro:#D3D3D3; --om-arena:#F4E1A1; --om-carbon:#4A4A4A;
    }
    body{ background: var(--om-blanco); color: var(--om-carbon); }
    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { border-bottom: 1px solid var(--om-gris-claro); padding: .75rem; text-align:left; }
    .badge { padding:.2rem .55rem; border-radius:999px; border:1px solid var(--om-gris-claro); background:#fff; }
    .actions a, .actions form button { margin-right:.35rem; }
    </style>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-6">
            <h1 class="om-brand text-3xl">Blog</h1>
            <div class="flex items-center gap-2">
                <a href="{{ route('otramajoadmin.index') }}" class="px-3 py-2 border rounded-lg">← Panel</a>
                <a href="{{ route('otramajoadmin.blog.create') }}" class="px-4 py-2 border rounded-lg bg-white hover:bg-gray-50">+ Nuevo</a>
            </div>
        </div>

        @if(session('ok'))
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3">
                {{ session('ok') }}
            </div>
        @endif

        <div class="bg-white border border-[color:var(--om-gris-claro)] rounded-xl p-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th style="width:180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($articulos as $a)
                    <tr>
                        <td>{{ $a->orden_articulos }}</td>
                        <td>{{ $a->titulo }}</td>
                        <td>{{ \Carbon\Carbon::parse($a->fecha_publicacion)->format('Y-m-d') }}</td>
                        <td><span class="badge">{{ $a->estado }}</span></td>
                        <td class="actions">
                            <a class="px-3 py-1 border rounded-lg" href="{{ route('otramajoadmin.blog.edit', $a->id) }}">Editar</a>
                            <form action="{{ route('otramajoadmin.blog.destroy', $a->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1 border rounded-lg bg-white hover:bg-red-50"
                                        onclick="return confirm('¿Eliminar este artículo?')">Eliminar</button>
                            </form>
                            <a class="px-3 py-1 border rounded-lg" href="{{ route('blog.show', $a->id) }}" target="_blank">Ver</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">Sin artículos aún.</td></tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $articulos->links() }}
            </div>
        </div>
    </div>
    @endsection
