<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fotos_lotes extends Model
{
    use HasFactory;

    protected $table = "fotoslotes";

    public function lotes()
    {
        return $this->belongsTo(lote::class, 'id_lote');
    }
}
