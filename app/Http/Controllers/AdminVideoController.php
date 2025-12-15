<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminVideoController extends Controller
{
    public function index()
    {
        $videos = Video::orderByRaw('orden_videos IS NULL, orden_videos ASC')
            ->orderByDesc('fecha_carga')
            ->orderByDesc('id')
            ->paginate(10);

        return view('otramajoadmin.videos.index', compact('videos'));
    }

    public function create()
    {
        $video = new Video();
        return view('otramajoadmin.videos.form', [
            'mode' => 'create',
            'video' => $video,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo_video' => ['required', Rule::in(['Ejercicios','Viajes'])],
            'orden_videos' => ['nullable', 'integer', 'min:1'],
            'titulo'       => ['required', 'string', 'max:255'],
            'descripcion'  => ['required', 'string'],
            'fecha_carga'  => ['required', 'date'],
            'estado'       => ['required', Rule::in(['borrador','publicado'])],

            'video'        => ['required', 'file', 'mimetypes:video/mp4,video/webm,video/ogg,video/quicktime', 'max:512000'], // 500MB
            'miniatura'    => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        // Uploads
        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('videos', 'public');
        }

        if ($request->hasFile('miniatura')) {
            $data['miniatura'] = $request->file('miniatura')->store('videos/thumbs', 'public');
        }

        Video::create($data);

        return redirect()->route('otramajoadmin.videos.index')->with('ok', 'Video creado.');
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);

        return view('otramajoadmin.videos.form', [
            'mode' => 'edit',
            'video' => $video,
        ]);
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);

        $data = $request->validate([
            'tipo_video'   => ['required', 'string', 'max:60'],
            'orden_videos' => ['nullable', 'integer', 'min:1'],
            'titulo'       => ['required', 'string', 'max:255'],
            'descripcion'  => ['required', 'string'],
            'fecha_carga'  => ['required', 'date'],
            'estado'       => ['required', Rule::in(['borrador','publicado'])],

            'video'        => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/ogg,video/quicktime', 'max:512000'],
            'miniatura'    => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

            'limpiar_video'     => ['nullable', 'in:1'],
            'limpiar_miniatura' => ['nullable', 'in:1'],
        ]);

        // Limpiar miniatura
        if ($request->boolean('limpiar_miniatura')) {
            if ($video->miniatura) Storage::disk('public')->delete($video->miniatura);
            $data['miniatura'] = null;
        }

        // Limpiar video
        if ($request->boolean('limpiar_video')) {
            if ($video->video) Storage::disk('public')->delete($video->video);
            $data['video'] = null;
        }

        // Reemplazar archivos
        if ($request->hasFile('miniatura')) {
            if ($video->miniatura) Storage::disk('public')->delete($video->miniatura);
            $data['miniatura'] = $request->file('miniatura')->store('videos/thumbs', 'public');
        }

        if ($request->hasFile('video')) {
            if ($video->video) Storage::disk('public')->delete($video->video);
            $data['video'] = $request->file('video')->store('videos', 'public');
        }

        $video->update($data);

        return redirect()->route('otramajoadmin.videos.index')->with('ok', 'Video actualizado.');
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);

        if ($video->miniatura) Storage::disk('public')->delete($video->miniatura);
        if ($video->video) Storage::disk('public')->delete($video->video);

        $video->delete();

        return redirect()->route('otramajoadmin.videos.index')->with('ok', 'Video eliminado.');
    }
}
