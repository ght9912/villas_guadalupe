<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospectos extends Model
{
    use HasFactory;

    protected $table = 'prospectos';


    public function proyecto()
    {
        return $this->belongsTo(Proyectos::class);
    }


    public function etapa()
    {
        return $this->belongsTo(etapas::class);
    }

    public function procesoVenta()
    {
        return $this->belongsTo(ProcesoVenta::class, 'status', 'id');
    }

}
