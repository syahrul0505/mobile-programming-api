@extends('layouts.app')

@section('style')
@endsection
<style>
.btn-min{
    border-radius: 6px 0px 0px 6px !important;
}
</style>

@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
      <div class="row align-items-center">
        <div class="col-9">
          <h4 class="fw-semibold mb-8">checkout</h4>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a class="text-muted text-decoration-none" href="{{ route('shop.index') }}">Home</a>
              </li>
              <li class="breadcrumb-item" aria-current="page">checkout</li>
            </ol>
          </nav>
        </div>
        <div class="col-3">
          <div class="text-center mb-n5">
            {{-- <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/breadcrumb/ChatBc.png"
              alt="" class="img-fluid mb-n4" /> --}}
          </div>
        </div>
      </div>
    </div>
</div>
<div class="checkout">
    <div class="card shadow-none border">
      <div class="card-body p-4">
        <div class="wizard-content">
            {{-- <form action="{{ route('checkout-order', md5(strtotime("now"))) }}" method="POST">
                @csrf    --}}
                <h6>Cart</h6>
                <section>
                    <div class="table-responsive">
                        <table class="table align-middle text-nowrap mb-0">
                            <thead class="fs-2">
                                <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th class="text-end">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_carts as $key =>$item)
                                <tr>
                                    <td class="border-bottom-0">
                                        <div class="d-flex align-items-center gap-3 overflow-hidden">
                                            @if ($item->attributes['restaurant']['image'] != null)
                                                <img src="{{ asset('assets/images/restaurant/'.($item->attributes['restaurant']['image'] ?? 'user.jpg')) }}" class="img-fluid rounded" width="80">
                                            @else
                                                <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" class="img-fluid rounded" width="80">
                                            @endif
                                            <div>
                                                <h6 class="fw-semibold fs-4 mb-0">{{ $item->attributes['restaurant']['name'] }}</h6>
                                                <p class="mb-0">
                                                    @if(isset($item->attributes['detail_addon_id']))
                                                        @foreach($item->attributes['detail_addon_id'] as $addonId)
                                                            @if(isset($addonId))
                                                                @php
                                                                    // $addonId adalah ID dari detail add-on
                                                                    // Gantikan 'App\Models\DetailAddOn' dengan model yang sesuai untuk detail add-on
                                                                    $detailAddOn = App\Models\AddOnDetail::find($addonId);
                                                                @endphp
                                                                
                                                                @if($detailAddOn)
                                                                    <span class="block text-[10px] dark:text-white">{{ $detailAddOn->name  ?? 'Tidak Ada Note'}} <small> ({{ $detailAddOn->harga  ?? 0}})</small></span>
                                                                @else
                                                                    <span class="block text-[10px] dark:text-yellow-300">Add-on not found</span>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <span class="block text-[10px] dark:text-yellow-300">Tidak Ada Note</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="border-bottom-0">
                                        <div class="input-group input-group-sm flex-nowrap rounded">
                                            <span>{{ $item->quantity }}</span>
                                        </div>
                                    </td>
                                    <td class="text-end border-bottom-0">
                                        @if ($item->attributes['restaurant']['price_discount'] == 0)
                                            <h6 class="fs-4 fw-semibold mb-0">Rp. {{ number_format($item->attributes['restaurant']['price'],0) }}</h6>
                                        @else
                                            <h6 class="fs-4 fw-semibold mb-0">Rp. {{ number_format($item->attributes['restaurant']['price_discount'],0) }}</h6>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- {{ dd($item) }} --}}
                    <div class="order-summary border rounded p-4 my-4">
                        <div class="p-3">
                            <h5 class="fs-5 fw-semibold mb-4">Order Summary</h5>
                            <div class="d-flex justify-content-between mb-4" id="subTotal">
                                <p class="mb-0 fs-4">Sub Total</p>
                                <h6 class="mb-0 fs-4 fw-semibold">Rp. {{ number_format(\Cart::getTotal()  ?? '0',0 ) }}</h6>
                            </div>
                            @if ($other_setting->pb01 != 0)
                                
                            <div class="d-flex justify-content-between mb-4" id="pb01">
                                <p class="mb-0 fs-4">PB01 <span class="fw-semibold"> ({{ $other_setting->pb01 }}%)</span></p>
                                <?php
                                    $biaya_pb01 = ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0')) * $other_setting->pb01/100;
                                ?>
                                <h6 class="mb-0 fs-4 fw-semibold"> Rp. {{ $biaya_pb01 }}</h6>
                            </div>
                            <div class="d-flex justify-content-between mb-4" id="total">
                                <p class="mb-0 fs-4 fw-semibold">Total</p>
                                    <?php
                                        $total = (\Cart::getTotal() ?? '0') + $biaya_pb01;
                                    ?>
                                <h6 class="mb-0 fs-5 fw-semibold">Rp. {{ number_format($total, 0) }}</h6>
                            </div>
                            
                            @else
                            <div class="d-flex justify-content-between mb-4" id="total">
                                <p class="mb-0 fs-4 fw-semibold">Total</p>
                                    <?php
                                        $total = (\Cart::getTotal() ?? '0');
                                    ?>
                                <h6 class="mb-0 fs-5 fw-semibold">Rp. {{ number_format($total, 0) }}</h6>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <button class="col-lg-12 btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkout">
                            Order Now
                        </button>

                        <div class="modal fade" id="checkout" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="checkoutLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="checkoutLabel"><i class="fas fa-trash text-danger"></i></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @if ($order_last->cash == null)
                                        <span class="text-black">
                                            Apakah Anda Yakin Menyelesaikan Pesanan
                                        </span>
                                        @else
                                        <span class="text-black">
                                            Apakah Anda Yakin Menyelesaikan Pesanan
                                        </span>
                                        <br>
                                        <span class="text-black">Kembalian Yang Harus Di Berikan</span> <span class="text-danger"> {{ $order_last->cash - \Cart::getTotal()  }}</span>
                                        @endif
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <form action="{{ route('checkout-waiters', $token[0]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Yes I'm sure</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            {{-- </form> --}}
        </div>
      </div>
    </div>
</div>

@push('script')
<script>
    async function updateQuantity(itemId, change) {
        const quantityInput = document.getElementById(`quantityInput${itemId}`);
        const currentQuantity = parseInt(quantityInput.value) + change;

        if (currentQuantity >= 0) {
            quantityInput.value = currentQuantity;
            await updateSubtotal(itemId, currentQuantity);
        }
    }

    async function updateSubtotal(itemId, quantity) {
        try {
            const response = await fetch(`/get-item-price?id=${itemId}&quantity=${quantity}`);
            const itemData = await response.json();

            const subtotal = itemData.price * quantity;

            console.log("subtotal". subtotal);

            // Assuming subtotal is displayed as Rp. 1000 format
            const subtotalDisplay = document.getElementById("subtotalValue");
            subtotalDisplay.textContent = `Rp. ${subtotal.toLocaleString()}`;
        } catch (error) {
            console.error('Error:', error);
        }
    }
</script>

@endpush


@endsection
