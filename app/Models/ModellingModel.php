<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModellingModel extends Model
{
    public function getDataTraining()
    {
        return DB::table('data_training')->select('clean_text', 'sentiment_label')->get();
    }
    public function getAllDataModel($keyword)
    {
        return DB::table('data_model')
            ->where('model_name', 'like', '%' . $keyword . '%')
            ->orwhere('positive_labels', 'like', '%' . $keyword . '%')
            ->orwhere('negative_labels', 'like', '%' . $keyword . '%')
            ->orderBy('id_model', 'desc')
            ->paginate(10);
    }
    public function getSentimentNegativeCount()
    {
        return DB::table('data_training')->where('sentiment_label', 'negatif')->count();
    }
    public function getSentimentPositiveCount()
    {
        return DB::table('data_training')->where('sentiment_label', 'positif')->count();
    }
    public function insertModel($data)
    {
        return DB::table('data_model')->insert($data);
    }
    public function deleteModel($id_model)
    {
        return DB::table('data_model')->where('id_model', $id_model)->delete();
    }
}
