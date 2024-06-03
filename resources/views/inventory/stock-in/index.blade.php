@extends('layouts.app')

@section('style')

@endsection

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ $page_title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">{{ $page_title }} /</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row align-items-center mt-4">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card rounded-20">
                <div class="card-header bg-warning" style="border-radius:15px 15px 0px 0px;">
                    <div class="row">
                        <div class="col-6 mt-1">
                            <span class="tx-bold text-lg text-white" style="font-size:20px;">
                            <i class="far fa-user text-lg"></i> &nbsp;
                            {{ $page_title }}
                            </span>
                        </div>

                        @can('stock-in-create')
                        <div class="col-6 d-flex justify-content-end">
                            <a href="{{ route('stock-ins.create') }}" class="btn btn-sm btn-info p-2">
                                <i class="fa fa-plus"></i>
                                Add New
                            </a>
                        </div>
                        @endcan
                    </div>

                    <div class="row">
                        <div class="col-12 mt-2">
                            @include('components.flash-message')
                        </div>
                    </div>
                </div>

                <div class="w-100 position-relative overflow-hidden">
                    <div class="card-body p-4">
                        <div class="table-responsive rounded-2">
                            <table id="dataTableStockIn" class="table border text-nowrap customize-table mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Stock In</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stock_ins as $stock_in)

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $stock_in->material->name }}</td>
                                        <td>{{ $stock_in->material_in }}</td>
                                        <td>{{ $stock_in->description }}</td>
                                        @if(auth()->user()->can('stock-in-delete') || auth()->user()->can('stock-in-edit'))
                                        <td>
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown"aria-expanded="false">
                                                <i class="fa fa-ellipsis-v fs-6"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    @can('stock-in-edit')
                                                    <a href="{{ route('stock-ins.edit', $stock_in->id) }}" class="dropdown-item d-flex align-items-center gap-3">
                                                        <i class="typcn typcn-edit"></i>Edit
                                                    </a>
                                                    @endcan
                                                <li>
                                                    @can('stock-in-delete')
                                                    <a href="#" class="dropdown-item d-flex align-items-center gap-3" onclick="modalDelete('Stock In', '{{ $stock_in->material->name }}', '/stock-ins/' + {{ $stock_in->id }}, '/stock-ins/')">
                                                        <i class="far fa-trash-alt"></i>
                                                        Delete
                                                    </a>
                                                    @endcan
                                                </li>
                                            </ul>
                                        </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
