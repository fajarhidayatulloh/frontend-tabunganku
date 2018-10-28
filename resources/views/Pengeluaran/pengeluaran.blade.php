@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pengeluaran</div>

                <div class="card-body">
                    <div class="title-home">
                        <h1>Pengeluaran Anda Saat ini:</h1>
                        <h2>{{$pengeluaran->data['currency']}}. {{$pengeluaran->data['totalpengeluaran']}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List Data Pengeluaran</div>

                <div class="card-body">
                    <a href="{{url('pengeluaran/input')}}" class="btn btn-primary" style="margin-bottom:20px;">Tambah Pengeluaran</a>
                    <br>
                    <table class="table table-striped table-condensed nowrap" id="pengeluaran-table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title Pengeluaran</th>
                                <th>Deskripsi Pengeluaran</th>
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
