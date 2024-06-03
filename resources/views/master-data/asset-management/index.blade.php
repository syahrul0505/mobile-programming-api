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
                        <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
                        <li class="breadcrumb-item active">{{ $page_title }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-4">
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

                        @can('asset-management-create')
                        <div class="col-6 d-flex justify-content-end">
                            <a href="{{ route('master-data.asset-managements.create') }}" class="btn btn-sm btn-info me-2" style="padding: 0.4rem;">
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
                            <table id="dataTable" class="table border text-nowrap customize-table mb-0 align-middle">
                              <thead class="text-dark fs-4">
                                <tr>
                                  <th>No</th>
                                  <th>Name</th>
                                  <th>Qty</th>
                                  <th>Price</th>
                                  <th>Image</th>
                                  <th>Description</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($asset_managements as $asset_management)

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $asset_management->name }}</td>
                                    <td>{{ $asset_management->qty }}</td>
                                    <td>{{ $asset_management->price }}</td>
                                    <td>
                                      <div class="d-flex align-items-center">
                                        <img src="{{ asset('assets/images/user/'.($user->avatar ?? 'user.jpg')) }}" width="39"height="39" class="rounded-circle me-n2 card-hover border border-2 border-white">
                                      </div>
                                    </td>
                                    <td>{{ $asset_management->description }}</td>
                                    @if(auth()->user()->can('asset-management-delete') || auth()->user()->can('asset-management-edit'))
                                    <td>
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown"aria-expanded="false">
                                                <i class="ti ti-dots-vertical fs-6"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    @can('asset-management-edit')
                                                    <a href="{{ route('master-data.asset-managements.edit', $asset_management->id) }}" class="dropdown-item d-flex align-items-center gap-3">
                                                        <i class="fs-4 ti ti-edit"></i>Edit
                                                    </a>
                                                    @endcan
                                                <li>
                                                    @can('asset-management-delete')
                                                    <a href="#" class="dropdown-item d-flex align-items-center gap-3" onclick="modalDelete('Asset Management', '{{ $asset_management->name }}', '/master-data/asset-managements/' + {{ $asset_management->id }}, '/master-data/asset-managements/')">
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
