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
            'teksBersih' => $this->LabelModel->getDataTeksBersih($keyword),
            'teksBersihCount' => $this->LabelModel->getTeksBersihCount()
        ];
        $data['teksBersih']->appends($request->all());
        return view('menu.labelling', $data);
    }

    public function startLabelling()
    {
        $teksBersih = $this->LabelModel->getTeksBersih();
        foreach ($teksBersih as $teks) {
            $data = [
                'id_teks_bersih' => $teks->id_teks_bersih,
                'label_sentimen' => $this->labelling($teks->clean_text)
            ];
            $this->LabelModel->updateTeksBersihByIdTeksBersih($data);
        }
        Alert::success('Berhasil', 'Berhasil Labelling Data');
        return redirect('/labelling');
    }

    public function labelling($text)
    {
        $positives = array();
        foreach ($this->LabelModel->getKamusPositif() as $pos) {
            $positives[] = $pos->positive_word;
        }
        $negatives = array();
        foreach ($this->LabelModel->getKamusNegatif() as $neg) {
            $negatives[] = $neg->negative_word;
        }
        $sentences = explode(" ", $text);
        $positive = 0;
        $negative = 0;
        $label = "";
        foreach ($sentences as $sentence) {
            if (in_array($sentence, $positives)) {
                $positive++;
                continue;
            }
            if (in_array($sentence, $negatives)) {
                $negative++;
            }
        }
        if (($positive - $negative) > 0) {
            $label = "positif";
        } else {
            $label = "negatif";
        }

        return $label;
    }
}
