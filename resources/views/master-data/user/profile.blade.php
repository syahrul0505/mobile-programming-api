@extends('layouts.app')

@section('style')
@endsection


@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">User Profile</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none"
                                        href="https://bootstrapdemos.adminmart.com/modernize/dist/main/index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">User Profile</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/breadcrumb/ChatBc.png"alt="" class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card overflow-hidden">
            <div class="card-body p-0">
                <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/backgrounds/profilebg.jpg"
                    alt="" class="img-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-4 mt-n3 order-lg-2 order-1 mx-auto">
                        <div class="mt-n5">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <div class="linear-gradient d-flex align-items-center justify-content-center rounded-circle"
                                    style="width: 110px; height: 110px;" ;>
                                    <div class="border border-4 border-white d-flex align-items-center justify-content-center rounded-circle overflow-hidden"
                                        style="width: 100px; height: 100px;" ;>
                                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-1.jpg"
                                            alt="" class="w-100 h-100">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <h5 class="fs-5 mb-0 fw-semibold">{{ Auth::user()->name }}</h5>
                                <p class="mb-0 fs-4">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                aria-labelledby="pills-profile-tab" tabindex="0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-none border">
                            <div class="card-body">
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
                
                                            {{-- <div class="col-12">
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
                                            </div> --}}
                
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
                                        {{-- <a class="btn btn-danger" href="{{ route('master-data.users.index') }}">
                                            Back
                                        </a> --}}
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
            </div>
        </div>
    </div>
</div>
@endsection
