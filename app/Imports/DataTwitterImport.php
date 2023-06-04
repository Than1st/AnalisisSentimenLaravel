<?php

namespace App\Imports;

use App\Models\DataTwitterModel;
use Maatwebsite\Excel\Concerns\ToModel;

class DataTwitterImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $UNIX_DATE = ($row[0] - 25569) * 86400;
        $date_column = gmdate("Y-m-d H:i:s", $UNIX_DATE);
        return new DataTwitterModel([
            // 'id_tweet' => $row[11],
            'user' => $row[1],
            'created_at' => $date_column,
            'real_text' => $row[7],
        ]);
    }
}
