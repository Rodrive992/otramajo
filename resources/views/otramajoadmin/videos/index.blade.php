@extends('layouts.app')

@section('title','Admin Videos – OtramaJo')

@section('content')
<style>
:root{
    --om-blanco:#FAF9F6; --om-salvia:#A8C3A0; --om-rosa:#D4A8A1;
    --om-gris-claro:#D3D3D3; --om-arena:#F4E1A1; --om-carbon:#4A4A4A;
}
body{ background: var(--om-blanco); color: var(--om-carbon); }
.table { width: 100%; border-collapse: collapse; }
.table th, .table td { border-bottom: 1px solid var(--om-gris-claro); padding: .75rem; text-align:left; vertical-align: top; }
.badge { padding:.2rem .55rem; border-radius:999px; border:1px solid var(--om-gris-claro); background:#fff; }
.actions a, .actions form button { margin-right:.35rem; }
.thumb{
    width: 88px; height: 56px; object-fit: cover;
    border-radius: .75rem; border: 1px solid var(--om-gris-claro);
}
.small{ font-size:.9rem; opacity:.8; }
</style>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="om-brand text-3xl">Videos</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('otramajoadmin.index') }}" class="px-3 py-2 border rounded-lg">← Panel</a>
            <a href="{{ route('otramajoadmin.videos.create') }}" class="px-4 py-2 border rounded-lg bg-white hover:bg-gray-50">+ Nuevo</a>
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
                    <th style="width:110px;">Miniatura</th>
                    <th>Orden</th>
                    <th>Tipo</th>
                    <th>Título</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th style="width:210px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @forelse($videos as $v)
                <tr>
                    <td>
                        <img class="thumb" src="{{ $v->miniatura_url }}" alt="Miniatura">
                    </td>
                    <td>{{ $v->orden_videos }}</td>
                    <td><span class="badge">{{ $v->tipo_video }}</span></td>
                    <td>
                        <div class="font-semibold">{{ $v->titulo }}</div>
                        <div class="small">{!! \Illuminate\Support\Str::limit($v->descripcion, 90) !!}</div>
                    </td>
                    <td>{{ optional($v->fecha_carga)->format('Y-m-d') }}</td>
                    <td><span class="badge">{{ $v->estado }}</span></td>
                    <td class="actions">
                        <a class="px-3 py-1 border rounded-lg" href="{{ route('otramajoadmin.videos.edit', $v->id) }}">Editar</a>

                        <form action="{{ route('otramajoadmin.videos.destroy', $v->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 border rounded-lg bg-white hover:bg-red-50"
                                    onclick="return confirm('¿Eliminar este video?')">Eliminar</button>
                        </form> 
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">Sin videos aún.</td></tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $videos->links() }}
        </div>
    </div>
</div>
@endsection
