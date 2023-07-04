<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SplitModel extends Model
{
    public function getDataPreprocessingCount()
    {
        return DB::table('data_preprocessing')->whereNotNull('sentiment_label')->count();
    }

    public function getDataPreprocessing()
    {
        return DB::table('data_preprocessing')
            ->select('data_raw.user', 'data_raw.created_at', 'data_raw.real_text', 'data_preprocessing.clean_text', 'data_preprocessing.sentiment_label')
            ->leftjoin('data_raw', 'data_preprocessing.id_tweet', '=', 'data_raw.id_tweet')
            ->whereNotNull('data_preprocessing.sentiment_label')
            ->get();
    }

    public function countNull()
    {
        return DB::table('data_preprocessing')->whereNull('sentiment_label')->count();
    }

    public function getDataTestingCount()
    {
        return DB::table('data_testing')->count();
    }

    public function getDataTrainingCount()
    {
        return DB::table('data_training')->count();
    }

    public function insertDataTesting($data)
    {
        return DB::table('data_testing')->insert($data);
    }

    public function insertDataTraining($data)
    {
        return DB::table('data_training')->insert($data);
    }

    public function deleteDataTraining()
    {
        return DB::table('data_training')->delete();
    }

    public function deleteDataTesting()
    {
        return DB::table('data_testing')->delete();
    }
}
