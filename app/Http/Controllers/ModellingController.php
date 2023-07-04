<?php

namespace App\Http\Controllers;

use App\Models\ModellingModel;
use Illuminate\Http\Request;
use Phpml\Classification\NaiveBayes;
use Phpml\Exception\FileException;
use Phpml\Exception\InvalidOperationException;
use Phpml\Exception\SerializeException;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\Tokenization\WhitespaceTokenizer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Phpml\Pipeline;
use Phpml\ModelManager;
use DateTime;
use DateTimeZone;

class ModellingController extends Controller
{
    public function __construct()
    {
        $this->ModellingModel = new ModellingModel();
    }

    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $data = [
            'trainings' => $this->ModellingModel->getAllDataModel($keyword),
            'dataTrainings' => $this->ModellingModel->getDataTraining()
        ];
        $data['trainings']->appends($request->all());
        return view('menu.modelling', $data);
    }

    public function deleteModel(Request $request)
    {
        $this->ModellingModel->deleteModel($request->id_model);
        File::delete(storage_path('models/' . $request->model_name . '.model'));
        Alert::success('Berhasil', 'Sukses Menghapus Model');
        return redirect('/modelling');
    }

    /**
     * @throws SerializeException
     * @throws FileException
     * @throws InvalidOperationException
     */
    public function startModelling()
    {
        $dataTraining = $this->ModellingModel->getDataTraining();
        // Pembuatan Documents
        $documents = [];
        $labels = [];
        foreach ($dataTraining as $data) {
            $documents[] = $data->clean_text;
            $labels[] = $data->sentiment_label;
        }
        // Inisialisasi tokenizer
        $tokenizer = new WhitespaceTokenizer();

        // Inisialisasi vektorisasi token
        $vectorizer = new TokenCountVectorizer($tokenizer);

        // Inisialisasi TF-IDF transformer
        $tfidfTransformer = new TfIdfTransformer();

        // Inisialisasi algoritma klasifikasi Naive Bayes
        $naiveBayes = new NaiveBayes();

        // Definisikan langkah-langkah dalam pipeline
        $pipeline = new Pipeline([$vectorizer, $tfidfTransformer], $naiveBayes);

        // Latih model menggunakan data
        $pipeline->train($documents, $labels);

        // Simpan model ke file
        $dt = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
        $date = $dt->format('d-m-Y h-i-s-A');
        $fileName = 'Model ' . $date;
        // Simpan Info Model ke Database data_model
        $this->saveToDatabase($fileName);
        $modelFile = storage_path('models/' . $fileName . '.model');
        $modelManager = new ModelManager();
        $modelManager->saveToFile($pipeline, $modelFile);
        Alert::success('Berhasil', 'Sukses Membuat Model');
        return redirect('/modelling');
    }

    public function saveToDatabase($fileName)
    {
        $data = [
            'model_name' => $fileName,
            'positive_labels' => $this->ModellingModel->getSentimentPositiveCount(),
            'negative_labels' => $this->ModellingModel->getSentimentNegativeCount(),
        ];
        $this->ModellingModel->insertModel($data);
    }
}
