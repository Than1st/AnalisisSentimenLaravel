<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PreprocessingModel extends Model
{
    public function getDataTwitter()
    {
        return DB::table('data_twitter')
            ->select('id_tweet', 'real_text')
            ->where('status_preprocessing', 0)
            ->get();
    }
    public function getDataTeksBersih($keyword)
    {
        return DB::table('teks_bersih')
            ->select('teks_bersih.id_teks_bersih', 'teks_bersih.clean_text', 'teks_bersih.label_sentimen', 'data_twitter.user', 'data_twitter.real_text')
            ->where('teks_bersih.clean_text', 'like', '%' . $keyword . '%')
            ->leftJoin('data_twitter', 'teks_bersih.id_tweet', '=', 'data_twitter.id_tweet')
            ->paginate(10);
    }

    public function insertTeksBersih($data)
    {
        return DB::table('teks_bersih')->insert($data);
    }

    public function updateAllStatusPreprocessing()
    {
        return DB::table('data_twitter')
            ->update(['status_preprocessing' => 1]);
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
        return DB::table('data_twitter')->where('status_preprocessing', 0)->count();
    }
}
