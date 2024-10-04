<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividades extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_vendedor',
        'movimiento',
    ];


    public function prospecto()
    {
        return $this->belongsTo(Prospectos::class, 'prospecto_id');
    }

    public function vendedor()
    {
        return $this->belongsTo(Vendedores::class, 'vendedor_id');
    }

    protected $table = 'actividades';
}
