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
{{-- <div class="row mt-4">
    <div class="col-lg-6">
        <div class="card animated fadeInLeft" style="border-radius: 15px">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="card animated fadeInLeft" style="border-radius: 15px">
            <div class="card-body">
            </div>
        </div>
    </div>
</div>

<div class="card" style="border-radius:15px;">
    <div class="card-body">
        <div class="table-responsive">
            
        </div>
    </div>
</div> --}}

<div class="content-wrapper">
    <div class="row">
        
        <div class="card rounded-20 p-2">
            <div class="card-header rounded-t-20 pt-1 pl-2 pb-0 pr-2">
                <h4 class="text-center text-uppercase">Detail Asset</h4>
            </div>
            <div class="card-body bg-gray-800 rounded-20 p-3">
                <div class="col-12 text-right px-4">
                    <a class="btn btn-sm btn-danger p-2" href="{{ route('asset-management.index') }}">
                        Kembali
                    </a>
                </div>
                <div class="row">
                    
                    <div class="col-12">
                       Nama : {{ $asset_managements->nama }}
                    </div>

                    <div class="col-12">
                        Description : {{ $asset_managements->description }}
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
                                <th class="th-sm text-white">Location</th>
                                <th class="th-sm text-white">Qty</th>
                                <th class="th-sm text-white">Harga</th>
                                <th class="th-sm text-white">Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asset_managements->detailAsset as $key => $asset_detailPivot)
                            {{-- {{ dd($asset_detailPivot->location) }} --}}
                                <tr>
                                    <td class="th-sm text-white">{{ $loop->iteration }}</td>
                                    <td class="th-sm text-white">{{$asset_detailPivot->location ?? ''}}</td>
                                    <td class="th-sm text-white">{{$asset_detailPivot->qty ?? ''}}</td>
                                    <td class="th-sm text-white">{{$asset_detailPivot->harga ?? ''}}</td>
                                    <td class="th-sm text-white"><img src="{{ asset('assets/images/asset-management/'.($asset_detailPivot->image ?? 'user.png')) }}" width="110px" class="image img" /></td>
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

