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
                            <span class="tx-bold text-lg text-white" style="font-size:16px;">
                            <i class="far fa-user text-lg"></i>
                            {{ $page_title }}
                            </span>
                        </div>

                        @can('material-create')
                        <div class="col-6 d-flex justify-content-end">
                            <a href="{{ route('master-data.materials.create') }}" class="btn btn-sm btn-info me-2" style="padding: 0.4rem;">
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
                            <table id="responsive-datatable" class="table border text-nowrap customize-table mb-0 align-middle">
                              <thead class="text-dark fs-4">
                                <tr>
                                  <th>No</th>
                                  <th>Code</th>
                                  <th>Name</th>
                                  <th>Unit</th>
                                  <th>Minimal Stock</th>
                                  <th>Description</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($materials as $material)

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $material->code }}</td>
                                    <td>{{ $material->name }}</td>
                                    <td>{{ $material->unit }}</td>
                                    <td>{{ $material->minimal_stock }}</td>
                                    <td>{{ $material->description }}</td>
                                    <td>
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown"aria-expanded="false">
                                                <i class="fa fa-ellipsis-v fs-6"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    @can('material-edit')
                                                    <a href="{{ route('master-data.materials.edit', $material->id) }}" class="dropdown-item d-flex align-items-center gap-3">
                                                        <i class="typcn typcn-edit"></i>Edit
                                                    </a>
                                                    @endcan
                                                <li>
                                                    @can('material-delete')
                                                    <a href="#" class="dropdown-item d-flex align-items-center gap-3" onclick="modalDelete('Tag', '{{ $material->name }}', '/master-data/materials/' + {{ $material->id }}, '/master-data/materials/')">
                                                        <i class="far fa-trash-alt"></i>
                                                        Delete
                                                    </a>
                                                    @endcan
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
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
