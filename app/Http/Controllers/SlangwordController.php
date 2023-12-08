<?php

namespace App\Http\Controllers;

use App\Models\SlangwordModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class SlangwordController extends Controller
{
    private SlangwordModel $SlangwordModel;

    public function __construct()
    {
        $this->SlangwordModel = new SlangwordModel();
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
            'slangs' => $this->SlangwordModel->getAllSlangword($keyword),
        ];
        $data['slangs']->appends($request->all());
        return view('menu.slangword', $data);
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
                'slangword' => 'required|min:3|unique:slangword,slangword',
                'standard' => 'required|alpha|min:3',
            ],
            [
                'slangword.required' => 'Kata Wajib Diisi',
                'slangword.min' => 'Kata Minimal 3 Huruf',
                'slangword.unique' => 'Kata Sudah Ada Dalam Kamus',
                'standard.required' => 'Kata Wajib Diisi',
                'standard.min' => 'Kata Minimal 3 Huruf',
                'standard.alpha' => 'Kata Tidak Boleh Berisi Selain Huruf',
            ]
        );

        $data = [
            'slangword' => $request->slangword,
            'standard' => $request->standard,
        ];
        if ($this->SlangwordModel->insertSlangword($data)) {
            Alert::success('Berhasil', 'Kata Berhasil di Input');
            return redirect('slangword');
        } else {
            Alert::error('Gagal', 'Kata Gagal di Input');
            return redirect('slangword');
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
                'editSlangword' => 'required|min:3|unique:slangword,slangword',
                'editStandard' => 'required|alpha|min:3',
            ],
            [
                'editSlangword.required' => 'Kata Wajib Diisi',
                'editSlangword.min' => 'Kata Minimal 3 Huruf',
                'editSlangword.unique' => 'Kata Sudah Ada Dalam Kamus',
                'editStandard.required' => 'Kata Wajib Diisi',
                'editStandard.min' => 'Kata Minimal 3 Huruf',
                'editStandard.alpha' => 'Kata Tidak Boleh Berisi Selain Huruf',
            ]
        );

        $data = [
            'slangword' => $request->editSlangword,
            'standard' => $request->editStandard,
        ];
        if ($this->SlangwordModel->updateSlangword($data, $id)) {
            Alert::success('Berhasil', 'Kata Berhasil di Ubah');
            return redirect('slangword');
        } else {
            Alert::error('Gagal', 'Kata Gagal di Ubah');
            return redirect('slangword');
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
        if ($this->SlangwordModel->deleteSlangword($id)) {
            Alert::success('Berhasil', 'Kata Berhasil dihapus');
            return redirect('slangword');
        } else {
            Alert::error('Gagal', 'Kata Gagal dihapus');
            return redirect('slangword');
        }
    }
}
