@extends('layouts.app')

@section('title', ($mode === 'create' ? 'Nuevo' : 'Editar') . ' Video – OtramaJo')

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

        .form-card {
            background: #fff;
            border: 1px solid var(--om-gris-claro);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        label {
            font-size: .9rem;
            opacity: .9;
        }

        input[type="text"],
        input[type="date"],
        input[type="file"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: .6rem;
            padding: .6rem .75rem;
            background: #fff;
        }

        .help {
            font-size: .85rem;
            opacity: .75;
            margin-top: .25rem;
        }

        .preview {
            max-height: 180px;
            border: 1px solid var(--om-gris-claro);
            border-radius: .75rem;
        }
    </style>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-6">
            <h1 class="om-brand text-3xl">{{ $mode === 'create' ? 'Nuevo Video' : 'Editar Video' }}</h1>
            <div class="flex items-center gap-2">
                <a href="{{ route('otramajoadmin.videos.index') }}" class="px-3 py-2 border rounded-lg">← Volver</a>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card">
            <form method="POST"
                action="{{ $mode === 'create' ? route('otramajoadmin.videos.store') : route('otramajoadmin.videos.update', $video->id) }}"
                enctype="multipart/form-data">
                @csrf
                @if ($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="grid md:grid-cols-4 gap-4">
                    <div class="mb-4 md:col-span-2">
                        <label>Tipo de video</label>

                        @php
                            $tipo = old('tipo_video', $video->tipo_video);
                        @endphp

                        <select name="tipo_video" required>
                            <option value="">— Seleccionar tipo —</option>
                            <option value="Ejercicios" {{ $tipo === 'Ejercicios' ? 'selected' : '' }}>Ejercicios</option>
                            <option value="Viajes" {{ $tipo === 'Viajes' ? 'selected' : '' }}>Viajes</option>
                        </select>

                        <div class="help">Se usa para organizar la sección de videos.</div>
                    </div>

                    <div class="mb-4 md:col-span-1">
                        <label>Orden (opcional)</label>
                        <input type="number" name="orden_videos" value="{{ old('orden_videos', $video->orden_videos) }}"
                            min="1" step="1" placeholder="Ej: 1">
                    </div>

                    <div class="mb-4 md:col-span-1">
                        <label>Fecha de carga</label>
                        <input type="date" name="fecha_carga"
                            value="{{ old('fecha_carga', optional($video->fecha_carga)->format('Y-m-d')) }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label>Título</label>
                    <input type="text" name="titulo" value="{{ old('titulo', $video->titulo) }}" required>
                </div>

                <div class="mb-4">
                    <label>Descripción (HTML permitido)</label>
                    <textarea name="descripcion" id="editor-descripcion" rows="4">{{ old('descripcion', $video->descripcion) }}</textarea>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label>Archivo de video {{ $mode === 'create' ? '(obligatorio)' : '(opcional)' }}</label>
                            <input type="file" name="video" accept="video/mp4,video/webm,video/ogg,video/quicktime">
                            <div class="help">Se guarda en storage/public/videos/</div>
                        </div>

                        <div class="mb-4">
                            <label>Miniatura (opcional)</label>
                            <input type="file" name="miniatura" accept=".jpg,.jpeg,.png,.webp">
                            <div class="help">Se guarda en storage/public/videos/thumbs/</div>
                        </div>
                    </div>

                    @if ($mode === 'edit')
                        <div class="grid md:grid-cols-2 gap-6 mt-2">
                            <div>
                                <label class="block mb-2">Miniatura actual</label>
                                <img src="{{ $video->miniatura_url }}" class="preview" alt="Miniatura actual">
                                @if ($video->miniatura)
                                    <label class="inline-flex items-center gap-2 mt-2">
                                        <input type="checkbox" name="limpiar_miniatura" value="1">
                                        <span>Eliminar miniatura</span>
                                    </label>
                                @endif
                            </div>

                            <div>
                                <label class="block mb-2">Video actual</label>
                                @if ($video->video)
                                    <video controls class="w-full rounded-xl border border-[color:var(--om-gris-claro)]"
                                        style="max-height:220px;">
                                        <source src="{{ $video->video_url }}">
                                        Tu navegador no soporta el video.
                                    </video>
                                    <label class="inline-flex items-center gap-2 mt-2">
                                        <input type="checkbox" name="limpiar_video" value="1">
                                        <span>Eliminar video</span>
                                    </label>
                                @else
                                    <div class="help">No hay video cargado.</div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="grid md:grid-cols-3 gap-4 mt-4">
                        <div class="mb-4 md:col-span-1">
                            <label>Estado</label>
                            @php $estado = old('estado', $video->estado ?: 'borrador'); @endphp
                            <select name="estado" required>
                                <option value="borrador" {{ $estado === 'borrador' ? 'selected' : '' }}>borrador</option>
                                <option value="publicado" {{ $estado === 'publicado' ? 'selected' : '' }}>publicado
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <button class="px-4 py-2 border rounded-lg bg-white hover:bg-gray-50" type="submit">
                            {{ $mode === 'create' ? 'Crear' : 'Guardar cambios' }}
                        </button>
                        <a class="px-4 py-2 border rounded-lg"
                            href="{{ route('otramajoadmin.videos.index') }}">Cancelar</a>
                    </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
        <script>
            const editors = {};

            function initEditor(selector, toolbar, key) {
                const el = document.querySelector(selector);
                if (!el) return;

                ClassicEditor.create(el, {
                        toolbar
                    })
                    .then(editor => {
                        editors[key] = editor;
                    })
                    .catch(error => console.error('CKEditor error en ' + selector, error));
            }

            const toolbarCompacto = [
                'undo', 'redo',
                'bold', 'italic', 'underline',
                'bulletedList', 'numberedList',
                'link'
            ];

            initEditor('#editor-descripcion', toolbarCompacto, 'descripcion');

            document.addEventListener('DOMContentLoaded', () => {
                const form = document.querySelector('form[enctype="multipart/form-data"]');
                if (!form) return;

                form.addEventListener('submit', (e) => {
                    // 1) Tomar HTML del editor
                    const html = editors.descripcion ? editors.descripcion.getData().trim() : '';

                    // 2) Convertir a texto y validar
                    const text = html.replace(/<[^>]*>/g, '').replace(/&nbsp;/g, ' ').trim();
                    if (!text) {
                        e.preventDefault();
                        alert('La descripción es obligatoria.');
                        if (editors.descripcion) editors.descripcion.editing.view.focus();
                        return false;
                    }

                    // 3) IMPORTANTÍSIMO: sincronizar el textarea real que se manda al server
                    const textarea = document.querySelector('textarea[name="descripcion"]');
                    if (textarea) textarea.value = html;
                });
            });
        </script>
    @endpush

@endsection
