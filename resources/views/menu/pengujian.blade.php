@extends('layout.template')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengujian</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div>
                <div>
                    <h4>Pilih Model Latih :</h4>
                </div>
                <div class="form-group">
                    <select class="form-control" name="model" id="model" onchange="onchangeModel(this.value)">
                        <option selected disabled>-Pilih Model Latih-</option>
                        @foreach($models as $model)
                            <option
                                value="{{($model->positive_labels + $model->negative_labels)}},{{$model->positive_labels}},{{$model->negative_labels}},{{$model->model_name}}">{{$model->model_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-s font-weight-bold text-info mb-2">
                                        Jumlah Data Uji
                                    </div>
                                    <div class="h2 mb-0 font-weight-bold text-gray-800">{{$testingCount}}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-vial fa-2x text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-s font-weight-bold text-primary mb-2">
                                        Jumlah Data Latih
                                    </div>
                                    <div class="h2 mb-0 font-weight-bold text-gray-800" id="text_total">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dumbbell fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-s font-weight-bold text-success mb-2">
                                        Sentimen Positif Data Latih
                                    </div>
                                    <div class="h2 mb-0 font-weight-bold text-gray-800" id="text_positif">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-smile fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-s font-weight-bold text-danger mb-2">
                                        Sentimen Negatif Data Latih
                                    </div>
                                    <div class="h2 mb-0 font-weight-bold text-gray-800" id="text_negatif">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-frown fa-2x text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-md btn-block" data-bs-toggle="modal" data-bs-target="#myModal"
                    id="pengujianButton" disabled>Mulai Pengujian
            </button>
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
                    @if($testingCount != 0)
                        Klik Mulai untuk mulai pengujian
                    @else
                        Data Uji Kosong, Silahkan ke menu <b>Split Data</b> untuk mendapatkan Data Uji.
                    @endif
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    @if($testingCount != 0)
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('startPengujian') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="namaModel" id="namaModel" value="" hidden>
                            <input type="text" name="jumlahSentimen" id="jumlahSentimen" value="" hidden>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal"
                                    onclick="loadingSwal()">Mulai
                            </button>
                        </form>
                    @else
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    @endif
                </div>

            </div>
        </div>
    </div>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        function onchangeModel(value) {
            const myArray = value.split(",");
            document.getElementById("text_total").innerHTML = myArray[0];
            document.getElementById("text_positif").innerHTML = myArray[1];
            document.getElementById("text_negatif").innerHTML = myArray[2];
            document.getElementById("namaModel").value = myArray[3];
            document.getElementById("jumlahSentimen").value = myArray[0];
            document.getElementById("pengujianButton").disabled = false;
        }
    </script>
    <script>
        function loadingSwal() {
            Swal.fire({
                title: 'Mohon Tunggu',
                text: 'Sedang melakukan Pengujian',
                imageUrl: '{{ asset("image/loading.gif") }}',
                imageWidth: 200,
                imageHeight: 200,
                imageAlt: 'Custom image',
                allowOutsideClick: false,
                showConfirmButton: false
            });
        }

        MathJax = {
            loader: {
                load: ['input/asciimath', 'output/chtml', 'ui/menu']
            },
            asciimath: {
                delimiters: [
                    ['$', '$'],
                    ['`', '`']
                ]
            }
        };
        Highcharts.chart('chart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Data Prediksi'
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Banyak Data'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '<b>{point.y}</b>'
            },
            series: [{
                name: 'Banyak Data',
                data: <?php echo json_encode($dataChart); ?>
            }]
        });
    </script>
    <script type="text/javascript" id="MathJax-script" async
            src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/startup.js">
    </script>
    @include('sweetalert::alert')
@endsection
