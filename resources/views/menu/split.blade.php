@extends('layout.template')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Split Data</h1>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="container-flex">
            <div class="row">
                <div class="col-sm">
                    <button class="btn btn-primary btn-md btn-block mb-4" data-bs-toggle="modal" data-bs-target="#myModal">Split Data</button>
                </div>
                <div class="col-sm">
                    <button class="btn btn-danger btn-md btn-block mb-4" data-bs-toggle="modal" data-bs-target="#modalHapus">Hapus Data Uji dan Latih</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-sm-6">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-s font-weight-bold text-primary mb-2">
                                    Jumlah Data Latih</div>
                                <div class="h2 mb-0 font-weight-bold text-gray-800">{{$dataLatihCount}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dumbbell fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-sm-6">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-s font-weight-bold text-primary mb-2">
                                    Jumlah Data Uji</div>
                                <div class="h2 mb-0 font-weight-bold text-gray-800">{{$dataUjiCount}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-vial fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                @if($nullCount == 0)
                @if($teksBersihCount > 0 && $dataLatihCount == 0 && $dataUjiCount == 0)
                Data akan di Split dengan perbandingan 80:20, 80% Data Latih dan 20% Data Uji. <br>
                Jumlah Data bersih yang tersedia sebanyak <b>{{ $teksBersihCount }}</b><br>
                dari data di atas akan menghasilkan <br>
                Data Latih : <b>{{ (ceil($teksBersihCount * (80 / 100))) }}</b><br>
                Data Uji : <b>{{ (ceil($teksBersihCount * (20 / 100))-1) }}</b><br>
                Klik Mulai Untuk Lanjut
                @else
                Tidak ada Data yang bisa di Split, Silahkan ke menu <b>Import Data Excel</b> -> <b>Preprocessing</b> -> <b>Labelling</b> -> Lalu anda bisa melakukan <b>Split</b> data.
                @endif
                @else
                Ada data yang belum diberi Label, Silahkan ke menu <b>Labelling</b> untuk memberikan label
                @endif
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                @if($nullCount == 0)
                @if($teksBersihCount > 0 && $dataLatihCount == 0 && $dataUjiCount == 0)
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('startSplit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" onclick="loadingSwal()">Mulai</button>
                </form>
                @else
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                @endif
                @else
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                @endif
            </div>

        </div>
    </div>
</div>
<div class="modal" id="modalHapus">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-danger text-white">
                <h4 class="modal-title">Pesan</h4>
                <!-- <i class="fa fa-times" data-bs-dismiss="modal"></i> -->
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                @if($dataLatihCount > 0 && $dataUjiCount > 0)
                Data Uji dan Latih akan dihapus, klik "Hapus" untuk melanjutkan.
                @else
                Tidak ada data yang bisa dihapus
                @endif
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                @if($dataLatihCount > 0 && $dataUjiCount > 0)
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('deleteSplit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Hapus</button>
                </form>
                @else
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                @endif
            </div>

        </div>
    </div>
</div>
<script>
    function loadingSwal() {
        Swal.fire({
            title: 'Mohon Tunggu',
            text: 'Sedang melakukan Split Data',
            imageUrl: '{{ asset("image/loading.gif") }}',
            imageWidth: 200,
            imageHeight: 200,
            imageAlt: 'Custom image',
            allowOutsideClick: false,
            showConfirmButton: false
        });
    }
</script>
@include('sweetalert::alert')
@endsection