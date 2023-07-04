<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VisualisasiModel extends Model
{

    public function getRiwayat()
    {
        return DB::table('data_history')
            ->limit(1)
            ->get();
    }
}
