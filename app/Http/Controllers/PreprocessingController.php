<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PreprocessingModel;
use Illuminate\Http\Request;
use Sastrawi\Stemmer\StemmerFactory;
use RealRashid\SweetAlert\Facades\Alert;

class PreprocessingController extends Controller
{
    public function __construct()
    {
        $this->PreModel = new PreprocessingModel();
        $stemmerFactory = new StemmerFactory();
        $this->Stemmer = $stemmerFactory->createStemmer();
        $this->StopWords = $this->PreModel->getStopword();
    }

    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $data = [
            'teks_bersih' => $this->PreModel->getDataTeksBersih($keyword),
            'dataTwitterCount' => $this->PreModel->getDataTwitterCount()
        ];
        $data['teks_bersih']->appends($request->all());
        return view('menu.preprocessing', $data);
    }

    public function deletePreprocessing()
    {
        $this->PreModel->deleteDataBersih();
        Alert::success('Berhasil', 'Data Berhasil di Import');
        return redirect('/preprocessing');
    }

    public function startPreprocessing()
    {
        $dataTwitter = $this->PreModel->getDataTwitter();
        foreach ($dataTwitter as $data) {
            $teksBersih = $this->textPreprocessing($data->real_text);
            if ($teksBersih != null) {
                $arrTeksBersih = [
                    'id_tweet' => $data->id_tweet,
                    'clean_text' => $teksBersih
                ];
                $this->PreModel->insertTeksBersih($arrTeksBersih);
            }
        }
        $this->PreModel->updateAllStatusPreprocessing();
        Alert::success('Berhasil', 'Data Berhasil di Preprocessing');
        return redirect('/preprocessing');
    }

    public function textPreprocessing($text)
    {
        $casefolding = $this->caseFolding($text);
        $cleansing = $this->cleanseSentence($casefolding);
        $slangword = $this->slangwordConversion($cleansing);
        $stopword = $this->stopwordRemoval($slangword);
        $stemming = $this->stemText($stopword);

        return $stemming;
    }

    public function caseFolding($text)
    {
        return strtolower($text);
    }

    function cleanseSentence($kalimat)
    {
        // Menghapus mention
        $kalimat = preg_replace('/@\w+/', '', $kalimat);

        // Menghapus hashtag
        $kalimat = preg_replace('/#\w+/', '', $kalimat);

        // Menghapus link
        $kalimat = preg_replace('/https?:\/\/[^\s]+/', '', $kalimat);

        // Menghapus selain angka dan huruf
        $kalimat = preg_replace('/[^A-Za-z0-9\s]+/', '', $kalimat);

        // Menghapus spasi berlebih
        $kalimat = preg_replace('/\s+/', ' ', $kalimat);

        // Menghapus kata yang hanya memiliki 1 atau 2 huruf
        $kata = explode(' ', $kalimat);
        $kata = array_filter($kata, function ($value) {
            return strlen($value) > 2;
        });
        $kalimat = implode(' ', $kata);

        return $kalimat;
    }

    public function slangwordConversion($text)
    {

        //ambil kamus slangword
        $slangwords = $this->PreModel->getSlangword();
        $words = explode(" ", $text);
        //mengubah collection ke array
        $arrSlangword = array();
        foreach ($slangwords as $value) {
            $arrSlangword[$value->slangword] = $value->standard;
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

    public function stopwordRemoval($slangword)
    {
        $stopWords = $this->StopWords;
        $words = explode(" ", $slangword);
        $str_data = array();
        //mengubah collection ke array
        $arrStopword = array();
        foreach ($stopWords as $stop) {
            $arrStopword[] = $stop->stopword;
        }
        foreach ($words as $word) {
            //cek apakah kata tidak ada di dalam kamus
            if (!in_array($word, $arrStopword)) {
                $str_data[] = "" . $word;
            }
        }
        return implode(" ", $str_data);
    }

    public function stemText($words)
    {
        // Melakukan stemming pada teks
        $stemmedText = $this->Stemmer->stem($words);

        return $stemmedText;
    }
}
