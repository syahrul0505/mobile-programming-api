@extends('layouts.app')

@section('style')
<style>
    .hilang {
        display: none;
    }


</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">{{ $page_title }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">{{ $page_title }}</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 border-radius mt-4">
        <div class="card border-radius shadow p-3 bg-card-orange mb-3">
            <div class="d-flex justify-content-center align-items-center">
                <img src="{{ asset('assets/images/backgrounds/cashier.png') }}" width="10%" class="" style="" alt="Image 1">

                <div class="ms-3">
                    <h2 class="mb-0 mt-2 fw-bolder text-white text-center">WEB KASIR POS</h2>
                    <h5 class="mb-1 text-white text-center">Pemantauan Kasir yang Efisien, Hasil yang Maksimal!</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 col-md-6">
        <div class="card w-100 bg-card-orange mb-3">
            <div class="p-3 d-flex align-items-stretch">
                <div class="row w-100">
                    <div class="col-4 col-md-3 d-flex align-items-center">
                        <img src="{{ asset('assets/images/logos/user.png') }}" class="rounded img-fluid" />
                    </div>

                    <div class="col-8 col-md-9 d-flex align-items-center p-2">
                        <div>
                            <a href="javascript:void(0)" class="text-white fs-5 fw-bolder link lh-sm">Total Karyawan</a>
                            <h6 class="card-subtitle mt-2 mb-0" style="color:#ffffffad;">
                                {{ count($users) }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 col-md-6">
        <div class="card w-100 bg-card-orange mb-3">
            <div class="p-3 d-flex align-items-stretch">
                <div class="row w-100">
                    <div class="col-4 col-md-3 d-flex align-items-center">
                        <img src="{{ asset('assets/images/logos/user.png') }}" class="rounded img-fluid" />
                    </div>

                    <div class="col-8 col-md-9 d-flex align-items-center p-2">
                        <div>
                            <a href="javascript:void(0)" class="text-white fs-5 fw-bolder link lh-sm">Total Menu</a>
                            <h6 class="card-subtitle mt-2 mb-0" style="color:#ffffffad;">
                                {{ count($products) }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="col-12 col-lg-4 col-md-6">
        <div class="card w-100 bg-card-orange mb-3">
            <div class="p-3 d-flex align-items-stretch">
                <div class="row w-100">
                    <div class="col-4 col-md-3 d-flex align-items-center">
                        <img src="{{ asset('assets/images/logos/user.png') }}" class="rounded img-fluid" />
                    </div>

                    <div class="col-8 col-md-9 d-flex align-items-center p-2">
                        <div>
                            <a href="javascript:void(0)" class="text-white fs-5 fw-bolder link lh-sm">Total Karyawan</a>
                            <h6 class="card-subtitle mt-2 mb-0" style="color:#ffffffad;">
                            100
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>

<div class="d-flex justify-content-start align-items-center px-4 py-3" style="background:#10678d80; border:3px dashed #1684b7; border-radius:20px;">
    <div class="d-flex justify-content-start align-items-center w-100">
        <img src="{{ asset('assets/images/backgrounds/premium.png') }}" width="7%" class="" style="" alt="Image 1">

        <div class="ms-3">
            <h3 class="mb-0 mt-2 fw-bolder text-white">UPGRADE YOUR APPS</h3>
            <h6 class="mb-1 text-white"></h6>
        </div>
    </div>
    <div class="">
        <a href="https://wa.me/6281514021746" class="btn btn-sm btn-primary fw-bolder text-uppercase">Contact Jooal</a>
    </div>
</div>


@endsection

@push('script')

@endpush
