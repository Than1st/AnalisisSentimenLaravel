<?php

namespace App\Http\Controllers;

use App\Models\PengujianModel;
use Illuminate\Http\Request;
use Phpml\FeatureExtraction\TfIdfTransformer;
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
        $data = [
            'models' => $this->UjiModel->getAllModel(),
            'testingCount' => $this->UjiModel->getDataUji()->count(),
            'riwayats' => $this->UjiModel->getRiwayat(),
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
        $counter = 1;
        $count = count($testings);
        foreach ($testings as $testing) {
            // Ubah teks menjadi array
            $newTextArray = [$testing->clean_text];

            // Lakukan prediksi menggunakan model yang telah dimuat
            $predictedLabels = $pipeline->predict($newTextArray);

            // Ambil hasil prediksi
            $prediction = $predictedLabels[0];

            if ($testing->sentiment_label == "positif" && $prediction == "positif") {
                $truePositive++;
                $predictPositive++;
            } else if ($testing->sentiment_label == "positif" && $prediction == "negatif") {
                $falseNegative++;
                $predictNegative++;
            } else if ($testing->sentiment_label == "negatif" && $prediction == "negatif") {
                $trueNegative++;
                $predictNegative++;
            } else {
                $falsePositive++;
                $predictPositive++;
            }
            Log::debug("$counter / $count");
            $counter++;
        }
        $arrayUji = $this->UjiModel->getDataUji();
        $dataUji = [];
        foreach ($arrayUji as $uji) {
            $dataUji[] = $uji->clean_text;
        }
        // Inisialisasi tokenizer
        $tokenizer = new WhitespaceTokenizer();

        $vectorizer = new TokenCountVectorizer($tokenizer);
        $vectorizer->fit($dataUji);

        $vectorizer->transform($dataUji);
        $vocabulary = $vectorizer->getVocabulary();
        $vocab = implode(", ", $vocabulary);
        // Menghitung kemunculan kata dalam data uji yang telah ditransformasi
        $wordCounts = [];
        foreach ($dataUji as $document) {
            foreach ($document as $featureIndex => $count) {
                $word = $vocabulary[$featureIndex];
                if (!isset($wordCounts[$word])) {
                    $wordCounts[$word] = 0;
                }
                $wordCounts[$word] += $count;
            }
        }

        // Menampilkan kata-kata yang sering muncul dan jumlah kemunculannya
        $weights = [];
        foreach ($wordCounts as $word => $count) {
            $weights[] = $count;
        }
        $weight = implode(", ", $weights);
        $dt = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
        $date = $dt->format('Y-m-d H:i:s');
        $data = [
            'created_at' => $date,
            'true_positive' => $truePositive,
            'false_positive' => $falsePositive,
            'true_negative' => $trueNegative,
            'false_negative' => $falseNegative,
            'data_testing' => count($testings),
            'data_training' => $request->jumlahSentimen,
            'data_training_positive' => $request->trainingPositif,
            'data_training_negative' => $request->trainingNegatif,
            'predict_positive' => $predictPositive,
            'predict_negative' => $predictNegative,
            'vocabulary' => $vocab,
            'vocab_weight' => $weight,
        ];
        if (count($this->UjiModel->getRiwayat()) == 0) {
            $this->UjiModel->insertRiwayat($data);
            Alert::success('Berhasil', 'Sukses Melakukan Pengujian');
            return redirect('/visualisasi');
        } else {
            $this->UjiModel->updateRiwayat($data);
            Alert::success('Berhasil', 'Sukses Melakukan Pengujian');
            return redirect('/visualisasi');
        }
        Alert::success('Berhasil', '' . $truePositive . '');
        return redirect('/pengujian');
    }
}
