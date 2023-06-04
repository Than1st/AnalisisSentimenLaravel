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
            ->select('teks_bersih.id_teks_bersih', 'teks_bersih.clean_text', 'teks_bersih.label_sentimen', 'data_twitter.user', 'data_twitter.real_text')
            ->where('teks_bersih.clean_text', 'like', '%' . $keyword . '%')
            ->leftJoin('data_twitter', 'teks_bersih.id_tweet', '=', 'data_twitter.id_tweet')
            ->paginate(10);
    }

    public function getTeksBersih()
    {
        return DB::table('teks_bersih')
            ->select('id_teks_bersih', 'clean_text')
            ->where('label_sentimen', null)
            ->get();
    }

    public function updateTeksBersihByIdTeksBersih($data)
    {
        return DB::table('teks_bersih')->where('id_teks_bersih', $data['id_teks_bersih'])->update($data);
    }

    public function getTeksBersihCount()
    {
        return DB::table('teks_bersih')->where('label_sentimen', null)->count();
    }

    public function getKamusPositif()
    {
        return DB::table('kamus_positif')->select('positive_word')->get();
    }
    public function getKamusNegatif()
    {
        return DB::table('kamus_negatif')->select('negative_word')->get();
    }
}
