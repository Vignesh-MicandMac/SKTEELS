<?php

namespace App\Imports;

use App\Models\ExecutiveDealerMapping;
use Maatwebsite\Excel\Concerns\ToModel;

class ExecutiveDealerMappingImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ExecutiveDealerMapping([
            //
        ]);
    }
}
