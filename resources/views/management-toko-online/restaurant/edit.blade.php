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
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Toko Online</a></li>
                        <li class="breadcrumb-item active">{{ $page_title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card" style="border-radius:15px;">
                <div class="card-header text-center bg-warning" style="border-radius:15px 15px 0px 0px;">
                    <h3 class="card-title text-white">{{ $page_title }}</h3>
                </div>

                <form action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                    @method('patch')
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ old('name') ?? $product->name }}" class="form-control" placeholder="name" id="name" aria-describedby="name">
                                </div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Tag</label>
                                    <select name="tag_id[]" id="e1" class="js-example-basic-multiple select2-department select2" id="e1" multiple="multiple" style="width:100%">
                                        @foreach ($tags as $tag)
                                            <option value="{{$tag->id}}"
                                                @foreach (old('tag_id') ?? $product_tags as $id)
                                                    @if ($id == $tag->id)
                                                        {{ 'selected' }}
                                                    @endif
                                                @endforeach>
                                                {{$tag->tag_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="form-file" class="form-label">Image</label> <br>
                                    <img src="{{ asset('assets/images/restaurant/'.($product->avatar ?? 'user.jpg')) }}" width="15%"height="15%" class=" mb-2 rounded-circle me-n2 card-hover border border-2 border-white">
                                    <input type="file" name="image" class="form-control" id="form-file">
                                </div>
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="small text-danger">*Kosongkan jika tidak mau diisi</div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="purchase_price" class="form-label">Purchase Price</label>
                                    <input type="number" name="purchase_price" id="purchase_price" value="{{ old('purchase_price') ?? $product->purchase_price }}" class="form-control" placeholder="Ex:10.000" id="purchase_price" aria-describedby="purchase_price">
                                </div>
                                @error('purchase_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="selling_price" class="form-label">Selling Price</label>
                                    <input type="number" name="selling_price" id="selling_price" value="{{ old('selling_price') ?? $product->selling_price }}" class="form-control" placeholder="Ex:20.000" id="selling_price" aria-describedby="selling_price">
                                </div>
                                @error('selling_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-4 mt-2">
                                <div class="form-group mb-3">
                                    <label for="status">Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror" name="status">
                                        <option disabled selected>Choose Status</option>
                                        <option value="On Sale" {{ ($product->status == 'On Sale') ? 'selected' : '' }}>On Sale</option>
                                        <option value="Hidden" {{ ($product->status == 'Hidden') ? 'selected' : '' }}>Hidden</option>
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
                                    <textarea name="description" class="form-control" id="description" rows="4">{{ $product->description }}</textarea>
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
                        <a class="btn btn-danger" href="{{ route('products.index') }}">
                            Back
                        </a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script')

<script>
    $(document).ready(function() {
    var hargaInput = $('#price');
    var persentaseInput = $('#persentase');
    var hargaDiskonInput = $('#price_discount');

    hargaInput.on('keyup', calculateDiscountedPrice);
    persentaseInput.on('keyup', calculateDiscountedPrice);

    hargaInput.on('keyup', calculatePersentase);
    hargaDiskonInput.on('keyup', calculatePersentase);

    function calculateDiscountedPrice() {
        var originalHarga = hargaInput.val();
        var hargaVal = originalHarga.replace(/,/g, "");

        // Harga Diskon
        var originalDiskon = hargaDiskonInput.val();
        var hargaDiskonVal = originalDiskon.replace(/,/g, "");

        var harga = parseFloat(hargaVal);
        var hargaDiskon = parseFloat(hargaDiskonInput.val());
        // var hargaDiskon = parseFloat(hargaDiskonVal);
        var persentase = parseFloat(persentaseInput.val());

        if (!isNaN(harga) && !isNaN(persentase)) {
            var diskon = (harga * persentase) / 100;
            var hargaDiskon = harga - diskon;

            hargaDiskonInput.val(hargaDiskon);
        }

    }
    function calculatePersentase() {
        var harga = parseFloat(hargaInput.val());
        var hargaDiskon = parseFloat(hargaDiskonInput.val());

        if (!isNaN(harga) && !isNaN(hargaDiskon) && harga > 0) {
            var persentase = ((harga - hargaDiskon) / harga) * 100;
            persentase = Math.round(persentase); // Round to the nearest whole number
            persentaseInput.val(persentase);
        } else {
            persentaseInput.val('');
        }
    }
});
</script>
@endpush
@endsection
