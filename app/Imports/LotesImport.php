<?php

namespace App\Imports;

use App\Models\lote;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class LotesImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
  /**
   * @param array $row
   * 
   * @return User|null
   */
  public function model(array $row)
  {
    return new lote([
      'lote' => $row[1],
      'manzana' => $row['manzana'],
      'etapa' => $row['zona'],
      'superficie' => $row['superficie'],
    ]);
  }

  public function headingRow(): int
    {
        return 13;
    }
}