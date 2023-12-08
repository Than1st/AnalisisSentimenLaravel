@extends('layout.template')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Labelling</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-sm">
                    <button class="btn btn-primary btn-md btn-block" data-bs-toggle="modal" data-bs-target="#myModal">
                        Labelling Data Otomatis
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <div class="d-flex align-items-center justify-content-between mb-1 p-1">
                    <div></div>
                    <div class="d-flex align-items-center justify-content-between">
                        <form action="/labelling" method="GET"
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
                            <th>User</th>
                            <th>Clean Text</th>
                            <th>Label Sentimen</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($dataPreprocessing) != 0)
                            @foreach($dataPreprocessing as $teks)
                                <tr>
                                    <td>{{ $teks->user }}</td>
                                    <td>{{ $teks->clean_text }}</td>
                                    <td>
                                        @if (count($dataSentimentLabelGroup) > 1)
                                            <select class="custom-select" id="sentiment{{ $teks->id_preprocessing }}"
                                                    style="width: 200px;">
                                                <option selected disabled>- Pilih Sentiment-</option>
                                                <option
                                                    value="positif" {{ $teks->sentiment_label == "positif" ? 'selected' : '' }}>
                                                    Positif
                                                </option>
                                                <option
                                                    value="negatif" {{ $teks->sentiment_label == "negatif" ? 'selected' : '' }}>
                                                    Negatif
                                                </option>
                                            </select>
                                        @else
                                            {{$teks->sentiment_label}}
                                        @endif
                                    </td>
                                    <td align="center">
                                        <button class="btn" data-bs-toggle="modal"
                                                data-bs-target="#modaldetail{{ $teks->id_preprocessing }}"><span
                                                class="fa fa-bars"></span></button>
                                    </td>
                                </tr>
                                <script>
                                    // Tangkap peristiwa perubahan pada dropdown
                                    $('#sentiment{{ $teks->id_preprocessing }}').on('change', function () {
                                        var Id = '{{ $teks->id_preprocessing }}';
                                        var selectedValue = $(this).val();
                                        updateDatabase(Id, selectedValue);
                                        toast.fire({
                                            icon: 'success',
                                            title: 'Berhasil Ubah Label Sentimen'
                                        });
                                    });
                                </script>
                            @endforeach
                        @else
                            <td colspan="5" class="text-center">Tidak ada data</td>
                        @endif
                        </tbody>
                    </table>
                    <div>{{ $dataPreprocessing->links('pagination::bootstrap-5') }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Labelling Otomatis -->
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
                    @if(count($dataPreprocessing) != 0)
                        @if (count($dataSentimentLabelGroup) > 1)
                            Tidak ada Data yang bisa diberi Label, Silahkan ke menu <b>Import Data Excel</b> -> Lakukan
                            <b>Preprocessing</b> -> Setelahnya anda bisa melakukan <b>Labelling</b>
                        @else
                            <b>{{ $dataPreprocessingCount }}</b> Data akan dilakukan Labelling Otomatis Berdasarkan
                            Kamus, tekan mulai untuk melanjutkan.
                        @endif
                    @else
                        Data Kosong silahkan ke menu <b>Import Data Excel</b> untuk menginput data
                    @endif
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    @if(count($dataPreprocessing) != 0)
                        @if (count($dataSentimentLabelGroup) > 1)
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                        @else
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                            <form action="{{ route('startLabelling') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <button type="submit" class="btn btn-primary" onclick="loadingSwal()"
                                        data-bs-dismiss="modal">Mulai
                                </button>
                            </form>
                        @endif
                    @else
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @foreach ($dataPreprocessing as $teks)
        <div class="modal fade" id="modaldetail{{ $teks->id_preprocessing }}" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Detail</h5>
                        <button type="button" class="close text-white" data-bs-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <div><b>User:</b></div>
                        <div>{{ $teks->user }}</div>
                        <div><b>Real Text:</b></div>
                        <div>{{ $teks->real_text }}</div>
                        <div><b>Clean Text:</b></div>
                        <div>{{ $teks->clean_text }}</div>
                        <div><b>Label Sentiment:</b></div>
                        <div>
                            @if($teks->sentiment_label == "positif")
                                <td><span class="badge bg-success text-white" style="font-size: 18px;">Positif</span>
                                </td>
                            @elseif($teks->sentiment_label == "negatif")
                                <td><span class="badge bg-danger text-white">Negatif</span></td>
                            @else
                                <td><span class="badge bg-secondary text-white">Belum diberi Label</span></td>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script>
        // Fungsi untuk memperbarui database
        function updateDatabase(id, value) {
            $.ajax({
                url: "{{ route('updateLabelling') }}",
                type: "POST",
                data: {
                    sentiment_label: value,
                    id_preprocessing: id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function (response) {
                    console.log(response);
                }
            });
        }

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
@endsection
