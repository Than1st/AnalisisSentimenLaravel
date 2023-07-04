<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DataTwitterModel;
use App\Imports\DataTwitterImport;
use App\Models\ImportModel;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class ImportController extends Controller
{
    private ImportModel $ImportModel;

    public function __construct()
    {
        $this->ImportModel = new ImportModel();
    }

    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $keyword = $request->keyword;
        $data = [
            'tweets' => $this->ImportModel->getDataPagination($keyword)
        ];
        $data['tweets']->appends($request->all());
        return view('menu.import', $data);
    }

    public function upload(Request $request)
    {
        request()->validate([
            'fileImport' => 'required|mimes:xlx,xls,xlsx'
        ], [
            'fileImport' => 'Format File tidak sesuai dengan ketentuan diatas'
        ]);
        if (Excel::import(new DataTwitterImport(), $request->file('fileImport'))) {
            Alert::success('Berhasil', 'Data Berhasil di Import');
        } else {
            Alert::error('Gagal', 'Data Gagal di Import');
        }
        return redirect('/import');
    }

    public function deleteData(Request $request)
    {
        if ($this->ImportModel->deleteAllData()) {
            Alert::success('Berhasil', 'Semua Data berhasil di hapus');
        } else {
            Alert::error('Gagal', 'Data Gagal di Hapus');
        }
        return redirect('/import');
    }
}
