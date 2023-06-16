<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ImportModel extends Model
{
    public function getDataPagination($keyword)
    {
        return DB::table('data_raw')
            ->where('data_raw.user', 'like', '%' . $keyword . '%')
            ->orwhere('data_raw.real_text', 'like', '%' . $keyword . '%')
            ->paginate(10);
    }

    public function deleteAllData()
    {
        return DB::table('data_raw')
            ->delete();
    }
}
