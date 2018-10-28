@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="modal fade modal-token" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                                <h4 class="modal-title" style="text-align: center;">Pesan Konfirmasi</h4>
                            </div>
                            <div class="modal-body">
                                <div id="message"></div>
                            </div>
                            <div class="modal-footer">
                                <a href="{{url('/pengeluaran')}}" class="btn btn-success">{{ __('Close') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header">{{ __('Input Pengeluaran') }}</div>

                <div class="card-body">
                    <form id="pengeluaran-form">
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-sm-4 col-form-label text-md-right">{{ __('Title Pengeluaran') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" placeholder="Title Pengeluaran" autofocus>

                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nominal" class="col-sm-4 col-form-label text-md-right">{{ __('Nominal Pengeluaran') }}</label>

                            <div class="col-md-6">
                                <input id="nominal" type="nominal" class="nominal form-control{{ $errors->has('nominal') ? ' is-invalid' : '' }}" name="nominal" value="{{ old('nominal') }}" placeholder="IDR. " autofocus>

                                @if ($errors->has('nominal'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nominal') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="deskripsi" class="col-sm-4 col-form-label text-md-right">{{ __('Deskripsi Pengeluaran') }}</label>

                            <div class="col-md-6">
                                <textarea id="deskripsi" type="deskripsi" class="form-control{{ $errors->has('deskripsi') ? ' is-invalid' : '' }}" name="deskripsi" value="{{ old('deskripsi') }}" placeholder="Deskripsi Pengeluaran" autofocus></textarea>

                                @if ($errors->has('deskripsi'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('deskripsi') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button class="btn btn-primary" role="submit">
                                    {{ __('Input Pengeluaran') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
