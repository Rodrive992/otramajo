<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogArticulo extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'blog_articulos';

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'titulo',
        'descripcion',
        'cuerpo',
        'conclusion',
        'imagen_portada',
        'imagen_secundaria1',
        'imagen_secundaria2',
        'imagen_secundaria3',
        'orden_articulos',
        'fecha_publicacion',
        'estado',
    ];

    // Casts para tipos de datos
    protected $casts = [
        'fecha_publicacion' => 'date',
    ];

    // Scopes personalizados
    public function scopePublicado($query)
    {
        return $query->where('estado', 'publicado');
    }

    public function scopeBorrador($query)
    {
        return $query->where('estado', 'borrador');
    }

    // Accesor para resumen corto (por ejemplo, para previews)
    public function getResumenAttribute()
    {
        return substr(strip_tags($this->descripcion), 0, 120) . '...';
    }
    public function comentarios()
    {
        return $this->hasMany(BlogComentario::class, 'blog_articulo_id')
                    ->orderByDesc('fecha_comentario');
    }
}