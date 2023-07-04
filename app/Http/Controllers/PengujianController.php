<?php

namespace App\Http\Controllers;

use App\Models\PengujianModel;
use Illuminate\Http\Request;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\ModelManager;
use DateTime;
use DateTimeZone;
use Phpml\Tokenization\WhitespaceTokenizer;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class PengujianController extends Controller
{
    public function __construct()
    {
        $this->UjiModel = new PengujianModel();
    }

    public function index()
    {
        $dataChart = array();
        foreach ($this->UjiModel->getRiwayat() as $riwayat) {
            array_push($dataChart, array("Positive", $riwayat->predict_positive));
            array_push($dataChart, array("Negative", $riwayat->predict_negative));
        }
        $data = [
            'models' => $this->UjiModel->getAllModel(),
            'testingCount' => $this->UjiModel->getDataUji()->count(),
            'riwayats' => $this->UjiModel->getRiwayat(),
            'dataChart' => $dataChart,
        ];
        return view('menu.pengujian', $data);
    }

    public function startTesting(Request $request)
    {
        // Buat variabel untuk True positif, true negatif, false positif, false negatif, prediksi positif, dan prediksi negatif
        $truePositive = 0;
        $trueNegative = 0;
        $falsePositive = 0;
        $falseNegative = 0;
        $predictPositive = 0;
        $predictNegative = 0;
        set_time_limit(600);
        // Muat model dari file
        $modelFile = storage_path('models/' . $request->namaModel . '.model');
        $modelManager = new ModelManager();
        $pipeline = $modelManager->restoreFromFile($modelFile);
        $testings = $this->UjiModel->getDataUji();
//        $counter = 1;
//        $count = count($testings);
//        foreach ($testings as $testing) {
//            // Ubah teks menjadi array
//            $newTextArray = [$testing->clean_text];
//
//            // Lakukan prediksi menggunakan model yang telah dimuat
//            $predictedLabels = $pipeline->predict($newTextArray);
//
//            // Ambil hasil prediksi
//            $prediction = $predictedLabels[0];
//
//            if ($testing->sentiment_label == "positif" && $prediction == "positif") {
//                $truePositive++;
//                $predictPositive++;
//            } else if ($testing->sentiment_label == "positif" && $prediction == "negatif") {
//                $falseNegative++;
//                $predictNegative++;
//            } else if ($testing->sentiment_label == "negatif" && $prediction == "negatif") {
//                $trueNegative++;
//                $predictNegative++;
//            } else {
//                $falsePositive++;
//                $predictPositive++;
//            }
//            Log::debug("$counter / $count");
//            $counter++;
//        }
        $arrayUji = $this->UjiModel->getDataUji();
        $dataUji = [];
        foreach ($arrayUji as $uji) {
            $dataUji[] = $uji->clean_text;
        }
        // Inisialisasi tokenizer
        $tokenizer = new WhitespaceTokenizer();

        // Inisialisasi vektorisasi token
        $vectorizer = new TokenCountVectorizer($tokenizer);
        // Build the dictionary.
        $vectorizer->fit($dataUji);

        print_r($vectorizer->getVocabulary());

// Transform the provided text samples into a vectorized list.
//        $vectorizer->transform($samples);
//        $dt = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
//        $date = $dt->format('Y-m-d H:i:s');
//        $data = [
//            'created_at' => $date,
//            'true_positive' => $truePositive,
//            'false_positive' => $falsePositive,
//            'true_negative' => $trueNegative,
//            'false_negative' => $falseNegative,
//            'data_testing' => count($testings),
//            'data_training' => $request->jumlahSentimen,
//            'predict_positive' => $predictPositive,
//            'predict_negative' => $predictNegative
//        ];
//        if ($this->UjiModel->getRiwayat->count() != 0) {
//            $this->UjiModel->insertRiwayat($data);
//            Alert::success('Berhasil', 'Sukses Uji silahkan cek riwayat');
//            return redirect('/pengujian');
//        } else {
//            $this->UjiModel->updateRiwayat($data);
//            Alert::success('Berhasil', 'Sukses Uji silahkan cek riwayat');
//            return redirect('/pengujian');
//        }
//        Alert::success('Berhasil', '' . $truePositive . '');
//        return redirect('/pengujian');
    }
}
