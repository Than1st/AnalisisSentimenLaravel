<?php

namespace App\Http\Controllers;

use App\Models\KataNegatifModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class KataNegatifController extends Controller
{
    private KataNegatifModel $NegatifModel;

    public function __construct()
    {
        $this->NegatifModel = new KataNegatifModel();
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
            'negatives' => $this->NegatifModel->getAllKataNegatif($keyword),
        ];
        $data['negatives']->appends($request->all());
        return view('menu.negatif', $data);
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
                'negatif' => 'required|alpha|min:3|unique:lexicon_negative,negative',
            ],
            [
                'negatif.required' => 'Kata Wajib Diisi',
                'negatif.min' => 'Kata Minimal 3 Huruf',
                'negatif.unique' => 'Kata Sudah Ada Dalam Kamus',
                'negatif.alpha' => 'Kata Tidak Boleh Berisi Selain Huruf',
            ]
        );

        $data = [
            'negative' => $request->negatif
        ];
        if ($this->NegatifModel->insertNegatif($data)) {
            Alert::success('Berhasil', 'Kata Berhasil di Input');
            return redirect('negatif');
        } else {
            Alert::error('Gagal', 'Kata Gagal di Input');
            return redirect('negatif');
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
                'editNegatif' => 'required|alpha|min:3|unique:lexicon_negative,negative',
            ],
            [
                'editNegatif.required' => 'Kata Wajib Diisi',
                'editNegatif.min' => 'Kata Minimal 3 Huruf',
                'editNegatif.unique' => 'Kata Sudah Ada Dalam Kamus',
                'editNegatif.alpha' => 'Kata Tidak Boleh Berisi Selain Huruf',
            ]
        );

        $data = [
            'negative' => $request->editNegatif
        ];
        if ($this->NegatifModel->updateNegatif($data, $id)) {
            Alert::success('Berhasil', 'Kata Berhasil di Ubah');
            return redirect('negatif');
        } else {
            Alert::error('Gagal', 'Kata Gagal di Ubah');
            return redirect('negatif');
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
        if ($this->NegatifModel->deleteNegatif($id)) {
            Alert::success('Berhasil', 'Kata Berhasil dihapus');
            return redirect('negatif');
        } else {
            Alert::error('Gagal', 'Kata Gagal dihapus');
            return redirect('negatif');
        }
    }
}
