<?php

namespace App\Http\Controllers;

use App\Models\VisualisasiModel;
use Illuminate\Http\Request;

class VisualisasiController extends Controller
{
    public function __construct()
    {
        $this->VisualModel = new VisualisasiModel();
    }

    public function index()
    {
        $dataChart = array();
        foreach ($this->VisualModel->getRiwayat() as $riwayat) {
            array_push($dataChart, array("Positive", $riwayat->predict_positive));
            array_push($dataChart, array("Negative", $riwayat->predict_negative));
        }
        $data = [
            'riwayats' => $this->VisualModel->getRiwayat(),
            'dataChart' => $dataChart,
        ];
        return view('menu.visualisasi', $data);
    }
}
