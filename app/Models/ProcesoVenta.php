<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Embudos;

class ProcesoVenta extends Model
{
    use HasFactory;

    protected $table = 'proceso_venta';

    public function embudo()
    {
        return $this->belongsTo(Embudos::class, 'id_embudo');
    }
    public function prospectos()
    {
        return $this->hasMany(Prospectos::class, 'status', 'id');
    }

}
