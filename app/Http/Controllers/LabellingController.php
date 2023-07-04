<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LabellingModel;
use Illuminate\Http\Request;
use Sastrawi\Stemmer\StemmerFactory;
use RealRashid\SweetAlert\Facades\Alert;

class LabellingController extends Controller
{
    public function __construct()
    {
        $this->LabelModel = new LabellingModel();
    }

    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $data = [
            'dataPreprocessing' => $this->LabelModel->getDataPreprocessing($keyword),
            'dataPreprocessingCount' => $this->LabelModel->getDataPreprocessingCount(),
            'dataSentimentLabelGroup' => $this->LabelModel->getSentimentLabelGroup(),
        ];
        $data['dataPreprocessing']->appends($request->all());
        return view('menu.labelling', $data);
    }

    public function updateLabelling(Request $request)
    {
        $sentiment = $request->input('sentiment_label');
        $id = $request->input('id_preprocessing');

        $data = [
            'id_preprocessing' => $id,
            'sentiment_label' => $sentiment
        ];
        $this->LabelModel->updateDataPreprocessingByIdPreprocessing($data);
    }

    public function startLabelling()
    {
        $teksBersih = $this->LabelModel->getPreprocessing();
        foreach ($teksBersih as $teks) {
            $data = [
                'id_preprocessing' => $teks->id_preprocessing,
                'sentiment_label' => $this->labelling($teks->clean_text)
            ];
            $this->LabelModel->updateDataPreprocessingByIdPreprocessing($data);
        }
        Alert::success('Berhasil', 'Berhasil Labelling Data');
        return redirect('/labelling');
    }

    public function labelling($text): ?string
    {
        $positives = array();
        foreach ($this->LabelModel->getLexiconPositive() as $pos) {
            $positives[] = $pos->positive;
        }
        $negatives = array();
        foreach ($this->LabelModel->getLexiconNegative() as $neg) {
            $negatives[] = $neg->negative;
        }
        $sentences = explode(" ", $text);
        $positive = 0;
        $negative = 0;
        foreach ($sentences as $sentence) {
            if (in_array($sentence, $positives)) {
                $positive++;
                continue;
            }
            if (in_array($sentence, $negatives)) {
                $negative++;
            }
        }
        $sum = $positive - $negative;
        if ($sum > 0) {
            $label = "positif";
        } else if ($sum < 0) {
            $label = "negatif";
        } else {
            $label = null;
        }

        return $label;
    }
}
