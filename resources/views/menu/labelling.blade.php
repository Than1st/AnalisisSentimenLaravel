@extends('layout.template')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Labelling</h1>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <div class="d-flex align-items-center justify-content-between mb-1 p-1">
                <div>
                    <button class="btn btn-primary btn-md btn-block" data-bs-toggle="modal" data-bs-target="#myModal">Labelling Data</button>
                    <div class="modal" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header bg-primary text-white">
                                    <h4 class="modal-title">Pesan</h4>
                                    <!-- <i class="fa fa-times" data-bs-dismiss="modal"></i> -->
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    @if ($teksBersihCount == 0)
                                    Tidak ada Data yang bisa di Preprocessing, Silahkan ke menu <b>Import Data Excel</b> untuk import Data
                                    @else
                                    <b>{{ $teksBersihCount }}</b> Data akan dilakukan Labelling Otomatis Berdasarkan Kamus, tekan mulai untuk melanjutkan.
                                    @endif
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    @if ($teksBersihCount == 0)
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                    @else
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('startLabelling') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <button type="submit" class="btn btn-primary" onclick="loadingSwal()" data-bs-dismiss="modal">Mulai</button>
                                    </form>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div></div>
                <div class="d-flex align-items-center justify-content-between">
                    <form action="/preprocessing" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" name="keyword" id="keretaSearch" class="form-control bg-light border-0 small" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" value="{{ request('keyword') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Clean Text</th>
                        <th>Label Sentimen</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($teksBersih) != 0)
                    @foreach($teksBersih as $teks)
                    <tr>
                        <td>{{ $teks->user }}</td>
                        <td>{{ $teks->clean_text }}</td>
                        @if($teks->label_sentimen == "positif")
                        <td align="center"><span class="badge bg-success text-white" style="font-size: 18px;">Positif</span></td>
                        @elseif($teks->label_sentimen == "negatif")
                        <td align="center"><span class="badge bg-danger text-white" style="font-size: 16px;">Negatif</span></td>
                        @else
                        <td align="center"><span class="badge bg-secondary text-white">Belum diberi Label</span></td>
                        @endif
                        <td align="center">
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#modaldetail{{ $teks->id_teks_bersih }}"><span class="fa fa-bars"></span></button>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <td colspan="5" class="text-center">Tidak ada data</td>
                    @endif
                </tbody>
            </table>
            <div>{{ $teksBersih->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
</div>
<script>
    function loadingSwal() {
        Swal.fire({
            title: 'Mohon Tunggu',
            text: 'Sedang melakukan Labelling',
            imageUrl: '{{ asset("image/loading.gif") }}',
            imageWidth: 200,
            imageHeight: 200,
            imageAlt: 'Custom image',
            allowOutsideClick: false,
            showConfirmButton: false
        });
    }

    // const successSwal = function() {
    //     Swal.fire({
    //         icon: 'success',
    //         title: 'Selesai!',
    //         text: 'Berhasil Preprocessing Data',
    //         allowOutsideClick: false,
    //         confirmButtonColor: 'rgb(67,105,215)',
    //     });
    // };
</script>
@include('sweetalert::alert')
@include('modal.m_labelling_detail')
@endsection