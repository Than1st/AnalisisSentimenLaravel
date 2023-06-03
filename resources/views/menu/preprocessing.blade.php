@extends('layout.template')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Preprocessing</h1>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <div class="d-flex align-items-center justify-content-between mb-1 p-1">
                <div>
                    <!-- <script>
                        window.onload = function() {
                            successSwal()
                        }
                    </script> -->
                    <form action="{{ route('startPreprocessing') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <button type="submit">test</button>
                    </form>
                    <button class="btn btn-primary btn-md btn-block" data-bs-toggle="modal" data-bs-target="#myModal" <?php if ($dataTwitterCount == 0) {
                                                                                                                            echo "disabled";
                                                                                                                        } ?>>Preprocessing Data</button>
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
                                    <b><?= $dataTwitterCount ?></b> Data akan dilakukan Preprocessing, tekan mulai untuk melanjutkan.
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('deletedata') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Mulai</button>
                                    </form>
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
                        <th>Created At</th>
                        <th>Real Text</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    function loadingSwal() {
        Swal.fire({
            title: 'Mohon Tunggu',
            text: 'Sedang melakukan Preprocessing',
            imageUrl: '{{ asset("image/loading.gif") }}',
            imageWidth: 200,
            imageHeight: 200,
            imageAlt: 'Custom image',
            allowOutsideClick: false,
            showConfirmButton: false
        });
    }

    const successSwal = function() {
        Swal.fire({
            icon: 'success',
            title: 'Selesai!',
            text: 'Berhasil Preprocessing Data',
            allowOutsideClick: false,
            confirmButtonColor: 'rgb(67,105,215)',
        });
    };
</script>
@include('sweetalert::alert')
@endsection