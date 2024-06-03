@extends('layouts.app')

@section('style')

@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ $page_title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('master-data.asset-managements.index') }}">{{ $page_title }}</a></li>
                        <li class="breadcrumb-item active">{{ $page_title }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card card-primary" style="border-radius:15px;">
                <div class="card-header text-center bg-warning" style="border-radius:15px 15px 0px 0px;">
                    <h3 class="card-title text-white">{{ $page_title }}</h3>
                </div>

                <form action="{{ route('master-data.asset-managements.update',$asset_management->id) }}" method="POST" enctype="multipart/form-data">
                    @method('patch')
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" name="name" value="{{ old('name') ?? $asset_management->name }}" class="form-control" placeholder="Name" id="name" aria-describedby="name">
                                            </div>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label for="qty" class="form-label">Qty</label>
                                                <input type="number" name="qty" value="{{ old('qty') ?? $asset_management->qty }}" class="form-control" placeholder="qty" id="qty" aria-describedby="qty">
                                            </div>
                                            @error('qty')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label for="price" class="form-label">Price</label>
                                                <input type="number" name="price" value="{{ old('price') ?? $asset_management->price }}" class="form-control" placeholder="price" id="price" aria-describedby="price">
                                            </div>
                                            @error('price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="col-lg-12 mt-2">
                                            <div class="form-group mb-3">
                                                <label for="form-file" class="form-label">Image</label> <br>
                                                <img src="{{ asset('assets/images/asset-management/'.($asset_management->avatar ?? 'user.jpg')) }}" width="15%"height="15%" class=" mb-2 rounded-circle me-n2 card-hover border border-2 border-white">
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
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" id="description" rows="4">{{ $asset_management->description }}</textarea>
                                    @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-warning mt-2 text-end" style="border-radius:0px 0px 15px 15px;">
                        <a class="btn btn-danger" href="{{ route('master-data.asset-managements.index') }}">
                            Back
                        </a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
