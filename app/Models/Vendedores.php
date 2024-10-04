<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendedores extends Model
{
    use HasFactory;

    public function usuario(){
        return $this->hasOne(User::class,"id","user_id");
    }

    // protected $visible = [
    //     'id',
    //     'nombre'
    // ];

    public function calendarioTareas()
    {
        return $this->belongsToMany(calendarioTareas::class, 'calendario_tareas_vendedores', 'id_vendedor', 'id_tarea');
    }
}
