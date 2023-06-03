<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PreprocessingModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ToArray;
use Sastrawi\Stemmer\StemmerFactory;

class PreprocessingController extends Controller
{
    public function __construct()
    {
        $this->PreModel = new PreprocessingModel();
    }


    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $data = [
            // 'tweets' => $this->PreModel->getDataPagination($keyword)
            'dataTwitterCount' => $this->PreModel->getDataTwitterCount()
        ];
        // $data['tweets']->appends($request->all());
        return view('menu.preprocessing', $data);
    }
    public function startPreprocessing()
    {
        echo "<script>window.onload = function() {
            successSwal()
        }</script>";
        $data = [
            'dataTwitterCount' => $this->PreModel->getDataTwitterCount()
        ];
        return redirect('/preprocessing');
    }

    public function textPreprocessing($text)
    {
        $caseFolding = $this->caseFolding($text);
        $cleansing = $this->cleanseSentence($caseFolding);
        $slangword = $this->slangwordConversion($cleansing);
        $stopword = $this->stopwordRemoval($slangword);
        $stemming = $this->stemText($stopword);

        return $stemming;
    }

    public function caseFolding($word)
    {
        return strtolower($word);
    }

    function cleanseSentence($sentence)
    {
        // Menghapus karakter-karakter khusus dan tanda baca
        $cleanedSentence = preg_replace('/[^A-Za-z0-9\-#@ ]/', '', $sentence);

        // Menghapus multiple spasi dan menggantinya dengan satu spasi
        $cleanedSentence = preg_replace('/\s+/', ' ', $cleanedSentence);

        // Menghapus angka yang tidak dibutuhkan
        $cleanedSentence = preg_replace('/\d+/', '', $cleanedSentence);

        // Menghapus spasi di awal dan akhir kalimat
        $cleanedSentence = trim($cleanedSentence);

        return $cleanedSentence;
    }

    public function slangwordConversion($text)
    {

        //ambil kamus slangword
        $slangwords = $this->PreModel->getSlangword();
        $words = explode(" ", $text);
        //mengubah collection ke array
        $arrSlangword = array();
        foreach ($slangwords as $value) {
            $arrSlangword[$value->kttdkbaku] = $value->ktbaku;
        }
        $newWord = array();
        foreach ($words as $word) {
            //cek apakah kata ada di dalam kamus
            if (isset($arrSlangword[$word])) {
                $newWord[] = $arrSlangword[$word];
            } else {
                $newWord[] = $word;
            }
        }
        return implode(' ', $newWord);
    }

    public function stopwordRemoval($words)
    {
        //ambil kamus stopword
        $stopwords = $this->PreModel->getStopword();
        $rem_stopword = explode(" ", $words);
        $str_data = array();
        //mengubah collection ke array
        $arrStopword = array();
        foreach ($stopwords as $stop) {
            $arrStopword[] = $stop->stopword;
        }
        foreach ($rem_stopword as $value) {
            //cek apakah kata tidak ada di dalam kamus
            if (!in_array($value, $arrStopword)) {
                $str_data[] = "" . $value;
            }
        }
        return implode(" ", $str_data);
    }

    public function stemText($words)
    {
        // Membuat objek Stemmer
        $stemmerFactory = new StemmerFactory();
        $stemmer = $stemmerFactory->createStemmer();

        // Melakukan stemming pada teks
        $stemmedText = $stemmer->stem($words);

        return $stemmedText;
    }
}
