<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LabellingModel extends Model
{
    public function getDataPreprocessing($keyword)
    {
        return DB::table('data_preprocessing')
            ->select('data_preprocessing.id_preprocessing', 'data_preprocessing.clean_text', 'data_preprocessing.sentiment_label', 'data_raw.user', 'data_raw.real_text')
            ->where('data_preprocessing.clean_text', 'like', '%' . $keyword . '%')
            ->leftJoin('data_raw', 'data_preprocessing.id_tweet', '=', 'data_raw.id_tweet')
            ->orderBy('sentiment_label', 'asc')
            ->paginate(10);
    }

    public function getPreprocessing()
    {
        return DB::table('data_preprocessing')
            ->select('id_preprocessing', 'clean_text')
            ->where('sentiment_label', null)
            ->get();
    }

    public function updateDataPreprocessingByIdPreprocessing($data)
    {
        return DB::table('data_preprocessing')->where('id_preprocessing', $data['id_preprocessing'])->update($data);
    }

    public function getDataPreprocessingCount()
    {
        return DB::table('data_preprocessing')->where('sentiment_label', null)->count();
    }

    public function getLexiconPositive()
    {
        return DB::table('lexicon_positive')->select('positive')->get();
    }
    public function getLexiconNegative()
    {
        return DB::table('lexicon_negative')->select('negative')->get();
    }
}
