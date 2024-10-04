<?php

namespace App\Imports;

use App\Models\Pagos;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PagosImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return new Pagos([
            // 'lote' => $row['lote'],
            // 'manzana' => $row['manzana'],
            // 'total_pago' => $row['total_pago'],
            // 'referencia_pago' => $row['referencia_pago'],
            // 'concepto' => $row['concepto'],
            // 'tipo' => $row['tipo'],
            // 'fechas' => $row['fechas'],
            // 'recurrencia' => $row['recurrencia']
        ]);
    }

    public function headingRow(): int
    {
        return 6;
    }
}
