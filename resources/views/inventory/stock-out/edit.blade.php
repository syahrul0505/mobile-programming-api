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
                        <li class="breadcrumb-item"><a href="{{ route('stock-outs.index') }}">Stock Out</a></li>
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

                <form action="{{ route('stock-outs.update',$stock_out->id) }}" method="POST">
                    @method('patch')
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Material</label>
                                    <select class="form-select mr-sm-2 @error('material_id') is-invalid @enderror" id="material_id" name="material_id" style="width:100%">
                                        <option disabled selected>Choose Material</option>
                                        @foreach ($materials as $material)
                                        <option value="{{ $material->id }}"
                                            {{ old('material_id') == $stock_out->masterial_id ? 'selected' : '' }}>
                                            {{ $material->name }} </option>
                                        @endforeach
                                    </select>
                                    @error('material_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="material_out" class="form-label">Material In</label>
                                    <input type="number" name="material_out" value="{{ old('material_out') ?? $stock_out->material_out }}" class="form-control" placeholder="material_out" id="material_out" aria-describedby="material_out">
                                </div>
                                @error('material_out')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                   <label for="description" class="form-label">Description</label>
                                   <textarea name="description" class="form-control" id="description" rows="4">{{ $stock_out->description }}</textarea>
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
                        <a class="btn btn-danger" href="{{ route('stock-outs.index') }}">
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
