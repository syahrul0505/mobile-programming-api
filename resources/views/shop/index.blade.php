@extends('layouts.app')

@section('style')
@endsection
<style>
    .radius-r-20 {
        border-radius: 20px 50% 50% 20px !important;
    }
    .btn-dropdown-custome{
        z-index: 30 !important;
    }

    .card-resto {
        cursor: pointer !important;
        transition: all 0.2s;
    }

    .card-resto:hover {
        transform: scale(1.02) !important;
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 5px 8px rgba(0, 0, 0, .06);
    }

    .bg-gray-400 {
        background: #191c24;
    }

    .item-order{
        height: 23rem;
        overflow-y: scroll;
        overflow-x: hidden;
    }
    .select2-dropdown{
        z-index: 1055 !important;
    }
    .select2-selection__choice{
  background-color: var(--bs-gray-200);
  border: none !important;
  font-size: 12px;
  font-size: 0.85rem !important;
}
</style>

@section('content')
<form action="{{ route('checkout-order', md5(strtotime("now"))) }}" method="POST">
@csrf
    <div class="row mt-4 ">
        <div class="col-12 col-md-8  px-md-5 px-lg-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fw-bolder mb-0 w-100">Menu <span class="fw-light">Category</span></h3>
                <form class="position-relative">
                    <input type="text" class="form-control search-chat py-2 ps-3 w-50" id="text-srh" placeholder="Search Product">
                </form>
            </div>

            {{-- <section class="splide" aria-labelledby="carousel-heading">
                <h2 id="carousel-heading">Splide Basic HTML Example</h2>
              
              
                <div class="splide__track">
                      <ul class="splide__list">
                          <li class="splide__slide">Slide 01</li>
                          <li class="splide__slide">Slide 02</li>
                          <li class="splide__slide">Slide 03</li>
                      </ul>
                </div>
              </section> --}}

            <div class="row mt-4">
                <div class="col-12">
                    <div class="row">
                        <div class="col-4 col-sm-2 col-md-3">
                            <div class="card card-resto filter-tag" style="background: #6a344b !important; cursor: pointer;" data-tag="all">
                                <div class="p-2">
                                    <div class="px-2 py-3 rounded-2" style="background: #e0e0e0b9 !important;">
                                        <img src="{{ asset('assets/images/logos/apps.png') }}" alt="." class="rounded-2 d-block mx-auto" style="width: 2.8rem !important;">
                                    </div>
                                </div>

                                <div class="text-center mb-2">
                                    <span class="fw-bolder text-white" style="font-size: 16px;">ALL</span>
                                </div>
                            </div>
                        </div>
                        @foreach ($tags as $tag)
                        <div class="col-4 col-sm-2 col-md-3">
                            <div class="card card-resto filter-tag" style="background: #6a344b !important; cursor: pointer;" data-tag="{{ $tag->tag_name }}">
                                <div class="p-2">
                                    <div class="px-2 py-3 rounded-2" style="background: #e0e0e0b9;">
                                        <img src="{{ asset('assets/images/logos/apps.png') }}" alt="." class="rounded-2 d-block mx-auto" style="width: 2.8rem !important;">
                                    </div>
                                </div>

                                <div class="text-center mb-2">
                                    <span class="fw-bolder text-white" style="font-size: 16px;">{{ $tag->tag_name }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-2">
                <h3 class="fw-bolder mb-0">Choose <span class="fw-light">Menu</span></h3>

                <a href="" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add Menu
                </a>

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal titles</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('restaurants.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group mb-3">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="name" id="name" aria-describedby="name">
                                                        </div>
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    {{-- <div class="col-12">
                                                        <div class="form-group mb-3">
                                                            <label for="category" class="form-label">Category</label>
                                                            <select class="form-select @error('category') is-invalid @enderror" name="category">
                                                                <option disabled selected>Choose category</option>
                                                                <option value="Makanan" {{ (old('category') == 'Makanan') ? 'selected' : '' }}>Makanan</option>
                                                                <option value="Minuman" {{ (old('category') == 'Minuman') ? 'selected' : '' }}>Minuman</option>
                                                            </select>
                                                            @error('status')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div> --}}

                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <label for="modal" class="form-label">Modal</label>
                                                            <input type="number" min="0" name="modal" value="{{ old('modal') }}" class="form-control" placeholder="modal" id="modal" aria-describedby="modal">
                                                        </div>
                                                        @error('modal')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-12" >
                                                        <div class="form-group mb-3">
                                                            <label for="price" class="form-label">Price</label>
                                                            <input type="number" min="0" name="price" id="price" value="{{ old('price') }}" class="form-control" placeholder="price" id="price" aria-describedby="price">
                                                        </div>
                                                        @error('price')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    {{-- <div class="col-lg-12" >
                                                        <div class="form-group mb-3">
                                                            <label for="stock_in" class="form-label">Stock Tersedia</label>
                                                            <input type="number" min="0" name="stock_in" id="stock_in" value="{{ old('stock_in') }}" class="form-control" placeholder="stock_in" id="stock_in" aria-describedby="stock_in">
                                                        </div>
                                                        @error('stock_in')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-12" >
                                                        <div class="form-group mb-3">
                                                            <label for="stock_per_day" class="form-label">Stock In</label>
                                                            <input type="number" min="0" name="stock_per_day" id="stock_per_day" value="{{ old('stock_per_day') }}" class="form-control" placeholder="stock_per_day" id="stock_per_day" aria-describedby="stock_per_day">
                                                        </div>
                                                        @error('stock_per_day')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div> --}}

                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="form-file" class="form-label">Image</label>
                                                            <input type="file" name="image" class="form-control" id="form-file">
                                                        </div>
                                                        @error('image')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <div class="small text-danger  mb-3">*Kosongkan jika tidak mau diisi</div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Tags</label> <br>
                                                            <select name="tag_id[]" class="form-control tag-input-select2" style="width:100%" multiple="multiple" data-placeholder="Select The Permissions" multiple data-dropdown-css-class="select2-purple">
                                                                <option>Choose Tag</option>
                                                                @foreach ($tags as $tag)
                                                                    <option value="{{$tag->id}}" class="tagOption"
                                                                        @foreach (old('tag_id') ?? [] as $id)
                                                                            @if ($id == $tag->id)
                                                                                {{ 'selected' }}
                                                                            @endif
                                                                        @endforeach>
                                                                        {{$tag->tag_name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('tag_id')
                                                                <span class="text-danger text-sm">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select class="form-select form-control @error('status') is-invalid @enderror" name="status">
                                                                <option disabled selected>Choose Status</option>
                                                                <option value="active" {{ (old('status') == 'active') ? 'selected' : '' }}>Active</option>
                                                                <option value="inactive" {{ (old('status') == 'inactive') ? 'selected' : '' }}>Inactive</option>
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
                                                            <label for="description" class="form-label">Description</label>
                                                            <textarea name="description" class="form-control" id="description" rows="4"></textarea>
                                                            {{-- <textarea name="description" id="mytextarea"></textarea> --}}
                                                            @error('content')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="row row-sm">
                        @foreach ($restaurants as $restaurant)
                            @php
                                $tagNames = [];
                                foreach ($restaurant->restaurantTag as $restoTag) {
                                    $tagNames[] = $restoTag->tag->tag_name;
                                }
                                $dataTags = implode(',', $tagNames);
                            @endphp
                            @if ($restaurant->status == "active")
                                <div class="col-6 col-sm-3 col-md-4 card-restor resto-product" data-tags="{{ $dataTags }}">
                                    <div class="card">
                                        <div class="position-absolute btn-dropdown-custome" style="right:0rem; top:0rem;">
                                            <div class="dropdown">
                                                <button class="btn bg-transparent p-3" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="right: 0.5rem;">
                                                    <i class="fa-solid fa fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li>
                                                        <a class="dropdown-item" href="#restaurant-edit-{{ $restaurant->id }}" data-bs-toggle="modal" data-bs-target="#restaurant-edit-{{ $restaurant->id }}">Edit Menu</a>
                                                    </li>
                                                    
                                                    <li><a class="dropdown-item" href="#" onclick="modalDelete('Restaurant', '{{ $restaurant->name }}', '/restaurants/' + {{ $restaurant->id }}, '/restaurants/')">Delete Menu</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        @include('shop.edit-restaurant')

                                        <div class="card-body h-100 product-grid6 card-resto" data-bs-toggle="modal" data-bs-target="#detail-resto-{{ $restaurant->id }}">
                                            <div class="pro-img-box product-image">
                                                @if ($restaurant->image == null)
                                                    <img src="{{ asset('assets/images/logos/bengkel.jpg') }}" alt="." class="rounded-2 d-block mx-auto" style="width: 4rem !important;">
                                                @else
                                                    <img src="{{ asset('assets/images/restaurant/'.($restaurant->image ?? 'bengkel.jpg')) }}" alt="." class="rounded-2 d-block mx-auto" style="width: 5rem !important;">
                                                @endif
                                            </div>
                                            <div class="text-center pt-2">
                                                <h3 class="fw-bolder h6 mb-2 mt-4 font-weight-bold text-uppercase">{{ $restaurant->name }}</h3>
                                                @if ($restaurant->price_discount == 0)
                                                    <h4 class="fw-bolder h5 mb-0 mt-1 text-center font-weight-bold  tx-15">Rp. {{ number_format($restaurant->price,0) }} </h4>
                                                @else
                                                    <h4 class="fw-bolder h5 mb-0 mt-1 text-center font-weight-bold  tx-15">Rp. {{ $restaurant->price_discount }}</h4>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @include('shop.detail')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fw-bolder mb-0">Order <span class="fw-light">Menu</span></h3>

                <a href="{{ route('kasir.dashboard.server') }}" class="btn btn-sm btn-primary">
                    Pesanan
                </a>
            </div>
           
            <div class="mt-3 item-order">
                <div class="row">
                    @foreach ($data_carts as $key => $item)
                    <input type="hidden" name="modal_resto" value="{{ array_sum((array) $item->attributes['restaurant']['modal']) }}">
                    <input type="hidden" name="persentase_pb01" value="{{ $other_setting->pb01 }}">
                    <div class="col-1 col-md-12">
                        <div class="card w-100 p-3 mb-2" style="border:1px solid #dbdbdb;">
                            <div class="row align-items-center">
                                <div class="col-4 col-md-3">
                                    <div class="p-1">
                                        @if ($item->attributes['restaurant']['image'] != null)
                                            <img src="{{ asset('assets/images/restaurant/'.($item->attributes['restaurant']['image'] ?? 'user.jpg')) }} " style="width: 80%" alt="" class="rounded-2 d-block mx-auto">
                                        @else
                                            <img src="{{ asset('assets/images/logos/bengkel.jpg') }}" alt="." class="rounded-2 d-block mx-auto" style="width: 3rem !important;">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-8 col-md-9">
                                    <div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bolder d-block" style="color:#3b3b3b !important;font-size: 18px;">{{ $item->attributes['restaurant']['name'] }}</span>
                                            <a href="" class="text-danger" style="font-size: x-large" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="ti ti-trash"></i></a>
                                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fas fa-trash text-danger"></i></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this item?
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <a href="{{ route('delete-cart', $key)}}" class="text-white btn btn-danger">Yes I'm sure</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            @if ($item->attributes['restaurant']['price_discount'] == 0)
                                                <span class="fw-bolder text-white" style="color:#a6a6a6 !important;font-size: 14px;">Rp. {{ number_format($item->attributes['restaurant']['price'],0) }} ( x{{ $item->quantity  }} )</span>
                                            @else
                                                <span class="fw-bolder text-white" style="color:#a6a6a6 !important;font-size: 14px;">Rp. {{ number_format($item->attributes['restaurant']['price_discount'],0) }}</span>
                                            @endif
                                                <?php
                                                if ($item->attributes['restaurant']['price_discount'] == 0) {
                                                    $restaurantTotal = $item->attributes['restaurant']['price'] * $item->quantity;
                                                } else {
                                                    $restaurantTotal = $item->attributes['restaurant']['price_discount'] * $item->quantity;
                                                }
                                                ?>
                                                <span class="fw-bolder text-white" style="color:#a6a6a6 !important;font-size: 14px;">Rp. {{ number_format($restaurantTotal  ?? '0',0 ) }}</span>
                                        </div>
                                        <span class="fw-bolder text-white" style="color:#a6a6a6 !important;font-size: 14px;">{{ $item->attributes['description'] ?? "Tidak Ada Note" }}</span>
                                        <input type="hidden" name="desc[]" value="{{ $item->attributes['description'] }}">
                                        <input type="hidden" min="0" value="1" name="idSession[]">
                                        <input type="hidden" name="qty[]" id="quantityInput" readonly class="min-width-40 flex-grow-0 border border-success text-success fs-4 fw-semibold form-control text-center qty" min="0" style="width: 15%"  value="{{ $item->quantity }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            @if ($data_carts->count() >= 1)
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card w-100 px-3 py-2 mb-2" style="border:1px solid #dbdbdb;">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <h4 class="fw-bolder text-center">Summary Order</h4>
                                </div>
                                <hr>
                                <div class="col-12">
                                    <div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="fw-bolder d-block" style="color:#3b3b3b !important;font-size: 16px;">Total</span>
                                            <span class="fw-bolder text-white" style="color:#a6a6a6 !important;font-size: 16px;">Rp. {{ number_format(\Cart::getTotal()  ?? '0',0 ) }}</span>
                                        </div>
                                        {{-- {{ dd($other_setting) }} --}}
                                        @if ($other_setting->pb01 != 0)
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="fw-bolder d-block" style="color:#3b3b3b !important;font-size: 16px;">PB01 ({{ $other_setting->pb01 }}%)</span>
                                                <?php
                                                    $biaya_pb01 = ((\Cart::getTotal() ?? '0')) * $other_setting->pb01/100;
                                                ?>
                                                <span class="fw-bolder text-white" style="color:#a6a6a6 !important;font-size: 16px;">Rp. {{ number_format($biaya_pb01,0) }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between mb-3">
                                                <span class="fw-bolder d-block" style="color:#3b3b3b !important;font-size: 16px;">Subtotal</span>
                                                <?php
                                                    $total = (\Cart::getTotal() ?? '0') + $biaya_pb01;
                                                ?>
                                                <span class="fw-bolder text-white" style="color:#a6a6a6 !important;font-size: 16px;">Rp. {{ number_format($total,0) }}</span>
                                            </div>
                                        @else
                                        {{-- <div class="form-group mb-3 ">
                                            <label for="discount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Discount</label>
                                            <select id="discount" name="discount" class="form-select" onchange="updateTotal()">
                                                <option selected>Pilih Discount</option>
                                                @foreach ($discounts as $discount)
                                                    <option value="{{ $discount->harga }}"
                                                        {{ old('discount_id') == $discount->id ? 'selected' : '' }}>
                                                        {{ $discount->nama }} ({{ number_format($discount->harga,0) }}) </option>
                                                @endforeach
                                            </select>
                                        </div> --}}

                                        <input type="hidden" name="total_harga" id="total_harga">


                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="fw-bolder d-block" style="color:#3b3b3b !important;font-size: 16px;">Subtotal</span>
                                            <?php
                                                $total_price = (\Cart::getTotal() ?? '0');
                                            ?>
                                            <span id="total" class="fw-bolder text-white" style="color:#a6a6a6 !important;font-size: 16px;">Rp. {{ number_format($total_price) }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 mb-2">
                                    <a href="" class="btn w-100 btn-danger fw-bolder" data-bs-toggle="modal" data-bs-target="#modal-charge">
                                        Charge
                                    </a>
                                    <div class="modal fade" id="modal-charge" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-chargeLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="modal-chargeLabel"><i class="fas fa-trash text-danger"></i></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="order-summary border rounded p-4 my-4">
                                                        <div id="select-input-wrapper" class="col-lg-12 ">
                                                            <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih EDC</label>
                                                            <select id="countries" name="metode_pembayaran" class="form-select form-control">
                                                                <option disabled selected>Pilih Metode Pembayaran</option>
                                                                <option value="EDC MANDIRI">EDC MANDIRI</option>
                                                                <option value="EDC BCA">EDC BCA</option>
                                                                <option value="EDC BRI">EDC BRI</option>
                                                                <option value="EDC BNI">EDC BNI</option>
                                                                {{-- <option value="Open Bill">Open Bill</option> --}}
                                                                <option value="Qris">Qris</option>
                                                                <option value="Cash">Cash</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-12 mt-3">
                                                            <div class="form-group mb-3">
                                                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Masukkan Nama Customer</label>
                                                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="name" id="name" aria-describedby="name">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12 mt-3" id="cashInput" style="display: none;">
                                                            <div class="form-group mb-3">
                                                                <label for="cash" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Masukkan Jumlah Nominal Cash</label>
                                                                <input type="number" name="cash" value="{{ old('cash') }}" class="form-control" placeholder="Massukan jumlah cash" id="cash" aria-describedby="cash">
                                                            </div>
                                                        </div>

                                                        <div id="tambahInput" class="col-lg-12" style="display: none;">
                                                            <label for="tambah_menu" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Open Bill</label>
                                                            <select id="tambahMenu" name="metode_open_bill" class="form-select form-control">
                                                                <option disabled selected>Pilih Open Bill</option>
                                                                <option value="Open Bill Baru">Open Bill Baru</option>
                                                                <option value="Extend Open Bill">Extend Open Bill</option>
                                                            </select>
                                                        </div>
                                                        <div id="order_menu" class="col-lg-12" style="display: none">
                                                            <label for="order" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Order</label>
                                                            <select id="order_bill" name="bill_order" class="form-select form-control">
                                                                <option disabled selected>Pilih Order</option>
                                                                @foreach ($orders as $order)
                                                                <option value="{{ $order->id }}"
                                                                    {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                                                    {{ $order->invoice_no }} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="text-white btn btn-danger">Yes I'm sure</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</form>
@push('script')


<script>
    // Pass the $discounts data to JavaScript using JSON encoding
    var discountsData = <?php echo json_encode($discounts); ?>;

    function updateTotal() {
        // Get the selected discount value
        var selectedDiscount = document.getElementById("discount").value;

        console.log('Selected Discount Value:', selectedDiscount);

        // Check if the selected option is the default "Pilih Discount"
        if (selectedDiscount === "Pilih Discount") {
            // Reset the total to its original value
            var originalTotal = <?php echo (\Cart::getTotal() ?? '0') + ((\Cart::getTotal() ?? '0')) * $other_setting->pb01/100; ?>;
            document.getElementById("total").innerText = 'Rp. ' + originalTotal.toLocaleString();

            // Set the total_harga input field to the original total
            document.getElementById("total_harga").value = originalTotal;

            return;
        }

        // Find the selected discount object from the discountsData
        var selectedDiscountObject = discountsData.find(function(discount) {
            return discount.harga == selectedDiscount;
        });

        // Check if the selectedDiscountObject is not undefined
        if (selectedDiscountObject) {
            console.log('Selected Discount Object:', selectedDiscountObject);

            // Calculate the discounted total
            var discountedTotal = <?php echo (\Cart::getTotal() ?? '0') + ((\Cart::getTotal() ?? '0')) * $other_setting->pb01/100; ?> - selectedDiscountObject.harga;

            // Update the total span text
            document.getElementById("total").innerText = 'Rp. ' + discountedTotal.toLocaleString();

            // Set the total_harga input field to the discounted total
            document.getElementById("total_harga").value = discountedTotal;
        } else {
            // Handle the case where the selected discount is not found
            console.error('Selected discount not found:', selectedDiscount);
        }
    }

</script>
<script>
    $(document).ready(function() {
        $('.tag-input-select2').select2({
            dropdownParent: $('#exampleModal')
        });
    });
</script>
@if ($data_carts->count() >= 1)
<script>
    const selectInput = document.getElementById('countries');
    const cashInput = document.getElementById('cashInput');
    const tambahInput = document.getElementById('tambahInput');
    const tambahMenu = document.getElementById('tambahMenu');
    const orderInput = document.getElementById('order_menu');

    selectInput.addEventListener('change', function() {
    if (selectInput.value === 'Cash') {
        cashInput.style.display = 'block';
        tambahInput.style.display = 'none';
        orderInput.style.display = 'none';
    } else if (selectInput.value === 'Open Bill') {
        cashInput.style.display = 'none';
        tambahInput.style.display = 'block';
        if (tambahMenu.value === 'Extend Open Bill') {
            orderInput.style.display = 'block';
        } else {
            orderInput.style.display = 'none';
        }
    } else {
        cashInput.style.display = 'none';
        tambahInput.style.display = 'none';
        orderInput.style.display = 'none';
    }
});

// Additional Event Listener for the tambahMenu select
tambahMenu.addEventListener('change', function() {
    if (tambahMenu.value === 'Extend Open Bill' && selectInput.value === 'Open Bill') {
        orderInput.style.display = 'block';
    } else {
        orderInput.style.display = 'none';
    }
});

    // selectPrice.addEventListener('change', function() {
    //     if (selectPrice.value === 'Open Bill') {
    //         tambahInput.style.display = 'block';
    //     } else {
    //         tambahInput.style.display = 'none';
    //     }
    // });

</script>
@endif
<script>
    // Ambil inputan teks
    const searchInput = document.getElementById('text-srh');
    searchInput.addEventListener('input', function() {
        const filter = searchInput.value.toLowerCase().trim(); // Ambil teks input dan ubah ke huruf kecil

        // Ambil semua card restoran
        const cards = document.querySelectorAll('.card-restor');

        // Loop melalui setiap card restoran
        cards.forEach(card => {
            const restaurantName = card.querySelector('.fw-bolder').textContent.toLowerCase(); // Ambil nama restoran dari card dan ubah ke huruf kecil

            // Periksa apakah teks pencarian ada dalam nama restoran
            if (restaurantName.includes(filter)) {
                card.style.display = 'block'; // Jika cocok, tampilkan card
            } else {
                card.style.display = 'none'; // Jika tidak cocok, sembunyikan card
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.filter-tag').on('click', function (e) {
            e.preventDefault();
            var selectedTag = $(this).data('tag');
            console.log(selectedTag);
            $('.resto-product').hide(); // Sembunyikan semua restoran

            if (selectedTag === 'all') {
                $('.resto-product').show(); // Menampilkan semua jika tag yang dipilih adalah 'all'
            } else {
                $('.resto-product[data-tags*="' + selectedTag + '"]').show();
                // Tampilkan restoran yang memiliki tag yang cocok dengan tag yang dipilih
            }

            // Jika tidak ada restoran yang cocok dengan tag yang dipilih, tampilkan pesan atau lakukan tindakan yang sesuai
            var visibleRestaurants = $('.resto-product:visible');
            if (visibleRestaurants.length === 0) {
                // Jika tidak ada restoran yang cocok, lakukan sesuatu di sini, seperti menampilkan pesan
                console.log('Tidak ada restoran dengan tag yang dipilih.');
                // Atau, jika ingin menampilkan semuanya kembali, bisa menggunakan $(').show();
            }
        });
    });
</script>

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
