<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embudos extends Model
{
    use HasFactory;

    protected $table = 'embudos';

    public function procesos()
    {
        return $this->hasMany(ProcesoVenta::class, 'id_embudo');
    }
}
