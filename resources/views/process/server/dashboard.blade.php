@extends('layouts.app')

@section('style')
<style>
    .form-check-input{
        width: 1.5rem !important;
        height: 1.5rem !important;
    }
     menu-1{
        font-weight: 600 !important;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="row mt-4">
        <div class="col-lg-12">
            <form action="">
                <div class="row mb-3">
                    <div class="col-12 col-md-12 col-lg-6 grid-margin stretch-card">
                        <div class="card h-100 border-r-20">
                            <div class="card-header border-rt-20 py-1">
                                <h5 class="card-title text-center pt-1 fw-bolder">FILTER DATA</h5>
                            </div>
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group text-start" id="datepicker-date-area">
                                            <label class="">Date :</label>
                                            <input type="date" name="start_date" id="date" value="{{Request::get('start_date') ?? date('Y-m-d')}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group mt-4 ">
                                            <button type="submit" class="btn btn-primary btn-md w-100">
                                                Generate
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card rounded-30" style="background: rgb(61 61 61)">
                <div class="w-100 position-relative overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                            <div class="d-flex gap-3">
                                <div class="fw-bolder text-dark">
                                    <span class="badge rounded-pill bg-success">&nbsp;</span> PAID
                                </div>
                                <div class="fw-bolder text-dark">
                                    <span class="badge rounded-pill bg-warning">&nbsp;</span> UNPAID
                                </div>
                            </div>

                            <form class="position-relative">
                                <input type="text" class="form-control search-chat py-2 ps-3 w-100 text-white" id="text-srh" placeholder="Search Product">
                            </form>
                        </div>

                        @foreach ($orders as $item)
                        <div class="accordion" id="accordionExample-{{ $item->id }}">
                            <div class="accordion-item" style="border-color: #3d3d3d !important;">
                                <h2 class="accordion-header" id="headingOne-{{ $item->id }}">
                                    @if ($item->status_pembayaran == "Paid" && $item->metode_pembayaran != "Open Bill" && $item->order_cancel != "Order Batal")
                                        <button class="accordion-button collapsed bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne-{{ $item->id }}" aria-expanded="false" aria-controls="collapseOne-{{ $item->id }}">
                                    @elseif($item->status_pembayaran == "Unpaid" && $item->is_cancel == true)
                                            <button class="accordion-button collapsed bg-danger" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne-{{ $item->id }}" aria-expanded="false" aria-controls="collapseOne-{{ $item->id }}">
                                    @else
                                        <button class="accordion-button collapsed bg-warning" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne-{{ $item->id }}" aria-expanded="false" aria-controls="collapseOne-{{ $item->id }}">
                                    @endif
                                        <img src="{{ asset('assets/images/logos/hot.png') }}" alt="." class="rounded-2" style="width: 2.8rem !important;">

                                        <div class="ms-3 d-block">
                                            <h6 class="mb-0 text-white">#{{ $item->invoice_no }}</h6>
                                            <?php
                                            $invoiceNumber = $item->invoice_no;
                                            $parts = explode('-', $invoiceNumber); // Memisahkan nomor invoice menjadi bagian terpisah
                                            $lastPart = end($parts); // Mengambil bagian terakhir dari nomor invoice

                                            // Menambahkan 'CUST' setelah tanda '-' terakhir
                                            $newInvoiceNumber = $parts[0] . '-' .'CUST'.$lastPart ;

                                            ?>
                                            <h3 class="mb-0 text-white">{{ $item->name ?? $newInvoiceNumber }}</h3>
                                            <div class="mt-1">
                                                <small class="badge bg-info fw-bolder text-white">{{ $item->metode_pembayaran }}</small>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapseOne-{{ $item->id }}" class="accordion-collapse collapse" aria-labelledby="headingOne-{{ $item->id }}" data-bs-parent="#accordionExample-{{ $item->id }}">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($item->orderDetail as $order_pivot)
                                                        <li class="list-group-item">
                                                            <div class="d-flex w-100 justify-content-between">
                                                                <h5 class="mb-1"><strong>{{ $order_pivot->restaurant->name }}</strong></h5>
                                                                <small>x{{ $order_pivot->qty }} </small>
                                                            </div>
                                                                <p class="mb-1">Note: {{ $order_pivot->description ?? '-' }}</p>
                                                                <p class="mb-1">Rp. {{ number_format($order_pivot->price_discount * $order_pivot->qty,0)  }}</p>
                                                            </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="card">
                                                    <div class="card-header bg-warning py-2 px-3 text-center">
                                                        <span class="tx-bold text-lg text-white" style="font-size:20px;">
                                                            Summary Order
                                                        </span>
                                                    </div>

                                                    @php
                                                        $totalPrice = 0;
                                                    @endphp

                                                    @foreach ($item->orderDetail as $orderPivot)
                                                        @php
                                                        // Calculate the running total for each item
                                                        $totalPrice += $orderPivot->price_discount * $orderPivot->qty ;
                                                        @endphp
                                                    @endforeach

                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="d-flex w-100 justify-content-between">
                                                                <h5 class="mb-1"><strong>Sub total</strong></h5>
                                                                <span>Rp.{{ number_format($totalPrice,0) }}</span>
                                                            </div>
                                                        </li>

                                                        @if ($item->discount != null)
                                                        <li class="list-group-item">
                                                            <div class="d-flex w-100 justify-content-between">
                                                                <h5 class="mb-1"><strong>Discount</strong></h5>
                                                                <span>Rp.{{ number_format($item->discount,0) }}</span>
                                                            </div>
                                                        </li>
                                                        @endif

                                                        <form action="{{ route('kasir.update-payment',$item->id) }}" method="POST">
                                                            @method('patch')
                                                            @csrf
                                                            @if ($item->pb01 != 0)
                                                                <li class="list-group-item">
                                                                    <div class="d-flex w-100 justify-content-between">
                                                                        <h5 class="mb-1"><strong>PB01 :</strong></h5>
                                                                        <?php
                                                                            $biaya_pb01 = $totalPrice * $item->persentase_pb01/100;
                                                                        ?>
                                                                        <span>Rp.{{ number_format($biaya_pb01,0) }}</span>
                                                                    </div>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <div class="d-flex w-100 justify-content-between">
                                                                        <h5 class="mb-1"><strong>Subtotal :</strong></h5>
                                                                        <?php
                                                                            $total = $totalPrice + $biaya_pb01;
                                                                        ?>
                                                                        <span>Rp.{{ number_format($total,0) }}</span>
                                                                    </div>
                                                                </li>
                                                                @else
                                                                <li class="list-group-item">
                                                                    <div class="d-flex w-100 justify-content-between">
                                                                        <h5 class="mb-1"><strong>Total</strong></h5>
                                                                        <?php
                                                                            $totalAll = $item->total_price;
                                                                        ?>
                                                                        <span>Rp.{{ number_format($totalAll,0) }}</span>
                                                                    </div>
                                                                </li>
                                                            @endif

                                                            @if ($item->cash != 0)
                                                                
                                                            <li class="list-group-item">
                                                                <div class="d-flex w-100 justify-content-between">
                                                                    <h5 class="mb-1"><strong>Kembalian Cash</strong></h5>
                                                                    <span>Rp.{{ number_format($item->kembalian,0) }}</span>
                                                                </div>
                                                            </li>
                                                            @endif

                                                            
                                                            @if ($item->metode_pembayaran == "Open Bill")
                                                                <li class="list-group-item">
                                                                    <div id="select-input-wrapper">
                                                                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih EDC</label>
                                                                        <select id="countries" name="metode_pembayaran" class="form-select">
                                                                            <option disabled selected>Pilih Metode Pembayaran</option>
                                                                            <option value="EDC MANDIRI">EDC MANDIRI</option>
                                                                            <option value="EDC BCA">EDC BCA</option>
                                                                            <option value="EDC BRI">EDC BRI</option>
                                                                            <option value="EDC BNI">EDC BNI</option>
                                                                            <option value="Open Bill">Open Bill</option>
                                                                            <option value="Qris">Qris</option>
                                                                            <option value="Cash">Cash</option>
                                                                        </select>
                                                                    </div>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <div class="col-lg-12 mt-3" id="cashInput" style="display: none;">
                                                                        <div class="form-group mb-3">
                                                                            <label for="cash" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Masukkan Jumlah Nominal Cash</label>
                                                                            <input type="number" min="0" name="cash" value="{{ old('cash') }}" class="form-control" placeholder="Massukan jumlah cash" id="cash" aria-describedby="cash">
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <button type="submit" class="btn btn-sm  w-100 btn-primary"> Update Data</button>
                                                                </li>
                                                                @endif
                                                                <li class="list-group-item">
                                                                    <div class="d-flex w-100 justify-content-between">
                                                                        <h5 class="mb-1"><strong>Metode Pembayaran</strong></h5>
                                                                        <span>{{ $item->metode_pembayaran }}</span>
                                                                    </div>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="{{ route('kasir.dashboard-detail-kasir.show',$item->id) }}" target="_blank" type="submit" class="btn btn-sm  w-100 btn-danger">Print</a>
                                                                </li>
                                                                @can('cancel-order')
                                                                    
                                                                    @if ($item->is_cancel != true)
                                                                        
                                                                    <li class="list-group-item">
                                                                        <a class='add btn btn-sm  w-100 btn-danger'  data-bs-toggle="modal" data-bs-target="#cancel_order">Cancel Order </a>
                                                                    </li>
                                                                    @endif
                                                                @endcan

                                                        </form>
                                                        <div class="modal fade custom-modal" id="cancel_order" tabindex="-1" aria-labelledby="cancel_order" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    <div class="modal-body">
                                                                        <p>Apakah Anda yakin ingin cancel Order ini ?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <form action="{{ route('kasir.update-order',$item->id) }}" method="POST">
                                                                            @method('patch')
                                                                            @csrf
                                                                            <button type="submit" class="text-white btn btn-danger">Yes I'm sure</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script-top')

@endpush

@push('script')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // window.setTimeout( function() {
    //     window.location.reload();
    // }, 15000);
    function confirmData(id) {
        $.confirm({
            icon: 'glyphicon glyphicon-heart',
            title: 'Warning!',
            content: 'Apakah anda yakin?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                yes: {
                    text: 'Yes',
                    btnClass: 'btn-red',
                    action: function(){
                        axios.post('{{ route("waiters.status-update") }}', {
                            id
                        })
                        .then(response => {
                            // console.log(response);
                            alert('Berhasil Diupdate');
                            location.reload();
                        })
                        .catch(error => {
                            alert(error.response.data);
                        });
                    }
                },
                close: function () {

                }
            }
        });
    }

</script>

<script>
    const selectInput = document.getElementById('countries');
    const cashInput = document.getElementById('cashInput');

    selectInput.addEventListener('change', function() {
        if (selectInput.value === 'Cash') {
            cashInput.style.display = 'block';
        } else {
            cashInput.style.display = 'none';
        }
    });
</script>
@endpush
