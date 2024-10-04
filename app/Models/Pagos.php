<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    use HasFactory;
    public function cliente(){
        return $this->hasOne(clientes::class,"id","id_cliente");
    }

    public function lote(){
        return $this->hasOne(lote::class,"id","id_lote");
    }

    protected $fillable = [
        'id_usuario',
        'total_pago',
        'referencia_pago',
        'concepto',
        'fechas',
    ];

    public function lotes()
    {
        return $this->belongsTo(lote::class, 'id_lote');
    }

    public function proyecto2()
    {
        return $lote = $this->lote()->proyecto_id;
        return proyectos::where("id",)->first();
        return $this->belongsTo(lote::class, 'id_lote');
    }

    public function clientes()
    {
        return $this->belongsTo(clientes::class, 'id_cliente');
    }

    public function proyectoLote($proyecto)
    {
        return proyectos::where("id", $proyecto)->first();
    }

    public function etapaLote($etapa)
    {
        return etapas::where("id", $etapa)->first();
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyectos::class);
    }


    public function etapa()
    {
        return $this->belongsTo(etapas::class);
    }

    public function contratos(){
        return $this->hasMany(Contratos::class,"id_lote","id");
    }

}
