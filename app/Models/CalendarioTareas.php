<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calendarioTareas extends Model
{
    use HasFactory;

    protected $table = 'calendariotareas';

    public function vendedores()
    {
        return $this->belongsToMany(Vendedores::class, 'calendario_tareas_vendedores', 'id_tarea', 'id_vendedor');
    }
}
