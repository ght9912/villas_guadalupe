<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proyectosImagenes extends Model
{
    use HasFactory;

    protected $table = 'proyectos_imagen';

    public function proyecto()
    {
        return $this->belongsTo(Proyectos::class, 'id_proyecto');
    }
}
