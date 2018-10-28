@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tabungan Qurban</div>

                <div class="card-body">
                    <div class="title-home">
                        <h1>Tabungan Qurban Anda Saat ini:</h1>
                        <h2>{{$qurban->data['currency']}}. {{$qurban->data['totalQurban']}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List Data Tabungan Qurban</div>

                <div class="card-body">
                    <a href="{{url('tabungan/qurban/input')}}" class="btn btn-primary" style="margin-bottom:20px;">Tambah Tabungan Qurban</a>
                    <br>
                    <table class="table table-striped table-condensed nowrap" id="qurban-table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Deskripsi</th>
                                <th>Nominal</th>
                                <th>Tanggal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
