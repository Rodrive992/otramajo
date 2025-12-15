<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Video extends Model
{
    protected $table = 'videos';

    protected $fillable = [
        'tipo_video',    
        'orden_videos',
        'titulo',
        'descripcion',
        'video',
        'miniatura',
        'fecha_carga',
        'estado',
    ];

    protected $casts = [
        'fecha_carga' => 'date',
        'orden_videos' => 'integer',
    ];

    /* Helpers opcionales (útiles en Blade) */
    public function getMiniaturaUrlAttribute(): string
    {
        $img = $this->miniatura;

        if ($img && Str::startsWith($img, ['http://', 'https://'])) {
            return $img;
        }

        return $img
            ? asset('storage/' . ltrim($img, '/'))
            : asset('images/placeholder-om.jpg');
    }

    public function getVideoUrlAttribute(): string
    {
        $v = $this->video;

        if ($v && Str::startsWith($v, ['http://', 'https://'])) {
            return $v;
        }

        return asset('storage/' . ltrim($v, '/'));
    }
}
