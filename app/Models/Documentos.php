<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    use HasFactory;

    public function contrato(){
        return $this->hasOne(contratos::class, "id","id_contrato");
    }
}
