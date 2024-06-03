@extends('layouts.app')

@section('style')

@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ $page_title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
                        <li class="breadcrumb-item active">{{ $page_title }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card" style="border-radius:15px;">
                <div class="card-header text-center bg-warning" style="border-radius:15px 15px 0px 0px;">
                    <h3 class="card-title text-white">{{ $page_title }}</h3>
                </div>

                <form action="{{ route('master-data.other-settings.update', ['id' => Crypt::encryptString($other_setting->id ?? 0)]) }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="no_wa" class="form-label">Whatsapp Admin</label>
                                    <input type="text" name="no_wa" value="{{ $other_setting->no_wa ?? old('no_wa') }}" class="form-control" placeholder="no_wa" id="no_wa" aria-describedby="no_wa">
                                </div>
                                @error('no_wa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}

                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="pb01" class="form-label">PB01 <small>(%)</small></label>
                                    <input type="number" name="pb01" value="{{ $other_setting->pb01 ?? old('pb01') }}" class="form-control" placeholder="pb01" id="pb01" aria-describedby="pb01">
                                </div>
                                @error('pb01')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="layanan" class="form-label">Layanan</label>
                                    <input type="number" name="layanan" value="{{ $other_setting->layanan ?? old('layanan') }}" class="form-control" placeholder="layanan" id="layanan" aria-describedby="layanan">
                                </div>
                                @error('layanan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}

                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="time_start" class="form-label">Time Start</label>
                                    <input type="time" name="time_start" value="{{ $other_setting->time_start ?? old('time_start') }}" class="form-control" placeholder="time_start" id="time_start" aria-describedby="time_start">
                                </div>
                                @error('time_start')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="time_close" class="form-label">Time Close</label>
                                    <input type="time" name="time_close" value="{{ $other_setting->time_close ?? old('time_close') }}" class="form-control" placeholder="time_close" id="time_close" aria-describedby="time_close">
                                </div>
                                @error('time_close')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-warning mt-2 text-end" style="border-radius:0px 0px 15px 15px;">
                        <a class="btn btn-danger" href="{{ route('master-data.suppliers.index') }}">
                            Back
                        </a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
