<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class specslotes extends Model
{
    use HasFactory;

    protected $table = "specslotes";

    public function lotes()
    {
        return $this->belongsTo(lote::class, 'id_lote');
    }
}
