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
}
