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

                        @can('tag-create')
                        <div class="col-6 d-flex justify-content-end">
                            <a href="{{ route('master-data.tags.create') }}" class="btn btn-sm btn-info me-2" style="padding: 0.4rem;">
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
                                  <th>Tag Name</th>
                                  <th>Status</th>
                                  <th>Position</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($tags as $tag)

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tag->tag_name }}</td>
                                    @if ($tag->status == "active")
                                      <td><span class="badge badge-pill bg-primary me-1 my-2 rounded-3 py-8 fw-semibold">{{ $tag->status }}</span></td>
                                    @else
                                      <td><span class="badge badge-pill bg-danger rounded-3 py-8 text-danger fw-semibold fs-2">{{ $tag->status }}</span></td>
                                    @endif
                                    <td>{{ $tag->position }}</td>
                                    @if(auth()->user()->can('tag-delete') || auth()->user()->can('tag-edit'))
                                    <td>
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown"aria-expanded="false">
                                                <i class="fa fa-ellipsis-v fs-6"></i>
                                                {{-- <i class="fas fa-home"></i> <!-- This will display a home icon --> --}}

                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    @can('tag-edit')
                                                    <a href="{{ route('master-data.tags.edit', $tag->id) }}" class="dropdown-item d-flex align-items-center gap-3">
                                                        <i class="typcn typcn-edit"></i>Edit
                                                    </a>
                                                    @endcan
                                                <li>
                                                    @can('tag-delete')
                                                    <a href="#" class="dropdown-item d-flex align-items-center gap-3" onclick="modalDelete('Tag', '{{ $tag->tag_name }}', '/master-data/tags/' + {{ $tag->id }}, '/master-data/tags/')">
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
