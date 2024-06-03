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
                        <li class="breadcrumb-item"><a href="{{ route('master-data.materials.index') }}">Material</a></li>
                        <li class="breadcrumb-item active">{{ $page_title }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-12 mt-4">
        <div class="card" style="border-radius:15px;">
            <div class="card-header text-center bg-warning" style="border-radius:15px 15px 0px 0px;">
                <h3 class="card-title text-white">{{ $page_title }}</h3>
            </div>
            <form action="{{ route('master-data.materials.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label for="code" class="form-label">Code</label>
                                <input type="text" name="code" value="{{ old('code') }}" class="form-control" placeholder="Code" id="code" aria-describedby="code">
                            </div>
                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name" id="name" aria-describedby="name">
                            </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label for="unit" class="form-label">Unit</label>
                                <input type="text" name="unit" value="{{ old('unit') }}" class="form-control" placeholder="unit" id="unit" aria-describedby="unit">
                            </div>
                            @error('unit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label for="minimal_stock" class="form-label">Minimal Stock</label>
                                <input type="number" name="minimal_stock" value="{{ old('minimal_stock') }}" class="form-control" placeholder="minimal_stock" id="minimal_stock" aria-describedby="minimal_stock">
                            </div>
                            @error('minimal_stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-lg-12">
                           <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" placeholder="Description" class="form-control" id="description" rows="4"></textarea>
                                @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-end bg-warning" style="border-radius:0px 0px 15px 15px;">
                    <a class="btn btn-danger" href="{{ route('master-data.materials.index') }}">
                        Back
                    </a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
