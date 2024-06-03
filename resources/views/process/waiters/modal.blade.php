{{-- Modal --}}
<div class="modal fade" id="waiters-{{ $item->code }}" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="flex-grow-1 text-center">
                    <h2 class="modal-title" id="modalLabel">Detail Order <span class="text-danger">#{{ $item->code }}</span></h2>
                </div>
                <div class="flex-shrink-1">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                
                <ul class="list-group list-group-flush pe-3">
                    @foreach ($item->orderPivot as $order_pivot)
                    <li class="list-group-item d-flex justify-content-start align-items-start">
                        <div class="flex-shrink-1">
                            <input class="form-check-input me-2 p-2 mt-1" onchange="confirmData('{{ $order_pivot->id }}')" type="checkbox" value="" aria-label="..." id="checkDetail{{ $order_pivot->id }}" {{ ($order_pivot->status_pemesanan == 'Selesai') ? 'checked disabled' : '' }}>
                        </div>
                        <div class="flex-shrink-1">
                            <h3 class="me-2 mb-0">1.</h3>
                        </div>
                        <div class="d-flex flex-column bd-highlight">
                            <h3 class="p-0 m-0 fw-semi-bold menu-1">
                                {{ $order_pivot->restaurant->nama }}
                            </h3>
                            <span class="text-wrap fs-5">
                                Note: Pedas, No Acar.
                            </span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <span class="badge bg-success fs-6">Success</span>
                <span class="text-muted">Last updated 3 mins ago</span>
            </div>
        </div>
    </div>
 </div>
 {{-- End Modal --}}
