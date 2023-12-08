<?php

namespace App\Http\Controllers;

use App\Models\VisualisasiModel;
use Illuminate\Http\Request;
use LithiumDev\TagCloud\TagCloud;

class VisualisasiController extends Controller
{
    public function __construct()
    {
        $this->VisualModel = new VisualisasiModel();
        $this->cloud = new TagCloud();
    }

    public function index()
    {
        $dataChart = array();
        foreach ($this->VisualModel->getRiwayat() as $riwayat) {
            array_push($dataChart, array("Positive", $riwayat->predict_positive));
            array_push($dataChart, array("Negative", $riwayat->predict_negative));
        }
        $vocabulary = explode(", ", $this->VisualModel->getRiwayat()[0]->vocabulary);
        $weight = explode(", ", $this->VisualModel->getRiwayat()[0]->vocab_weight);
        $wordCloud = [];
        foreach ($vocabulary as $key => $value) {
            array_push($wordCloud, ["'$value'", $weight[$key]]);
        }
        $data = [
            'riwayats' => $this->VisualModel->getRiwayat(),
            'dataChart' => $dataChart,
            'wordCloud' => $wordCloud
        ];
        return view('menu.visualisasi', $data);
    }
}
