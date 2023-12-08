<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StopwordModel extends Model
{
    public function getAllStopword($keyword)
    {
        return DB::table('stopword')
            ->where('stopword', 'like', '%' . $keyword . '%')
            ->paginate(10);
    }

    public function insertStopword($data): bool
    {
        return DB::table('stopword')
            ->insert($data);
    }

    public function deleteStopword($id): bool
    {
        return DB::table('stopword')
            ->where('id_stopword', $id)
            ->delete();
    }

    public function updateStopword($data, $id): bool
    {
        return DB::table('stopword')
            ->where('id_stopword', $id)
            ->update($data);
    }
}
