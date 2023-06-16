@extends('layout.template')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Modelling</h1>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div>
            <button class="btn btn-primary btn-md btn-block mb-4" data-bs-toggle="modal" data-bs-target="#myModal">Mulai Modelling</button>
        </div>
        <div class="table-responsive">
            <div class="d-flex align-items-center justify-content-between mb-1 p-1">
                <div></div>
                <div class="d-flex align-items-center justify-content-between">
                    <form action="/modelling" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
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
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Model Name</th>
                            <th>Positive Labels</th>
                            <th>Negative Labels</th>
                            <th>Total Sentiment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($trainings) != 0)
                        @foreach($trainings as $train)
                        <tr>
                            <td>{{ $train->model_name }}</td>
                            <td>{{ $train->positive_labels }}</td>
                            <td>{{ $train->negative_labels }}</td>
                            <td>{{ ($train->positive_labels + $train->negative_labels) }}</td>
                            <td align="center">
                                <button class="btn" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $train->id_model }}"><span class="fa fa-trash" style="color: #ff0000;"></span></button>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <td colspan="5" class="text-center">Tidak ada data</td>
                        @endif
                    </tbody>
                </table>
                <div>{{ $trainings->links('pagination::bootstrap-5') }}</div>
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
                Labelling akan dimulai, klik mulai untuk lanjut
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('startModelling') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" onclick="loadingSwal()">Mulai</button>
                </form>
            </div>

        </div>
    </div>
</div>
@foreach($trainings as $train)
<div class="modal" id="modalHapus{{$train->id_model}}">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-danger text-white">
                <h4 class="modal-title">Pesan</h4>
                <!-- <i class="fa fa-times" data-bs-dismiss="modal"></i> -->
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Anda yakin ingin menghapus model <b>{{$train->model_name}}</b>?
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                <form action="/modelling/delete" method="POST">
                    @csrf
                    <input type="text" name="id_model" id="id_model" value="{{ $train->id_model }}" hidden>
                    <input type="text" name="model_name" id="model_name" value="{{ $train->model_name }}" hidden>
                    <button class="btn btn-danger" type="submit">Hapus</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endforeach
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
            text: 'Sedang melakukan Pemodelan',
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