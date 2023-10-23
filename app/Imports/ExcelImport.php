<?php

namespace App\Imports;

use App\Models\Filexcel;
use Maatwebsite\Excel\Concerns\ToModel;

class ExcelImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Filexcel([
            'nama'     => $row[0],
            'excel'    => $row[1],
            'user_id'   => $row[2],
        ]);
    }
}
