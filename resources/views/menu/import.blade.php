@extends('layout.template')

@section('content')
<style>
    input::file-selector-button {
        font-weight: bold;
        color: white;
        padding: 0.5em;
        background-color: #3158C9;
        border: 1px solid #3158C9;
        border-radius: 3px;
    }

    input[type="file"]::file-selector-button:hover {
        background-color: white;
        color: #3158C9;
        border: 1px solid #3158C9;
    }
</style>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Import Data Excel</h1>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('uploaddata') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <p>Anda bisa melakukan import data dengan format:</p>
            <ul>
                <li>XLS</li>
                <li>XLX</li>
                <li>XLSX</li>
            </ul>
            <div class="form-group">
                <input type="file" class="form-control-file" name="fileImport" onchange="onChangeFile(this.value)">
                @error('fileImport')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <input type="submit" class="btn btn-primary btn-md btn-block" id="btnSubmit" value="Import Data ke Database" onclick="loadingSwal()" disabled>
        </form>
    </div>
</div>
<h1 class="h3 mb-4 text-gray-800">Data Twitter</h1>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <div class="d-flex align-items-center justify-content-between mb-1 p-1">
                <div>
                    <button class="btn btn-danger btn-md btn-block" data-bs-toggle="modal" data-bs-target="#myModal" <?php if (count($tweets) == 0) {
                                                                                                                            echo "disabled";
                                                                                                                        } ?>>Hapus Semua Data</button>
                    <div class="modal" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header bg-danger text-white">
                                    <h4 class="modal-title">Peringatan</h4>
                                    <!-- <i class="fa fa-times" data-bs-dismiss="modal"></i> -->
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    Aksi ini akan menghapus semua yang berkaitan dengan data seperti <b>Preprocessing</b>, <b>Data Uji</b>, dan <b>Data Latih</b>. Apakah anda yakin ingin menghapus data?
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('deletedata') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Hapus</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div></div>
                <div class="d-flex align-items-center justify-content-between">
                    <form action="/import" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control bg-light border-0 small" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" value="{{ request('keyword') }}">
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
                        <th>Created At</th>
                        <th>Real Text</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($tweets) != 0)
                    @foreach($tweets as $tweet)
                    <tr>
                        <td>{{ $tweet->user }}</td>
                        <td>{{ $tweet->created_at }}</td>
                        <td>{{ $tweet->real_text }}</td>
                    </tr>
                    @endforeach
                    @else
                    <td colspan="5" class="text-center">Tidak ada data</td>
                    @endif
                </tbody>
            </table>
            <div>{{ $tweets->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
</div>
<script>
    function onChangeFile(value) {
        document.getElementById("btnSubmit").disabled = false;
    }

    function loadingSwal() {
        Swal.fire({
            title: 'Mohon Tunggu',
            text: 'Sedang melakukan Import Data',
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