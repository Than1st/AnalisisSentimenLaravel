<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PreprocessingModel extends Model
{
    public function getDataTwitter()
    {
        return DB::table('data_raw')
            ->select('id_tweet', 'real_text')
            ->where('preprocessing_status', 0)
            ->get();
    }
    public function getDataTeksBersih($keyword)
    {
        return DB::table('data_preprocessing')
            ->select('data_preprocessing.id_preprocessing', 'data_preprocessing.clean_text', 'data_preprocessing.sentiment_label', 'data_raw.user', 'data_raw.real_text')
            ->where('data_preprocessing.clean_text', 'like', '%' . $keyword . '%')
            ->leftJoin('data_raw', 'data_preprocessing.id_tweet', '=', 'data_raw.id_tweet')
            ->paginate(10);
    }

    public function insertTeksBersih($data)
    {
        return DB::table('data_preprocessing')->insert($data);
    }

    public function updateAllStatusPreprocessing()
    {
        return DB::table('data_raw')
            ->update(['preprocessing_status' => 1]);
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
            ->select('standard', 'slangword')
            ->get();
    }
    public function getDataTwitterCount()
    {
        return DB::table('data_raw')->where('preprocessing_status', 0)->count();
    }
    public function deleteDataBersih()
    {
        return DB::table('data_preprocessing')->delete();
    }
}
