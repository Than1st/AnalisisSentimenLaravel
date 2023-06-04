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
        Alert::success('Berhasil', 'Data Berhasil di Import');
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

    public function caseFolding($text)
    {
        return strtolower($text);
    }

    function cleanseSentence($text)
    {
        // Menghapus kata yang mengandung karakter spesial
        $cleanedSentence = $this->removeSpecialSentences($text);;

        // Menghapus multiple spasi dan menggantinya dengan satu spasi
        $cleanedSentence = preg_replace('/\s+/', ' ', $cleanedSentence);

        // Menghapus angka yang tidak dibutuhkan
        $cleanedSentence = preg_replace('/\d+/', '', $cleanedSentence);

        // Menghapus spasi di awal dan akhir kalimat
        $cleanedSentence = trim($cleanedSentence);

        return $cleanedSentence;
    }

    function removeSpecialSentences($text)
    {
        // Pisahkan teks menjadi kalimat-kalimat
        $sentences = explode(' ', $text);

        // Buat daftar kalimat baru tanpa karakter spesial
        $cleanSentences = array();
        foreach ($sentences as $sentence) {
            $containsSpecialChar = false;
            $specialChars = array('@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '=', '[', ']', '{', '}', '|', '\\', ';', ':', '\'', '"', ',', '<', '>', '/');

            foreach ($specialChars as $char) {
                if (strpos($sentence, $char) !== false) {
                    $containsSpecialChar = true;
                    break;
                }
            }

            // Tambahkan kalimat ke daftar baru jika tidak mengandung karakter spesial
            if (!$containsSpecialChar) {
                $cleanSentences[] = $sentence;
            }
        }

        // Gabungkan kembali kalimat-kalimat menjadi teks baru
        $cleanText = implode(' ', $cleanSentences);

        return $cleanText;
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
