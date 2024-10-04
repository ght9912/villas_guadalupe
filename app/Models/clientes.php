<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clientes extends Model

{
    use HasFactory;
    public function usuario(){
        return $this->hasOne(User::class,"id","user_id");
    }

    public function lotes(){
        return $this->hasMany(lote::class,"comprador_id","id");
    }

    public function contratos(){
        return $this->hasMany(Contratos::class,"id_cliente","id");
    }
    protected $fillable = [
        'nombre',
        'tipo',
        'email',
        'direccion',
        'celular'
    ];

    // protected $visible = [
    //     'id',
    //     'nombre'
    // ];
}
