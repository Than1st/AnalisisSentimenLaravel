@extends('layout.template')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>
<hr>
<div class="row">
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-s font-weight-bold text-primary mb-2" align="center">
                            Jumlah Data</div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800" align="center">{{$dataCount}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-s font-weight-bold text-primary mb-2" align="center">
                            Jumlah Data Processing</div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800" align="center">{{$preprocessingCount}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-s font-weight-bold text-primary mb-2" align="center">
                            Jumlah Data Berlabel</div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800" align="center">{{$labelCount}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-s font-weight-bold text-primary mb-2" align="center">
                            Jumlah Data Latih</div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800" align="center">{{$latihCount}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-s font-weight-bold text-primary mb-2" align="center">
                            Jumlah Data Uji</div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800" align="center">{{$ujiCount}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection