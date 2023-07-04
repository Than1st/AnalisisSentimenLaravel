<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LabellingModel extends Model
{
    public function getDataPreprocessing($keyword): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return DB::table('data_preprocessing')
            ->select('data_preprocessing.id_preprocessing', 'data_preprocessing.clean_text', 'data_preprocessing.sentiment_label', 'data_raw.user', 'data_raw.real_text')
            ->where('data_raw.user', 'like', '%' . $keyword . '%')
            ->where('data_preprocessing.clean_text', 'like', '%' . $keyword . '%')
            ->orWhere('data_preprocessing.sentiment_label', 'like', '%' . $keyword . '%')
            ->leftJoin('data_raw', 'data_preprocessing.id_tweet', '=', 'data_raw.id_tweet')
            ->orderBy('sentiment_label', 'asc')
            ->paginate(10);
    }

    public function getPreprocessing(): \Illuminate\Support\Collection
    {
        return DB::table('data_preprocessing')
            ->select('id_preprocessing', 'clean_text')
            ->where('sentiment_label', null)
            ->get();
    }

    function getSentimentLabelGroup(): array
    {
        return DB::select("SELECT `sentiment_label` FROM `data_preprocessing` GROUP BY `sentiment_label`");
    }

    public function updateDataPreprocessingByIdPreprocessing($data): int
    {
        return DB::table('data_preprocessing')->where('id_preprocessing', $data['id_preprocessing'])->update($data);
    }

    public function getDataPreprocessingCount(): int
    {
        return DB::table('data_preprocessing')->where('sentiment_label', null)->count();
    }

    public function getLexiconPositive(): \Illuminate\Support\Collection
    {
        return DB::table('lexicon_positive')->select('positive')->get();
    }

    public function getLexiconNegative(): \Illuminate\Support\Collection
    {
        return DB::table('lexicon_negative')->select('negative')->get();
    }
}
