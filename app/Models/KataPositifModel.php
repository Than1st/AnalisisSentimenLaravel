<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KataPositifModel extends Model
{
    public function getAllKataPositif($keyword): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return DB::table('lexicon_positive')
            ->where('positive', 'like', '%' . $keyword . '%')
            ->paginate(10);
    }

    public function insertPositif($data): bool
    {
        return DB::table('lexicon_positive')
            ->insert($data);
    }

    public function deletePositif($id): bool
    {
        return DB::table('lexicon_positive')
            ->where('id_positive', $id)
            ->delete();
    }

    public function updatePositif($data, $id): bool
    {
        return DB::table('lexicon_positive')
            ->where('id_positive', $id)
            ->update($data);
    }
}
