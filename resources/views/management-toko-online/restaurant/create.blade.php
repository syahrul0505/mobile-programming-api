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
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Product</a></li>
                        <li class="breadcrumb-item active">{{ $page_title }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-12 mt-4">
        <div class="card card-primary" style="border-radius:15px;">
            <div class="card-header text-center bg-warning" style="border-radius:15px 15px 0px 0px;">
                <h3 class="card-title text-white">{{ $page_title }}</h3>
            </div>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                    placeholder="name" id="name" aria-describedby="name">
                            </div>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-4">
                            <div class="form-group"style="text-align: left">
                                <label class="form-label">Category</label>
                                <select class="form-select mr-sm-2 @error('category_id') is-invalid @enderror" id="category_id" name="category_id" style="width:100%">
                                    <option disabled selected>Choose Category</option>
                                    @foreach ($categorys as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->tag_name }} </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group"style="text-align: left">
                                <label for="form-file" class="form-label">Picture</label>
                                <input type="file" name="image" class="form-control" id="form-file">
                            </div>
                            @error('picture')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="purchase_price" class="form-label">Purchase Price</label>
                                <input type="number" name="purchase_price" id="purchase_price" value="{{ old('purchase_price') }}" class="form-control" placeholder="Ex:10.000" id="purchase_price" aria-describedby="price">
                            </div>
                            @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="selling_price" class="form-label"> Selling Price</label>
                                <input type="number" name="selling_price" id="selling_price" value="{{ old('selling_price') }}" class="form-control" placeholder="Ex:20.000" id="selling_price" aria-describedby="selling_price">
                            </div>
                            @error('price_discount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select form-control @error('status') is-invalid @enderror" name="status">
                                    <option selected value="On Sale" {{ (old('status') == 'On Sale') ? 'selected' : '' }}>On Sale</option>
                                    <option value="Hidden" {{ (old('status') == 'Hidden') ? 'selected' : '' }}>Hidden</option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                               <label for="description">Description</label>
                               <textarea name="description" class="form-control" id="description" rows="4" placeholder="Ex:....."></textarea>
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
                    <a class="btn btn-danger" href="{{ route('products.index') }}">
                        Back
                    </a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')

<script>
    $(document).ready(function() {
        $('.tag-input-select2').select2({
        });
    });
</script>
@endpush
@endsection
