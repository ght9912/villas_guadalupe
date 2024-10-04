<?php

namespace App\Imports;

use App\Models\Contratos;
use App\Models\Pagos;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContratosImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        // return new Contratos([
        //     'l_fecha' => $row[1],
        //     'l_proyecto' => $row[],
        //     'l_lote' => $row[],
        //     'l_manzana' => $row[],
        //     'Meses' => $row[],
        //     'l_mensualidad' => $row[],
        //     'num_cont' => $row[],
        //     'l_total' => $row[],
        //     'l_anualidad' => $row[],
        //     'total_enganche' => $row[]
        // ]);
    }

    public function headingRow(): int
    {
        return 6;
    }
}
