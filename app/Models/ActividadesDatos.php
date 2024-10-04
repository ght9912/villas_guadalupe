<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadesDatos extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_actividad',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function actividad()
    {
        return $this->belongsTo(Actividades::class, 'id_actividad');
    }

    protected $table = 'actividades_datos';
}
