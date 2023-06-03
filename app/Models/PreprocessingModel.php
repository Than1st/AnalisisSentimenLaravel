<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PreprocessingModel extends Model
{
    public function getDataPagination($keyword)
    {
        return DB::table('data_twitter')
            ->where('data_twitter.user', 'like', '%' . $keyword . '%')
            ->orwhere('data_twitter.real_text', 'like', '%' . $keyword . '%')
            ->paginate(10);
    }

    public function getStopword()
    {
        return DB::table('stopword')
            ->select('stopword')
            ->get();
    }
    public function getSlangword()
    {
        return DB::table('slangword')
            ->select('ktbaku', 'kttdkbaku')
            ->get();
    }
    public function getDataTwitterCount()
    {
        return DB::table('data_twitter')->count();
    }
}
