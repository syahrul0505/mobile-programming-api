@extends('process.layouts.app')

@push('style-top')

@endpush

@push('style-bot')
<style>
    .form-check-input{
        width: 1.5rem !important;
        height: 1.5rem !important;
    }
     menu-1{
        font-weight: 600 !important;
    }
</style>
@endpush

@section('content')
<section class="p-3">
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach ($orders as $item)
        @if ($item->status_pesanan !== 'selesai')
        <div class="col">
            <div class="card h-100 border-r-20">
                <div class="card-header border-rt-20">
                    {{-- <a data-bs-toggle="modal" data-bs-target="#waiters-{{ $item->code }}" href="{{ route('waiters.dashboard.detail',$item->id) }}" class="text-decoration-none text-dark"> --}}
                        <h5 class="card-title text-center pt-1 fw-bolder">#{{ $item->invoice_no }} </h5>
                        <h5 class="card-title text-center pt-1 fw-bolder">
                            (Meja 
                                @if($item->kode_meja || $item->category == 'Takeaway' )

                                    @if ($item->category == 'Takeaway')
                                    {{ $item->category }}
                                    {{ $item->kode_meja ?? ''}}
                                    
                                    @else
                                        {{ $item->kode_meja ?? ''}}
                                    @endif
                                @elseif($item->biliard_id)
                                    {{ $item->tableBilliard->nama }}    
                                @elseif($item->meeting_room_id)
                                    {{ $item->tableMeetingRoom->nama }} 
                                @endif
                            )
                        </h5>
                    {{-- </a> --}}
                </div>
                <div class="card-body py-0 px-0">
                    <div class="scroll-style">
                        <ul class="list-group list-group-flush">
                            @foreach ($item->orderPivot as $order_pivot)
                                <li class="list-group-item d-flex justify-content-start align-items-center p-2">
                                    <div class="flex-shrink-1">
                                        <input disabled class="form-check-input me-2 p-2 mt-1" onchange="confirmData('{{ $order_pivot->id }}', this)" type="checkbox" value="" aria-label="..." id="checkDetail{{ $order_pivot->id }}" {{ ($order_pivot->status_pemesanan == 'Selesai') ? 'checked' : '' }}>
                                    </div>
                                    <div class="flex-shrink-1">
                                        <h5 class="me-2 mb-0">{{ $loop->iteration }}.</h5>
                                    </div>
                                    <div class="d-flex flex-grow-1 bd-highlight">
                                        <h5 class="p-0 m-0 fw-semi-bold menu-1">
                                            {{ $order_pivot->restaurant->nama }}
                                            ({{ $order_pivot->qty }}) 
                                        </h5>
                                    </div>
                                </li>
                            @endforeach
                            {{-- Meeting --}}
                            @foreach ($item->orderMeeting as $order_meeting)
                                <li class="list-group-item d-flex justify-content-start align-items-center p-2">
                                    <div class="flex-shrink-1">
                                        <input disabled class="form-check-input me-2 p-2 mt-1" onchange="confirmData('{{ $order_meeting->id }}', this)" type="checkbox" value="" aria-label="..." id="checkDetail{{ $order_meeting->id }}" {{ ($order_meeting->status_pemesanan == 'Selesai') ? 'checked' : '' }}>
                                    </div>
                                    <div class="flex-shrink-1">
                                        <h5 class="me-2 mb-0">{{ $loop->iteration }}.</h5>
                                    </div>
                                    <div class="d-flex flex-grow-1 bd-highlight">
                                        <h5 class="p-0 m-0 fw-semi-bold menu-1">
                                            {{ $order_meeting->restaurant->nama }}
                                        </h5>
                                    </div>
                                </li>
                            @endforeach
                            {{-- Restaurant --}}
                            @foreach ($item->orderBilliard as $order_billiard)
                                <li class="list-group-item d-flex justify-content-start align-items-center p-2">
                                    <div class="flex-shrink-1">
                                        <input disabled class="form-check-input me-2 p-2 mt-1" onchange="confirmData('{{ $order_billiard->id }}', this)" type="checkbox" value="" aria-label="..." id="checkDetail{{ $order_billiard->id }}" {{ ($order_billiard->status_pemesanan == 'Selesai') ? 'checked' : '' }}>
                                    </div>
                                    <div class="flex-shrink-1">
                                        <h5 class="me-2 mb-0">{{ $loop->iteration }}.</h5>
                                    </div>
                                    <div class="d-flex flex-grow-1 bd-highlight">
                                        <h5 class="p-0 m-0 fw-semi-bold menu-1">
                                            {{ $order_billiard->restaurant->nama }}
                                        </h5>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="px-2 py-2">
                            {{-- <input class="form-check-input me-2 p-2 mt-1" type="checkbox" value="" onchange="successOrder('{{ $item->id }}')" aria-label="..." id=""> Success --}}
                        @if ($item->status_pesanan == 'Done')
                            <button class="btn btn-success rounded-lg p-2 mt-1 w-100" onclick="confirmData('{{ $item->id }}')">Selesaikan Pemesanan</button>
                        @else
                            <button disabled class="btn btn-success rounded-lg p-2 mt-1 w-100" onclick="confirmData('{{ $item->id }}')">Selesaikan Pemesanan</button>
                        @endif
                    </div>
                </div>

                <div class="card-footer border-rb-20">
                    {{-- @foreach ($item->orderPivot as $status)
                        @endforeach --}}
                        {{-- <a href="{{ route('waiters.tes',$item->id) }}" class="btn btn-success" style="font-size: .75em; border-radius: .25rem;">Success</a> --}}
                    {{-- <span class="badge bg-success">Success</span> --}}
                    <small class="text-muted">Customer :<span class="text-success"> <b> {{ strtoupper($item->name) }} </b></span></small><br>
                    <small class="text-muted">Last updated <span class="text-danger">{{ $item->elapsed_time }}</span></small><br>
                    <small class="text-muted">Datetime Order <span class="text-danger">{{ $item->created_at->format('H:i') }}</span></small>
                </div>
            </div>
            {{-- @include('process.waiters.modal') --}}

        </div>
        @endif
        @endforeach
    </div>
</section>
{{-- @include('process.waiters.modal') --}}
@endsection

@push('script-top')

@endpush

@push('script-bot')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
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
                            // location.reload();
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
@endpush
