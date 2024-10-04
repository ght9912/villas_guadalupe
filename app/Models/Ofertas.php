<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ofertas extends Model
{
    public function proyecto()
    {
        return $this->belongsTo(proyectos::class, 'proyecto_id');
    }

    public function etapa()
    {
        return $this->belongsTo(etapas::class, 'zona_id');
    }

    public function lote()
    {
        return $this->belongsTo(lote::class, 'lote_id');
    }
    public function cliente()
    {
        return $this->belongsTo(clientes::class, 'cliente_id');
    }
}
