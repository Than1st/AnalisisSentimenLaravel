<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KataNegatifModel extends Model
{
    public function getAllKataNegatif($keyword)
    {
        return DB::table('lexicon_negative')
            ->where('negative', 'like', '%' . $keyword . '%')
            ->paginate(10);
    }

    public function insertNegatif($data): bool
    {
        return DB::table('lexicon_negative')
            ->insert($data);
    }

    public function deleteNegatif($id): bool
    {
        return DB::table('lexicon_negative')
            ->where('id_negative', $id)
            ->delete();
    }

    public function updateNegatif($data, $id): bool
    {
        return DB::table('lexicon_negative')
            ->where('id_negative', $id)
            ->update($data);
    }
}
