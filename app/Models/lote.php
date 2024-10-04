<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendedores;
use App\Models\clientes;
use App\Models\specslotes;

class lote extends Model
{
    use HasFactory;
    protected $fillable = ['lote','manzana','proyecto_id','etapa_id','ubicacion','superficie','descripcion'];

    public function proyecto(){
        return $this->hasOne(proyectos::class, "id","proyecto_id");
    }

    public function comprador(){
        return $this->hasOne(clientes::class, "id","comprador_id");
    }

    public function vendedor(){
        return $this->hasOne(Vendedores::class, "id","vendedor_id");
    }
    public function etapa(){
        return $this->hasOne(etapas::class, "id","etapa_id");
    }
    public function ofertas(){
        return $this->hasMany(Ofertas::class, 'lote_id');
    }
    public function fotos(){
        return $this->hasMany(fotos_lotes::class, 'lote_id');
    }
    public function specs() {
        return $this->hasMany(specslotes::class, 'lote_id');
    }

}
