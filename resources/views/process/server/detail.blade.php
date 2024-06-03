<div class="modal fade" id="modal-dashboard" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-dashboard" aria-hidden="true">
    <div class="col">
        <div class="card h-100 border-r-20">
            <div class="card-header border-rt-20">
                <h5 class="card-title text-center pt-1 fw-bolder">Detail </h5>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

            <div class="card-body py-1">
                <div class="scroll-style">
                    <ul class="list-group list-group-flush pe-3">
                        @foreach ($item->orderDetail as $order_pivot)
                            <li class="list-group-item d-flex justify-content-start align-items-start">
                                <div class="flex-shrink-1">
                                    @if ($order_pivot->status_pemesanan == 'Selesai')
                                        <input disabled class="form-check-input me-2 p-2 mt-1 checkbox-1" type="checkbox" value="" onchange="removeData('{{ $order_pivot->id }}', 'pivot')"  id="" {{ $order_pivot->status_pemesanan == 'Selesai' ? 'checked' : '' }}>
                                    @else
                                        <input disabled class="form-check-input me-2 p-2 mt-1 checkbox-1" type="checkbox" value="" onchange="confirmData('{{ $order_pivot->id }}', 'pivot')"  id="" {{ $order_pivot->status_pemesanan == 'Selesai' ? 'checked' : '' }}>
                                    @endif
                                </div>
                                <div class="d-flex flex-column bd-highlight">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="p-0 m-0 menu-1 {{ $order_pivot->status_pemesanan == 'Selesai' ? 'text-decoration-line-through' : '' }}">
                                                {{ $order_pivot->restaurant->name }}
                                                ({{ $order_pivot->qty }}) 
                                            </h5>
                                        </div>
                                        <div class="col-lg-6">
                                            <h5 class="p-0 m-0 menu-1">
                                                Rp. {{ number_format($order_pivot->price_discount * $order_pivot->qty,0)  }}
                                            </h5>
                                        </div>
                                    </div>

                                    <span class="text-wrap fs-5">
                                        <h5 class="flex-shrink-1 mt-1" style="font-size: 14px">
                                            @if (count($order_pivot->orderAddOn) != 0)
                                                @foreach ($order_pivot->orderAddOn as $oad)
                                                        <span class="fw-bold">{{ $oad->addOn->name ?? '' }}</span>:
                                                        {{ $oad->addOnDetail->name ?? '' }} | 
                                                @endforeach
                                            @else
                                                Note: -
                                            @endif
                                        </h5>
                                    </span>
                                    
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="card-footer border-rb-20">
                @if ($item->open_bill == "Paid")
                <a href="{{ route('kasir.dashboard-detail-kasir.show',$item->id) }}" target="_blank" rel="noopener noreferrer" class="btn btn-danger rounded-lg p-2 mt-1 w-100">Print</a>
                @else
                <a href="{{ route('kasir.dashboard-detail-kasir.show',$item->id) }}" target="_blank" rel="noopener noreferrer" class="btn btn-danger rounded-lg p-2 mt-1 w-100">Print</a>
                <a href="" class="btn btn-warning rounded-lg p-2 mt-1 w-100" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Open Bill</a>
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel"><i class="fas fa-trash text-danger"></i></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to change to success Payment?
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a href="{{ route('kasir.change-open-bill',$item->id) }}" class="text-white btn btn-danger">Yes I'm sure</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                @php
                    $totalPrice = 0;
                @endphp
                @foreach ($item->orderDetail as $orderPivot)
                    @php
                    // Calculate the running total for each item
                    $totalPrice += $orderPivot->price_discount * $orderPivot->qty ;
                    @endphp
                @endforeach

                <div class="row">
                    <div class="col-lg-6">
                        <span class="text-muted">Total :</span>
                    </div>
                    <div class="col-lg-6 text-end">
                        <span class="p-0 m-0 menu-1 text-end">
                            <b>Rp. {{ number_format($totalPrice,0) }}</b> 
                        </span>
                    </div>

                    @if ($item->pb01 != 0)
                        <div class="col-lg-6">
                            <span class="text-muted">PB01 :</span>
                        </div>
                        <div class="col-lg-6 text-end">
                            <?php
                                $biaya_pb01 = $totalPrice * $other_setting->pb01/100;
                            ?>
                            <span class="p-0 m-0 menu-1 text-end">
                                <b>Rp. {{ number_format($biaya_pb01,0) }}</b> 
                            </span>
                        </div>

                        <div class="col-lg-6">
                            <span class="text-muted">Subtotal :</span>
                        </div>
                        <div class="col-lg-6 text-end">
                            <?php
                                $total = $totalPrice + $biaya_pb01;
                            ?>
                            <span class="p-0 m-0 menu-1 text-end">
                                <b>Rp. {{ number_format($total,0) }}</b> 
                            </span>
                        </div>
                    @else
                    <div class="col-lg-6">
                        <span class="text-muted">Subtotal :</span>
                    </div>
                    <div class="col-lg-6 text-end">
                        <?php
                            $total_price = $item->total_price;
                        ?>
                        <span class="p-0 m-0 menu-1 text-end">
                            <b>Rp. {{ number_format($total_price,0) }}</b> 
                        </span>
                    </div>
                    @endif
                </div>
                
            </div>
        </div>
    </div>
</div>
