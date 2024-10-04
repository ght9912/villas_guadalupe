<?php

namespace App\Imports;

use App\Models\clientes;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class ClientesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {

        return new clientes([
            'nombre'     => $row[0],
            'tipo'     => $row[1],
            'email'    => $row[2],
            'direccion'    => $row[3],
            'celular'    => $row[4],
        ]);
    }

}
