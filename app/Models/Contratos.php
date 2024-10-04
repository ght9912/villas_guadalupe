<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contratos extends Model
{
    use HasFactory;

    public function cliente(){
        return $this->hasOne(clientes::class, "id","id_cliente");
    }
    public function lote(){
        return $this->hasOne(lote::class, "id","id_lote");
    }
    public function pagos(){
        return $this->hasMany(Pagos::class, "id_lote","id_lote")->where("id_cliente", $this->id_cliente);
    }
    public function documentos(){
        return $this->hasOne(Documentos::class, "id_contrato","id");
    }
}
