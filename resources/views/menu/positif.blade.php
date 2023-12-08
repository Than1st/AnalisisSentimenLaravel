@extends('layout.template')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kata Positif</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-sm">
                    <button class="btn btn-primary btn-md btn-block" data-bs-toggle="modal" data-bs-target="#myModal">
                        Tambah Kata Positif
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <div class="d-flex align-items-center justify-content-between mb-1 p-1">
                    <div></div>
                    <div class="d-flex align-items-center justify-content-between">
                        <form action="/positif" method="GET"
                              class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <input type="text" name="keyword" class="form-control bg-light border-0 small"
                                       placeholder="Search" aria-label="Search" aria-describedby="basic-addon2"
                                       value="{{ request('keyword') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kata Positif</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($positives) != 0)
                            @foreach($positives as $teks)
                                <tr>
                                    <td style="width: 100px">{{ $teks->id_positive }}</td>
                                    <td>{{ $teks->positive }}</td>
                                    <td align="center" style="width: 200px">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editKata{{ $teks->id_positive }}"><span
                                                    class="fa fa-edit"></span></button>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#hapusKata{{ $teks->id_positive }}"><span
                                                    class="fa fa-trash"></span></button>
                                        </div>
                                    </td>
                                </tr>
                                {{--  Modal Hapus Kata --}}
                                <div class="modal" id="hapusKata{{ $teks->id_positive }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header bg-danger text-white">
                                                <h4 class="modal-title">Hapus Kata Positif</h4>
                                                <!-- <i class="fa fa-times" data-bs-dismiss="modal"></i> -->
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                Hapus Kata <b>{{ $teks->positive }}</b>?
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <form action="/positif/{{ $teks->id_positive }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                        Tutup
                                                    </button>
                                                    <input type="submit" class="btn btn-danger" id="btnSubmit"
                                                           value="Hapus Kata">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--  End Modal Hapus Kata  --}}
                                {{--  Modal Edit Kata --}}
                                <div class="modal" id="editKata{{ $teks->id_positive }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header bg-primary text-white">
                                                <h4 class="modal-title">Edit Kata Positif</h4>
                                                <!-- <i class="fa fa-times" data-bs-dismiss="modal"></i> -->
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form action="/positif/{{ $teks->id_positive }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <label for="positif">Kata Positif</label>
                                                    <input class="form-control" type="text" name="editPositif"
                                                           id="editPositif"
                                                           value="{{ $teks->positive }}"
                                                           oninput="this.value = this.value.toLowerCase()">
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                    Tutup
                                                </button>
                                                <input type="submit" class="btn btn-primary" id="btnSubmit"
                                                       value="Edit Kata">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--  End Modal Edit Kata  --}}
                            @endforeach
                        @else
                            <td colspan="5" class="text-center">Tidak ada data</td>
                        @endif
                        </tbody>
                    </table>
                    <div>{{ $positives->links('pagination::bootstrap-5') }}</div>
                </div>
            </div>
        </div>
    </div>
    {{--  Modal Tambah Kata --}}
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title">Tambah Kata Positif</h4>
                    <!-- <i class="fa fa-times" data-bs-dismiss="modal"></i> -->
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form class="form-group" action="/positif" method="post">
                        @csrf
                        <label for="positif">Kata Positif</label>
                        <input class="form-control" type="text" name="positif" id="positif"
                               value="{{ old('positif') }}" oninput="this.value = this.value.toLowerCase()">
                        @error('positif')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    <input type="submit" class="btn btn-primary" id="btnSubmit" value="Tambah Kata">
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--  End Modal Tambah Kata  --}}
    <script>
        const toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

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
    </script>
    @include('sweetalert::alert')
    @error("positif")
    <script>
        window.onload = function () {
            OpenBootstrapPopup();
        };

        function OpenBootstrapPopup() {
            $("#myModal").modal('show');
        }
    </script>
    @enderror
    @error("editPositif")
    <script type="text/javascript">
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ $message }}',
            allowOutsideClick: false,
            confirmButtonColor: 'rgb(67,105,215)',
        });
    </script>
    @enderror
@endsection
