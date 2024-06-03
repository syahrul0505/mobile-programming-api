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
                            Users List
                            </span>
                        </div>

                        @can('user-create')
                        <div class="col-6 d-flex justify-content-end">
                            <a href="{{ route('master-data.users.create') }}" class="btn btn-sm btn-info me-2" style="padding: 0.4rem;">
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
                        <div class="table-responsive rounded-2 mb-4">
                            <table id="responsive-datatable" class="table border text-nowrap customize-table mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th>No</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('assets/images/user/'.($user->avatar ?? 'user.jpg')) }}" width="39"height="39" class="rounded-circle me-n2 card-hover border border-2 border-white">
                                            </div>
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->getRoleNames()[0]}}</td>
                                        <td>{{ $user->email}}</td>
                                        @if(auth()->user()->can('user-delete') || auth()->user()->can('user-edit'))
                                        <td>
                                            <div class="dropdown dropstart">
                                                <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown"aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v fs-6"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li>
                                                        @can('user-edit')
                                                        <a href="{{ route('master-data.users.edit', $user->id) }}" class="dropdown-item d-flex align-items-center gap-3">
                                                            <i class="fs-4 typcn typcn-edit"></i>Edit
                                                        </a>
                                                        @endcan
                                                    <li>
                                                        @if(auth()->user()->can('user-delete') && Auth::user()->id != $user->id)
                                                        <a href="#" class="dropdown-item d-flex align-items-center gap-3" onclick="modalDelete('User', '{{ $user->username }}', '/master-data/users/' + {{ $user->id }}, '/master-data/users/')">
                                                            <i class="far fa-trash-alt"></i>
                                                            Delete
                                                        </a>
                                                        @endif
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
