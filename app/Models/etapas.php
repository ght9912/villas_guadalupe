<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class etapas extends Model
{
    use HasFactory;

    protected $fillable = ['etapa','e_name','proyecto_id','ubicacion','precio_cont','precio_fin'];

    public function proyecto(){
        return $this->hasOne(proyectos::class, "id","proyecto_id");
    }

    public function lote(){
        return $this->hasMany(lote::class, "id","lote_id");
    }
    public function ofertas()
    {
        return $this->hasMany(Ofertas::class, 'zona_id');
    }

    protected $visible = [
        'id',
        'etapa',
        'e_name',
        'proyecto_id',
        'ubicacion',
        'precio_cont',
        'precio_fin',
        'proyecto'
    ];

}
