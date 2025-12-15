<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    // Landing (texto + botones, NO lista videos)
    public function index()
    {
        return view('otramajo.videos.index');
    }

    // Listado: Ejercicios
    public function ejercicios()
    {
        $tipo = 'Ejercicios';

        $videos = Video::query()
            ->where('estado', 'publicado')
            ->where('tipo_video', $tipo)
            ->orderByRaw('orden_videos IS NULL, orden_videos ASC')
            ->orderByDesc('fecha_carga')
            ->paginate(12);

        return view('otramajo.videos.listado', compact('videos', 'tipo'));
    }

    // Listado: Viajes
    public function viajes()
    {
        $tipo = 'Viajes';

        $videos = Video::query()
            ->where('estado', 'publicado')
            ->where('tipo_video', $tipo)
            ->orderByRaw('orden_videos IS NULL, orden_videos ASC')
            ->orderByDesc('fecha_carga')
            ->paginate(12);

        return view('otramajo.videos.listado', compact('videos', 'tipo'));
    }
}
