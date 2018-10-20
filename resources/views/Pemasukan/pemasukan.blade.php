@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pemasukan</div>

                <div class="card-body">
                    <div class="title-home">
                        <h1>Pemasukan Anda Saat ini:</h1>
                        <h2>{{$pemasukan->data['currency']}}. {{$pemasukan->data['totalPemasukan']}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
