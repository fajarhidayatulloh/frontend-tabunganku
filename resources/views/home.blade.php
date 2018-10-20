@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Home</div>

                <div class="card-body">
                    <div class="title-home">
                        <h1>Tabungan Anda Saat ini:</h1>
                        <h2>{{$tabungan->data['currency']}}. {{$tabungan->data['totalTabungan']}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
