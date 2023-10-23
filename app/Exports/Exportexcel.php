<?php

namespace App\Exports;
use App\Models\Filexcel;

use Maatwebsite\Excel\Concerns\FromCollection;

class Exportexcel implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Define the data you want to export as a collection
        return Filexcel::all();
    }
}
