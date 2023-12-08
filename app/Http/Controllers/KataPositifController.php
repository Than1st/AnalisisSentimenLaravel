<?php

namespace App\Http\Controllers;

use App\Models\KataPositifModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class KataPositifController extends Controller
{
    private KataPositifModel $PositifModel;

    public function __construct()
    {
        $this->PositifModel = new KataPositifModel();
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $keyword = $request->keyword;
        $data = [
            'positives' => $this->PositifModel->getAllKataPositif($keyword),
        ];
        $data['positives']->appends($request->all());
        return view('menu.positif', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'positif' => 'required|alpha|min:3|unique:lexicon_positive,positive',
            ],
            [
                'positif.required' => 'Kata Wajib Diisi',
                'positif.min' => 'Kata Minimal 3 Huruf',
                'positif.unique' => 'Kata Sudah Ada Dalam Kamus',
                'positif.alpha' => 'Kata Tidak Boleh Berisi Selain Huruf',
            ]
        );

        $data = [
            'positive' => $request->positif
        ];
        if ($this->PositifModel->insertPositif($data)) {
            Alert::success('Berhasil', 'Kata Berhasil di Input');
            return redirect('positif');
        } else {
            Alert::error('Gagal', 'Kata Gagal di Input');
            return redirect('positif');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'editPositif' => 'required|alpha|min:3|unique:lexicon_positive,positive',
            ],
            [
                'editPositif.required' => 'Kata Wajib Diisi',
                'editPositif.min' => 'Kata Minimal 3 Huruf',
                'editPositif.unique' => 'Kata Sudah Ada Dalam Kamus',
                'editPositif.alpha' => 'Kata Tidak Boleh Berisi Selain Huruf',
            ]
        );

        $data = [
            'positive' => $request->editPositif
        ];
        if ($this->PositifModel->updatePositif($data, $id)) {
            Alert::success('Berhasil', 'Kata Berhasil di Ubah');
            return redirect('positif');
        } else {
            Alert::error('Gagal', 'Kata Gagal di Ubah');
            return redirect('positif');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->PositifModel->deletePositif($id)) {
            Alert::success('Berhasil', 'Kata Berhasil dihapus');
            return redirect('positif');
        } else {
            Alert::error('Gagal', 'Kata Gagal dihapus');
            return redirect('positif');
        }
    }
}
