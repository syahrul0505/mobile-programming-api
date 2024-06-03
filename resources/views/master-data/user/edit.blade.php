@extends('layouts.app')

@section('style')

@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">User Management</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('master-data.users.index') }}">User Management</a></li>
                        <li class="breadcrumb-item active">{{ $breadcumb }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12 col-md-6">
            <div class="card" style="border-radius:15px;">
                <div class="card-header text-center bg-warning" style="border-radius:15px 15px 0px 0px;">
                    <h3 class="card-title text-white">{{ $page_title }}</h3>
                </div>

                <form action="{{ route('master-data.users.update',$user->id) }}" method="POST" enctype="multipart/form-data">
                    @method('patch')
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ old('name') ?? $user->name }}" class="form-control" placeholder="Name" id="name" aria-describedby="name">
                                </div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ old('name') ?? $user->email }}" class="form-control" placeholder="email" id="email" aria-describedby="email">
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">Role</label>
                                <select class="form-control" name="role">
                                    <option disabled selected>Select One Role Only</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}"
                                            {{ (old('role') ?? $user->getRoleNames()[0] == $role) ? 'selected' : ''  }}>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-12 mt-2">
                                <div class="form-group mb-3">
                                    <label for="form-file" class="form-label">Image</label> <br>
                                    <img src="{{ asset('assets/images/user/'.($user->avatar ?? 'user.jpg')) }}" width="15%"height="15%" class=" mb-2 rounded-circle me-n2 card-hover border border-2 border-white">
                                    <input type="file" name="image" class="form-control" id="form-file">
                                </div>
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="small text-danger">*Kosongkan jika tidak mau diisi</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-warning mt-2 text-end" style="border-radius:0px 0px 15px 15px;">
                        <a class="btn btn-danger" href="{{ route('master-data.users.index') }}">
                            Back
                        </a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>

        @if (Auth::user()->id == $user->id || Auth::user()->getRoleNames()[0] == 'Admin')
        <div class="col-12 col-md-6">
            <div class="card card-primary" style="border-radius:15px;">
                <div class="card-header text-center bg-warning" style="border-radius:15px 15px 0px 0px;">
                    <h3 class="card-title text-white">CHANGE PASSWORD</h3>
                </div>

                <form action="{{ route('master-data.users.change-password') }}" method="POST">
                    @method('patch')
                    @csrf
                    <div class="card-body">

                        @include('components.flash-message')

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Old Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}" placeholder="Password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" value="{{ old('new_password') }}" placeholder="New Password">

                            @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer bg-warning" style="border-radius:0px 0px 15px 15px;">
                        <button type="submit" class="btn btn-warning">Change</button>
                    </div>
                </form>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
