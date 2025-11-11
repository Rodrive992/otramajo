<?php

namespace App\Http\Controllers;

use App\Models\BlogArticulo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogArticuloController extends Controller
{
    // Página pública: listado
    public function index()
    {
        $articulos = BlogArticulo::publicado()
            ->orderByDesc('fecha_publicacion')
            ->orderByDesc('id')
            ->paginate(9);

        return view('otramajo.blog.index', compact('articulos'));
    }

    // Página pública: detalle
    public function show(BlogArticulo $articulo)
    {
        // Evitar ver borradores en público
        abort_if($articulo->estado !== 'publicado', 404);

        // Sugerencias de lectura (opcional)
        $relacionados = BlogArticulo::publicado()
            ->where('id', '!=', $articulo->id)
            ->latest('fecha_publicacion')
            ->take(3)
            ->get();

        return view('otramajo.blog.show', compact('articulo', 'relacionados'));
    }
}
