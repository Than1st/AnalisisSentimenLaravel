<?php

namespace App\Http\Controllers;

use App\Models\SplitModel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SplitController extends Controller
{
    public function __construct()
    {
        $this->SplitModel = new SplitModel();
    }

    public function index()
    {
        $data = [
            'teksBersihCount' => $this->SplitModel->getDataPreprocessingCount(),
            'dataUjiCount' => $this->SplitModel->getDataTestingCount(),
            'dataLatihCount' => $this->SplitModel->getDataTrainingCount(),
            'nullCount' => $this->SplitModel->countNull(),
        ];
        return view('menu.split', $data);
    }

    public function startSplit()
    {
        $collectionDataBersih = $this->SplitModel->getDataPreprocessing();
        $totalDataBersih = $this->SplitModel->getDataPreprocessingCount();
        if ($totalDataBersih % 2 == 0) {
            $stopper = $totalDataBersih * (80 / 100);
        } else {
            $stopper = ceil($totalDataBersih * (80 / 100));
        }

        $counter = 1;
        foreach ($collectionDataBersih as $data) {
            if ($counter <= $stopper) {
                $dataTable = [
                    "user" => $data->user,
                    "created_at" => $data->created_at,
                    "real_text" => $data->real_text,
                    "clean_text" => $data->clean_text,
                    "sentiment_label" => $data->sentiment_label,
                ];
                $this->SplitModel->insertDataTraining($dataTable);
            } else {
                $dataTable = [
                    "user" => $data->user,
                    "created_at" => $data->created_at,
                    "real_text" => $data->real_text,
                    "clean_text" => $data->clean_text,
                    "sentiment_label" => $data->sentiment_label,
                ];
                $this->SplitModel->insertDataTesting($dataTable);
            }
            $counter++;
        }
        Alert::success('Berhasil', 'Berhasil Split Data');
        return redirect('/split');
    }

    public function deleteData()
    {
        $this->SplitModel->deleteDataTraining();
        $this->SplitModel->deleteDataTesting();
        Alert::success('Berhasil', 'Berhasil Hapus Data');
        return redirect('/split');
    }
}
