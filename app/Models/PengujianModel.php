<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class PengujianModel extends Model
{
    public function getDataUji()
    {
        return DB::table('data_testing')
            ->get();
    }

    public function getAllModel()
    {
        return DB::table('data_model')
            ->orderBy('id_model', 'desc')
            ->get();
    }

    public function getRiwayat()
    {
        return DB::table('data_history')
            ->limit(1)
            ->get();
    }

    public function insertRiwayat($data)
    {
        return DB::table('data_history')->insert($data);
    }

    public function updateRiwayat($data)
    {
        return DB::table('data_history')->update($data);
    }
}
