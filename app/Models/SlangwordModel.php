<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SlangwordModel extends Model
{
    public function getAllSlangword($keyword)
    {
        return DB::table('slangword')
            ->where('standard', 'like', '%' . $keyword . '%')
            ->orWhere('slangword', 'like', '%' . $keyword . '%')
            ->paginate(10);
    }

    public function insertSlangword($data): bool
    {
        return DB::table('slangword')
            ->insert($data);
    }

    public function deleteSlangword($id): bool
    {
        return DB::table('slangword')
            ->where('id_slangword', $id)
            ->delete();
    }

    public function updateSlangword($data, $id): bool
    {
        return DB::table('slangword')
            ->where('id_slangword', $id)
            ->update($data);
    }
}
