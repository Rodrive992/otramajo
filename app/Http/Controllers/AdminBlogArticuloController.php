<?php

namespace App\Http\Controllers;

use App\Models\BlogArticulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
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
            'orden_articulos'   => ['nullable', 'integer', 'min:1'], // <- sin unique
            'imagen_portada'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'imagen_secundaria1'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'imagen_secundaria2'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'imagen_secundaria3'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        return DB::transaction(function () use ($request, $data) {

            // Si vino orden, "insertar" en ese lugar: correr los >= orden
            if (!empty($data['orden_articulos'])) {
                $orden = (int) $data['orden_articulos'];

                BlogArticulo::whereNotNull('orden_articulos')
                    ->where('orden_articulos', '>=', $orden)
                    ->lockForUpdate()
                    ->increment('orden_articulos', 1);
            }

            // Portada
            if ($request->hasFile('imagen_portada')) {
                $data['imagen_portada'] = $request->file('imagen_portada')->store('blog', 'public');
            }
            // Secundarias
            if ($request->hasFile('imagen_secundaria1')) {
                $data['imagen_secundaria1'] = $request->file('imagen_secundaria1')->store('blog', 'public');
            }
            if ($request->hasFile('imagen_secundaria2')) {
                $data['imagen_secundaria2'] = $request->file('imagen_secundaria2')->store('blog', 'public');
            }
            if ($request->hasFile('imagen_secundaria3')) {
                $data['imagen_secundaria3'] = $request->file('imagen_secundaria3')->store('blog', 'public');
            }

            BlogArticulo::create($data);

            return redirect()->route('otramajoadmin.blog.index')->with('ok', 'Artículo creado correctamente.');
        });
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
            'orden_articulos'   => ['nullable', 'integer', 'min:1'], // <- sin unique
            'imagen_portada'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'imagen_secundaria1'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'imagen_secundaria2'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'imagen_secundaria3'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'limpiar_imagen'                => ['nullable', 'boolean'],
            'limpiar_imagen_secundaria1'    => ['nullable', 'boolean'],
            'limpiar_imagen_secundaria2'    => ['nullable', 'boolean'],
            'limpiar_imagen_secundaria3'    => ['nullable', 'boolean'],
        ]);

        return DB::transaction(function () use ($request, $articulo, $data) {

            $oldOrden = $articulo->orden_articulos ? (int)$articulo->orden_articulos : null;
            $newOrden = !empty($data['orden_articulos']) ? (int)$data['orden_articulos'] : null;

            // --- REORDENAMIENTO ---
            if ($newOrden !== $oldOrden) {

                // Caso: antes no tenía orden y ahora sí -> insertar
                if ($oldOrden === null && $newOrden !== null) {
                    BlogArticulo::whereNotNull('orden_articulos')
                        ->where('orden_articulos', '>=', $newOrden)
                        ->lockForUpdate()
                        ->increment('orden_articulos', 1);
                }

                // Caso: antes tenía orden y ahora queda null -> cerrar hueco
                if ($oldOrden !== null && $newOrden === null) {
                    BlogArticulo::whereNotNull('orden_articulos')
                        ->where('id', '!=', $articulo->id)
                        ->where('orden_articulos', '>', $oldOrden)
                        ->lockForUpdate()
                        ->decrement('orden_articulos', 1);
                }

                // Caso: tenía orden y cambia a otra posición
                if ($oldOrden !== null && $newOrden !== null) {

                    if ($newOrden < $oldOrden) {
                        // Se mueve hacia arriba: los del rango [newOrden .. oldOrden-1] suben +1
                        BlogArticulo::whereNotNull('orden_articulos')
                            ->where('id', '!=', $articulo->id)
                            ->whereBetween('orden_articulos', [$newOrden, $oldOrden - 1])
                            ->lockForUpdate()
                            ->increment('orden_articulos', 1);
                    } else {
                        // Se mueve hacia abajo: los del rango [oldOrden+1 .. newOrden] bajan -1
                        BlogArticulo::whereNotNull('orden_articulos')
                            ->where('id', '!=', $articulo->id)
                            ->whereBetween('orden_articulos', [$oldOrden + 1, $newOrden])
                            ->lockForUpdate()
                            ->decrement('orden_articulos', 1);
                    }
                }
            }

            /* -------- PORTADA -------- */
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

            /* -------- SECUNDARIA 1 -------- */
            if ($request->boolean('limpiar_imagen_secundaria1')) {
                if ($articulo->imagen_secundaria1 && Storage::disk('public')->exists($articulo->imagen_secundaria1)) {
                    Storage::disk('public')->delete($articulo->imagen_secundaria1);
                }
                $data['imagen_secundaria1'] = null;
            } elseif ($request->hasFile('imagen_secundaria1')) {
                if ($articulo->imagen_secundaria1 && Storage::disk('public')->exists($articulo->imagen_secundaria1)) {
                    Storage::disk('public')->delete($articulo->imagen_secundaria1);
                }
                $data['imagen_secundaria1'] = $request->file('imagen_secundaria1')->store('blog', 'public');
            } else {
                unset($data['imagen_secundaria1']);
            }

            /* -------- SECUNDARIA 2 -------- */
            if ($request->boolean('limpiar_imagen_secundaria2')) {
                if ($articulo->imagen_secundaria2 && Storage::disk('public')->exists($articulo->imagen_secundaria2)) {
                    Storage::disk('public')->delete($articulo->imagen_secundaria2);
                }
                $data['imagen_secundaria2'] = null;
            } elseif ($request->hasFile('imagen_secundaria2')) {
                if ($articulo->imagen_secundaria2 && Storage::disk('public')->exists($articulo->imagen_secundaria2)) {
                    Storage::disk('public')->delete($articulo->imagen_secundaria2);
                }
                $data['imagen_secundaria2'] = $request->file('imagen_secundaria2')->store('blog', 'public');
            } else {
                unset($data['imagen_secundaria2']);
            }

            /* -------- SECUNDARIA 3 -------- */
            if ($request->boolean('limpiar_imagen_secundaria3')) {
                if ($articulo->imagen_secundaria3 && Storage::disk('public')->exists($articulo->imagen_secundaria3)) {
                    Storage::disk('public')->delete($articulo->imagen_secundaria3);
                }
                $data['imagen_secundaria3'] = null;
            } elseif ($request->hasFile('imagen_secundaria3')) {
                if ($articulo->imagen_secundaria3 && Storage::disk('public')->exists($articulo->imagen_secundaria3)) {
                    Storage::disk('public')->delete($articulo->imagen_secundaria3);
                }
                $data['imagen_secundaria3'] = $request->file('imagen_secundaria3')->store('blog', 'public');
            } else {
                unset($data['imagen_secundaria3']);
            }

            $articulo->update($data);

            return redirect()->route('otramajoadmin.blog.index')->with('ok', 'Artículo actualizado.');
        });
    }


    public function destroy($id)
    {
        $articulo = BlogArticulo::findOrFail($id);

        return DB::transaction(function () use ($articulo) {

            $oldOrden = $articulo->orden_articulos ? (int)$articulo->orden_articulos : null;

            // 1) Borrado físico de todas las imágenes asociadas
            $imagenes = [
                $articulo->imagen_portada,
                $articulo->imagen_secundaria1,
                $articulo->imagen_secundaria2,
                $articulo->imagen_secundaria3,
            ];

            foreach ($imagenes as $img) {
                if ($img && Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
            }

            // 2) Eliminar el registro
            $articulo->delete();

            // 3) Si tenía orden, cerrar el hueco: todos los > oldOrden bajan 1
            if ($oldOrden !== null) {
                BlogArticulo::whereNotNull('orden_articulos')
                    ->where('orden_articulos', '>', $oldOrden)
                    ->lockForUpdate()
                    ->decrement('orden_articulos', 1);
            }

            return back()->with('ok', 'Artículo eliminado.');
        });
    }
}
