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
</div>
@endsection
