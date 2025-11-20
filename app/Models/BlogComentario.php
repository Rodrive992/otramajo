<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComentario extends Model
{
    use HasFactory;

    protected $table = 'blog_comentarios';

    protected $fillable = [
        'blog_articulo_id',
        'nombre_usuario',
        'correo_electronico',
        'comentario',
        'fecha_comentario',
    ];

    protected $casts = [
        'fecha_comentario' => 'datetime',
    ];

    // Cada comentario pertenece a un artículo
    public function articulo()
    {
        return $this->belongsTo(BlogArticulo::class, 'blog_articulo_id');
    }
}

