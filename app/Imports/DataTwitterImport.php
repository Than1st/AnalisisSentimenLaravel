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
        return new DataTwitterModel([
            // 'id_tweet' => $row[11],
            'user' => $row[1],
            'created_at' => '2023-05-30 10:28:32',
            'real_text' => '"' . $row[7] . '"',
        ]);
    }
}
