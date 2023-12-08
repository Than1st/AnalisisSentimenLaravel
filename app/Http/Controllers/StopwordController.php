<?php

namespace App\Http\Controllers;

use App\Models\StopwordModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class StopwordController extends Controller
{
    private StopwordModel $StopwordModel;

    public function __construct()
    {
        $this->StopwordModel = new StopwordModel();
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
            'stops' => $this->StopwordModel->getAllStopword($keyword),
        ];
        $data['stops']->appends($request->all());
        return view('menu.stopword', $data);
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
                'stopword' => 'required|alpha|min:3|unique:stopword,stopword',
            ],
            [
                'stopword.required' => 'Kata Wajib Diisi',
                'stopword.min' => 'Kata Minimal 3 Huruf',
                'stopword.unique' => 'Kata Sudah Ada Dalam Kamus',
                'stopword.alpha' => 'Kata Tidak Boleh Berisi Selain Huruf',
            ]
        );

        $data = [
            'stopword' => $request->stopword
        ];
        if ($this->StopwordModel->insertStopword($data)) {
            Alert::success('Berhasil', 'Kata Berhasil di Input');
            return redirect('stopword');
        } else {
            Alert::error('Gagal', 'Kata Gagal di Input');
            return redirect('stopword');
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
                'editStopword' => 'required|alpha|min:3|unique:stopword,stopword',
            ],
            [
                'editStopword.required' => 'Kata Wajib Diisi',
                'editStopword.min' => 'Kata Minimal 3 Huruf',
                'editStopword.unique' => 'Kata Sudah Ada Dalam Kamus',
                'editStopword.alpha' => 'Kata Tidak Boleh Berisi Selain Huruf',
            ]
        );

        $data = [
            'stopword' => $request->editStopword
        ];
        if ($this->StopwordModel->updateStopword($data, $id)) {
            Alert::success('Berhasil', 'Kata Berhasil di Ubah');
            return redirect('stopword');
        } else {
            Alert::error('Gagal', 'Kata Gagal di Ubah');
            return redirect('stopword');
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
        if ($this->StopwordModel->deleteStopword($id)) {
            Alert::success('Berhasil', 'Kata Berhasil dihapus');
            return redirect('stopword');
        } else {
            Alert::error('Gagal', 'Kata Gagal dihapus');
            return redirect('stopword');
        }
    }
}
