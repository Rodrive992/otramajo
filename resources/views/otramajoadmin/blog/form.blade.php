@extends('layouts.app')

@section('title', ($mode === 'create' ? 'Nuevo' : 'Editar') . ' Artículo – OtramaJo')

@section('content')
<style>
:root{
    --om-blanco:#FAF9F6; --om-salvia:#A8C3A0; --om-rosa:#D4A8A1;
    --om-gris-claro:#D3D3D3; --om-arena:#F4E1A1; --om-carbon:#4A4A4A;
}
body{ background: var(--om-blanco); color: var(--om-carbon); }
.form-card{
    background:#fff; border:1px solid var(--om-gris-claro); border-radius:1rem; padding:1.25rem;
}
label{ font-size:.9rem; opacity:.9; }
input[type="text"], input[type="date"], input[type="file"], input[type="number"], textarea, select{
    width:100%; border:1px solid #d1d5db; border-radius:.6rem; padding:.6rem .75rem; background:#fff;
}
</style>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="om-brand text-3xl">{{ $mode === 'create' ? 'Nuevo Artículo' : 'Editar Artículo' }}</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('otramajoadmin.blog.index') }}" class="px-3 py-2 border rounded-lg">← Volver</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <form method="POST"
              action="{{ $mode === 'create' ? route('otramajoadmin.blog.store') : route('otramajoadmin.blog.update',$articulo->id) }}"
              enctype="multipart/form-data">
            @csrf
            @if($mode === 'edit') @method('PUT') @endif

            <div class="mb-4">
                <label>Título</label>
                <input type="text" name="titulo" value="{{ old('titulo',$articulo->titulo) }}" required>
            </div>

            <div class="mb-4">
                <label>Descripción (resumen)</label>
                <textarea name="descripcion" rows="3" required>{{ old('descripcion',$articulo->descripcion) }}</textarea>
            </div>

            <div class="mb-4">
                <label>Cuerpo (HTML permitido)</label>
                <textarea name="cuerpo" rows="10" required>{{ old('cuerpo',$articulo->cuerpo) }}</textarea>
            </div>

            <div class="mb-4">
                <label>Conclusión (opcional)</label>
                <textarea name="conclusion" rows="3">{{ old('conclusion',$articulo->conclusion) }}</textarea>
            </div>

            <div class="grid md:grid-cols-4 gap-4">
                <div class="mb-4 md:col-span-1">
                    <label>Orden del artículo (opcional)</label>
                    <input type="number" name="orden_articulos"
                           value="{{ old('orden_articulos', $articulo->orden_articulos) }}"
                           min="1" step="1"
                           placeholder="Ej: 1">
                </div>
                <div class="mb-4 md:col-span-1">
                    <label>Fecha de publicación</label>
                    <input type="date" name="fecha_publicacion"
                           value="{{ old('fecha_publicacion', optional($articulo->fecha_publicacion)->format('Y-m-d')) }}" required>
                </div>
                <div class="mb-4 md:col-span-1">
                    <label>Estado</label>
                    <select name="estado" required>
                        @php $estado = old('estado',$articulo->estado ?: 'borrador'); @endphp
                        <option value="borrador"  {{ $estado==='borrador' ? 'selected':'' }}>borrador</option>
                        <option value="publicado" {{ $estado==='publicado'? 'selected':'' }}>publicado</option>
                    </select>
                </div>
                <div class="mb-4 md:col-span-1">
                    <label>Imagen de portada (opcional)</label>
                    <input type="file" name="imagen_portada" accept=".jpg,.jpeg,.png,.webp">
                </div>
            </div>

            @if($mode==='edit' && $articulo->imagen_portada)
                <div class="mb-4">
                    <label class="block mb-1">Imagen actual</label>
                    <img src="{{ asset('storage/'.$articulo->imagen_portada) }}" alt="actual" class="max-h-40 rounded border">
                    <label class="inline-flex items-center gap-2 mt-2">
                        <input type="checkbox" name="limpiar_imagen" value="1">
                        <span>Eliminar imagen</span>
                    </label>
                </div>
            @endif

            <div class="mt-6 flex items-center gap-3">
                <button class="px-4 py-2 border rounded-lg bg-white hover:bg-gray-50" type="submit">
                    {{ $mode==='create' ? 'Crear' : 'Guardar cambios' }}
                </button>
                <a class="px-4 py-2 border rounded-lg" href="{{ route('otramajoadmin.blog.index') }}">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
