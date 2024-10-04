<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proyectos extends Model
{
    use HasFactory;

    public function user(){
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function etapas(){
        return $this->hasMany(etapas::class, "id","etapa_id");
    }

    public function lotes(){
        return $this->hasMany(lote::class, "id","lotes_id");
    }

    protected $visible = [
        'id',
        'nombre',
        'clave',
        'descripcion',
        'ubicacion',
        'estado',
        'user_id',
        'enajenante',
        'portada',
        'user'
    ];
    public function ofertas()
    {
        return $this->hasMany(Ofertas::class, 'proyecto_id');
    }

}
