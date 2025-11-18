<?php

namespace App\Http\Controllers;

use App\Models\BlogArticulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminBlogArticuloController extends Controller
{
    public function index()
    {
        $articulos = BlogArticulo::orderByRaw('orden_articulos IS NULL, orden_articulos ASC')
            ->orderByDesc('fecha_publicacion')
            ->orderByDesc('id')
            ->paginate(10);

        return view('otramajoadmin.blog.index', compact('articulos'));
    }

    public function create()
    {
        $articulo = new BlogArticulo();
        return view('otramajoadmin.blog.form', [
            'mode' => 'create',
            'articulo' => $articulo,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'            => ['required', 'string', 'max:255'],
            'descripcion'       => ['required', 'string'],
            'cuerpo'            => ['required', 'string'],
            'conclusion'        => ['nullable', 'string'],
            'fecha_publicacion' => ['required', 'date'],
            'estado'            => ['required', 'in:publicado,borrador'],
            'orden_articulos'   => [
                'nullable',
                'integer',
                'min:1',
                Rule::unique('blog_articulos', 'orden_articulos'),
            ],
            'imagen_portada'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($request->hasFile('imagen_portada')) {
            $data['imagen_portada'] = $request->file('imagen_portada')->store('blog', 'public');
        }

        BlogArticulo::create($data);

        return redirect()->route('otramajoadmin.blog.index')->with('ok', 'Artículo creado correctamente.');
    }

    public function edit($id)
    {
        $articulo = BlogArticulo::findOrFail($id);
        return view('otramajoadmin.blog.form', [
            'mode' => 'edit',
            'articulo' => $articulo,
        ]);
    }

    public function update(Request $request, $id)
    {
        $articulo = BlogArticulo::findOrFail($id);

        $data = $request->validate([
            'titulo'            => ['required', 'string', 'max:255'],
            'descripcion'       => ['required', 'string'],
            'cuerpo'            => ['required', 'string'],
            'conclusion'        => ['nullable', 'string'],
            'fecha_publicacion' => ['required', 'date'],
            'estado'            => ['required', 'in:publicado,borrador'],
            'orden_articulos'   => [
                'nullable',
                'integer',
                'min:1',
                Rule::unique('blog_articulos', 'orden_articulos')->ignore($articulo->id),
            ],
            'imagen_portada'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'limpiar_imagen'    => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('limpiar_imagen')) {
            if ($articulo->imagen_portada && Storage::disk('public')->exists($articulo->imagen_portada)) {
                Storage::disk('public')->delete($articulo->imagen_portada);
            }
            $data['imagen_portada'] = null;
        } elseif ($request->hasFile('imagen_portada')) {
            if ($articulo->imagen_portada && Storage::disk('public')->exists($articulo->imagen_portada)) {
                Storage::disk('public')->delete($articulo->imagen_portada);
            }
            $data['imagen_portada'] = $request->file('imagen_portada')->store('blog', 'public');
        } else {
            unset($data['imagen_portada']);
        }

        $articulo->update($data);

        return redirect()->route('otramajoadmin.blog.index')->with('ok', 'Artículo actualizado.');
    }

    public function destroy($id)
    {
        $articulo = BlogArticulo::findOrFail($id);
        if ($articulo->imagen_portada && Storage::disk('public')->exists($articulo->imagen_portada)) {
            Storage::disk('public')->delete($articulo->imagen_portada);
        }
        $articulo->delete();

        return back()->with('ok', 'Artículo eliminado.');
    }
}
