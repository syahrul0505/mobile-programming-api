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
                        <li class="breadcrumb-item"><a href="{{ route('master-data.suppliers.index') }}">Supplier</a></li>
                        <li class="breadcrumb-item active">{{ $page_title }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 mt-4">
        <div class="card" style="border-radius:15px;">
            <div class="card-header text-center bg-warning" style="border-radius:15px 15px 0px 0px;">
                <h3 class="card-title text-white">{{ $page_title }}</h3>
            </div>
            <form action="{{ route('master-data.suppliers.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="supplier_name" class="form-label">Supplier Name</label>
                                <input type="text" name="supplier_name" value="{{ old('supplier_name') }}" class="form-control" placeholder="supplier_name" id="supplier_name" aria-describedby="supplier_name">
                            </div>
                            @error('supplier_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label for="telephone" class="form-label">telephone</label>
                                <input type="number" name="telephone" value="{{ old('telephone') }}" class="form-control" placeholder="telephone" id="telephone" aria-describedby="telephone">
                            </div>
                            @error('telephone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="email" id="email" aria-describedby="email">
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                 <label for="address" class="form-label">Address</label>
                                 <textarea name="address" placeholder="address" class="form-control" id="address" rows="4"></textarea>
                                 @error('content')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                             </div>
                         </div>

                        <div class="col-lg-12 mt-2">
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
                    <a class="btn btn-danger" href="{{ route('master-data.departements.index') }}">
                        Back
                    </a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
