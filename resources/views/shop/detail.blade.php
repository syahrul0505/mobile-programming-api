<div class="modal fade" id="detail-resto-{{ $restaurant->id }}" tabindex="-1" aria-labelledby="detail-resto-{{ $restaurant->id }}" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detail-resto-{{ $restaurant->id }}">Detail Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('add-cart',$restaurant->id) }}" method="get">
                <input type="hidden" name="modal_detail[]" value="{{ $restaurant->modal }}">
                <div class="shop-detail">
                    <div class="card shadow-none border">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="sync1" class="owl-carousel owl-theme">
                                        <div class="item rounded overflow-hidden">
                                            @if ($restaurant->image == null)
                                                <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" alt="." class="card-img-top rounded-0">
                                            @else
                                                <img src="{{ asset('assets/images/restaurant/'.($restaurant->image ?? 'user.jpg')) }}"alt="" class="img-fluid">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <div class="shop-content">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            @if ($restaurant->status == "active")
                                                <span class="badge badge-pill bg-primary fw-semibold rounded-3">In Stock</span>
                                            @else
                                                <span class="badge text-bg-danger fw-semibold rounded-3">Out Of Stock</span>
                                            @endif
                                            <span class="">{{ $restaurant->current_stock }}</span>
                                        </div>
            
                                        <div class="d-flex justify-content-between mb-3">
                                            <div class="w-100 bd-highlight">
                                                <h4 class="fw-semibold">{{ $restaurant->name ??'' }}</h4>
                                                <p class="mb-3">{{ $restaurant->description }}</p>
            
                                                @if ($restaurant->price_discount == 0)
                                                    <h6 class="fw-semibold mb-0">Rp. {{ number_format($restaurant->price ?? 0) }} <span class="ms-2 fw-normal text-muted"><del>Rp. {{ number_format($restaurant->price_discount ?? 0) }}</del></span></h6>
                                                @else
                                                    <h6 class="fw-semibold mb-0">Rp. {{ number_format($restaurant->price_discount ?? 0) }} <span class="ms-2 fw-normal text-muted"><del>Rp. {{ number_format($restaurant->price ?? 0) }}</del></span></h6>
                                                @endif
                                            </div>
            
                                            <div class="d-flex align-items-center bd-highlight">
                                                {{-- <h6 class="mb-0 fs-4 fw-semibold">QTY:</h6> --}}
                                                {{-- <div class="input-group input-group-sm">
                                                    <input type="hidden" min="0" value="1" name="idSession[]">
                                                    <button class="btn minus min-width-20 border-info border-end-0 rounded-start-2 text-info" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" id="add1"><i class="ti ti-minus"></i></button>
                                                    <input type="number" name="quantity" readonly class="min-width-40 flex-grow-0 border border-info text-info fs-4 fw-semibold form-control text-center qty" min="0" style="width: 35%" placeholder="" aria-label="Example text with button addon" aria-describedby="add1" value="1">
                                                    <button class="btn min-width-20 border border-info border-start-0 text-info add" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" id="addo2"><i class="ti ti-plus"></i></button>
                                                </div> --}}
                                                <div class="handle-counter ms-2" id="handleCounter4">
                                                    <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" id="add1" class="counter-minus btn btn-info lh-2 shadow-none fs"><i class="fe fe-minus"></i></button>
                                                    <input type="number" name="quantity" readonly class="min-width-40 flex-grow-0 border border-info text-info fw-semibold form-control text-center qty" min="1" style="width: 35%" placeholder="" aria-label="Example text with button addon" aria-describedby="add1" value="1">
                                                    <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" id="addo2" class="counter-plus btn btn-info lh-2 shadow-none"><i class="fe fe-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" class="form-control" id="description" placeholder="Description" rows="4"></textarea>
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
                    <button button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">
                    Add to Cart
                    </button>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>