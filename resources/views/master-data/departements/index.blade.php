@extends('layouts.app')

@section('style')

@endsection

@section('content')
<div class="content-wrapper">
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

                        @can('departement-create')
                        <div class="col-6 d-flex justify-content-end">
                            <a href="{{ route('master-data.departements.create') }}" class="btn btn-sm btn-info me-2" style="padding: 0.4rem;">
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
                                  <th>Name</th>
                                  <th>Permission</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($departements as $departement)

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $departement->name }}</td>
                                    <td>
                                        <button onclick="detailModal('Permission User', 'departements/' + {{ $departement->id }}, 'small')" class="btn btn-sm btn-primary">
                                            <i class="fa fa-info-circle"></i>Show Permissions
                                        </button>
                                    </td>
                                    @if(auth()->user()->can('departement-delete') || auth()->user()->can('departement-edit'))
                                    <td>
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown"aria-expanded="false">
                                                <i class="fa fa-ellipsis-v fs-6"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    @can('departement-edit')
                                                    <a href="{{ route('master-data.departements.edit', $departement->id) }}" class="dropdown-item d-flex align-items-center gap-3">
                                                        <i class="typcn typcn-edit"></i>Edit
                                                    </a>
                                                    @endcan
                                                <li>
                                                    @can('departement-delete')
                                                    <a href="#" class="dropdown-item d-flex align-items-center gap-3" onclick="modalDelete('Departement', '{{ $departement->name }}', '/master-data/departements/' + {{ $departement->id }}, '/master-data/departements/')">
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
