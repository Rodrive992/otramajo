<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogArticulo;
use App\Models\BlogComentario;

class BlogComentarioController extends Controller
{
    public function store(Request $request, $articuloId)
    {
        // Validación
        $data = $request->validate([
            'nombre_usuario'     => ['required', 'string', 'max:150'],
            'correo_electronico' => ['required', 'email', 'max:150'],
            'comentario'         => ['required', 'string', 'max:1500'],
        ]);

        // Verificar que el artículo exista
        $articulo = BlogArticulo::findOrFail($articuloId);

        // Crear comentario
        BlogComentario::create([
            'blog_articulo_id'  => $articulo->id,
            'nombre_usuario'    => $data['nombre_usuario'],
            'correo_electronico'=> $data['correo_electronico'],
            'comentario'        => $data['comentario'],
            'fecha_comentario'  => now(),
        ]);

        return redirect()
            ->route('blog.show', $articulo->id)
            ->with('ok', '¡Comentario enviado correctamente!');
    }
}
