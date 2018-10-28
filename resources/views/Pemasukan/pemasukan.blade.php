@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tabungan</div>

                <div class="card-body">
                    <div class="title-home">
                        <h1>Tabungan Anda Saat ini:</h1>
                        <h2>{{$pemasukan->data['currency']}}. {{$pemasukan->data['totalPemasukan']}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List Data Tabungan</div>

                <div class="card-body">
                    <a href="{{url('tabungan/input')}}" class="btn btn-primary" style="margin-bottom:20px;">Tambah Tabungan</a>
                    <br>
                    <table class="table table-striped table-condensed nowrap" id="pemasukan-table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title Tabungan</th>
                                <th>Deskripsi Tabungan</th>
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
