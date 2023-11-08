<?php

namespace App\Imports;

use App\Models\Import;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Import([
            '1' => $row[1],
            '2' => $row[2],
            '3' => $row[3],
            '4' => $row[4],
            '5' => $row[5],
            '6' => $row[6],
            '7' => $row[7],
            '8' => $row[8],
            '9' => $row[9],
            '10' => $row[10],
            '11' => $row[11],
            '12' => $row[12],
        ]);
    }
}
