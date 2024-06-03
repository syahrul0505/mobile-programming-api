{{-- <hr class="custom-hr">
<table class="table table-striped" id="mytable">
    <thead>
        <tr>
            <th class="th-sm text-white">No</th>
            <th class="th-sm text-white">Location</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($asset_managements->detailAsset as $asset)
        <tr class="custom-tr">
            <td class="text-white">{{ $loop->iteration }}</td>
            <td class="text-white">{{ $asset->location }}</td>
        </tr>
        @endforeach
    </tbody>
</table> --}}

@extends('home')

@section('style')

@endsection

@section('content')

@section('style')
    
@endsection

@section('content')

<div class="content-wrapper">
    <div class="row">
        
        <div class="card rounded-20 p-2">
            <div class="card-header rounded-t-20 pt-1 pl-2 pb-0 pr-2">
                <h4 class="text-center text-uppercase">Detail Supplier</h4>
            </div>
            <div class="card-body bg-gray-800 rounded-20 p-3">
                <div class="col-12 text-right px-4">
                    <a class="btn btn-sm btn-danger p-2" href="{{ route('supplier.index') }}">
                        Kembali
                    </a>
                </div>
                <div class="row">
                    
                    <div class="col-12">
                       Nama : {{ $suppliers->name }}
                    </div>

                    <div class="col-12">
                        Description : {{ $suppliers->description }}
                     </div>

                </div>
            </div>
        </div>

        <div class="col-lg-12 grid-margin stretch-card mt-4 ">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @include('components.flash-message')
                        </div>
                    </div>
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th class="th-sm text-white">NO</th>
                                <th class="th-sm text-white">Nama</th>
                                <th class="th-sm text-white">Telephone</th>
                                <th class="th-sm text-white">Email</th>
                                <th class="th-sm text-white">Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers->detailSupplier as $key => $detail_supplier)
                            {{-- {{ dd($asset_detailPivot->location) }} --}}
                                <tr>
                                    <td class="th-sm text-white">{{ $loop->iteration }}</td>
                                    <td class="th-sm text-white">{{$detail_supplier->name ?? ''}}</td>
                                    <td class="th-sm text-white">{{$detail_supplier->telephone ?? ''}}</td>
                                    <td class="th-sm text-white">{{$detail_supplier->email ?? ''}}</td>
                                    <td class="th-sm text-white">{{$detail_supplier->adsress ?? ''}}</td>
                                </tr>   
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

