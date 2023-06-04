<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LabellingModel extends Model
{
    public function getDataTeksBersih($keyword)
    {
        return DB::table('teks_bersih')
            ->select('teks_bersih.clean_text', 'teks_bersih.label_sentimen', 'data_twitter.user')
            ->where('teks_bersih.clean_text', 'like', '%' . $keyword . '%')
            ->leftJoin('data_twitter', 'teks_bersih.id_tweet', '=', 'data_twitter.id_tweet')
            ->paginate(10);
    }

    public function getTeksBersihCount()
    {
        return DB::table('teks_bersih')->where('label_sentimen', null)->count();
    }
}
