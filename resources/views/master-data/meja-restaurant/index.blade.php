@extends('home')

@section('style')

@endsection

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card card rounded-20 p-2">
                <div class="card-header rounded-t-20 pt-1 pl-2 pb-2 pr-2">
                    <div class="row">
                        <div class="col-6 mt-1 px-4">
                            <span class="d-flex justify-content-start align-items-center tx-bold text-lg text-white" style="font-size:16px;">
                                <i class="fa-solid fa-couch" style="font-size: 20px;"></i>
                                <h4 class="card-title mb-0 pb-0 ml-2">{{ strtoupper($page_title) }}</h4>
                            </span>
                        </div>

                        <div class="col-6 text-right px-4">
                            <a class="btn btn-sm btn-danger p-2" href="{{ route('master-data.index') }}">
                                Kembali
                            </a>

                            @can('meja-restaurant-create')
                            <button class="btn btn-sm btn-success btn-open-modal p-2" data-toggle="modal" data-target="#tambah-meja-restaurant">
                                Tambah
                            </button>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div class="row">
                        <div class="col-12">
                            @include('components.flash-message')
                        </div>
                    </div>

                    <table id="mytableMeja" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th class="th-sm text-white">No</th>
                                <th class="th-sm text-white">Nama</th>
                                <th class="th-sm text-white">Kode Meja</th>
                                <th class="th-sm text-white">Category</th>
                                <th class="th-sm text-white">Status</th>
                                <th class="th-sm text-white">Barcode</th>
                                <th class="th-sm text-white">Status Minimum Order</th>
                                <th class="th-sm text-white">Minimum Order</th>
                                <th class="th-sm text-white">Position</th>
                                <th class="th-sm text-white" width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($meja_restaurants as $meja_restaurant)
                            <tr>
                                <td class="table-head text-white">{{ $loop->iteration }}</td>
                                <td class="table-head text-white">{{ $meja_restaurant->nama }}</td>
                                <td class="table-head text-white">{{ $meja_restaurant->kode_meja }}</td>
                                <td class="table-head text-white">{{ $meja_restaurant->category }}</td>
                                {{-- <td class="table-head text-white">{{ $meja_restaurant->status }}</td> --}}
                                @if ($meja_restaurant->status == 'Tersedia')
                                <td class="table-head text-white"><span class="badge bg-success">{{$meja_restaurant->status }}</span></td>
                                @else
                                <td class="table-head text-white"><span class="badge bg-danger">{{$meja_restaurant->status }}</span></td>
                                @endif
                                
                                {{-- <td class="table-head text-white" style="background-color: white">{!! DNS2D::getBarcodeHTML( "$meja_restaurant->barcode" , 'QRCODE') !!}</a></td> --}}
                                <td class="table-head text-white"> 
                                    {{-- <a download="barcode-{{ strtolower(str_replace(' ', '',$meja_restaurant->nama)) }}.jpg" class="btn btn-primary p-2 f-12" href="data:image/png;base64, {!! DNS2D::getBarcodePNG($meja_restaurant->barcode, 'QRCODE') !!}"  title="ImageName">
                                        DOWNLOAD
                                    </a> --}}
                                    
                                    
                                    <style>
                                        .barcode-download {
                                            display: inline-block;
                                            width: 200px;
                                            height: 200px;
                                            background-image: url('data:image/png;base64, {!! DNS2D::getBarcodePNG($meja_restaurant->barcode, 'QRCODE') !!}');
                                            background-size: cover;
                                            background-position: center;
                                            text-align: center;
                                            line-height: 200px;
                                            font-size: 14px;
                                            text-decoration: none;
                                            color: #ffffff;
                                            background-color: #007bff;
                                            border: none;
                                            border-radius: 4px;
                                        }
                                    </style>
                                    <a download="barcode-{{ strtolower(str_replace(' ', '',$meja_restaurant->nama)) }}.jpg" class="btn btn-primary p-2 f-12" href="data:image/png;base64, {!! DNS2D::getBarcodePNG($meja_restaurant->barcode, 'QRCODE') !!}" title="ImageName">
                                        DOWNLOAD
                                    </a>
                                    
                                    {{-- <img style="width:200px; height:200px;" src="data:image/png;base64, {!! DNS2D::getBarcodePNG($meja_restaurant->barcode, 'QRCODE') !!} " alt="barcode"   /> --}}
                                    {{-- <img src="data:image/png,' . {!! DNS2D::getBarcodePng( "$meja_restaurant->barcode" , 'C39+')!!} . '" alt="barcode"   /> --}}
                                </td>

                                <td class="table-head text-white">{{ $meja_restaurant->status_minimal_order }}</td>
                                <td class="table-head text-white">{{ $meja_restaurant->minimal_order }}</td>
                                <td class="table-head text-white">{{ $meja_restaurant->position }}</td>

                                @if(auth()->user()->can('meja-restaurant-delete') || auth()->user()->can('meja-restaurant-edit'))
                                <td>
                                    <div class="btn-group-sm">
                                    @can('meja-restaurant-edit')
                                    <button class="btn btn-sm btn-warning p-2 btn-lg btn-open-modal" data-toggle="modal" data-target="#edit-meja-restaurant{{ $meja_restaurant->id }}">
                                        <i class="fa fa-edit"></i>
                                        Edit
                                    </button>
                                    @endcan
                                    @can('meja-restaurant-delete')
                                    <a href="#" class="btn btn-danger p-2 f-12" onclick="modalDelete('Meja Restaurant', '{{ $meja_restaurant->nams }}', '/meja-restaurant/' + {{ $meja_restaurant->id }}, '/meja-restaurant/')">
                                        <i class="far fa-trash-alt"></i>
                                        Hapus
                                    </a>
                                    @endcan
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @include('master-data.meja-restaurant.edit')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('master-data.meja-restaurant.create')
@endsection
@push('script_bot')
    <script>
        var table = $('#mytableMeja').DataTable( {
            responsive: true,
            "lengthMenu": [[100, 50, 25], [100, 50, 25]]
        } );
    </script>
@endpush