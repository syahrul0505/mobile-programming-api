@extends('layouts.app')

@section('style')
<style>
    .hilang{
    display: none;
  }
  #chart-container{
    width: 30%;
  }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ $page_title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">{{ $page_title }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <form action="" method="get" class="p-2 row mt-3">
        <div class="col-12 mb-0">
            <div class="card rounded-20 mb-0">
                <div class="card-header bg-warning rounded-t-20 pt-1 pl-2 pb-1 pr-2">
                    <h4 class="text-center text-uppercase text-white mt-1">Filter Stok</h4>
                </div>
                <div class="card-body rounded-20 p-3">
                    <div class="row">
                        <div class="col-4 col-lg-2">
                            <div class="form-group">
                                <label class="form-label"> Period :</label>
                                <select class="form-control select2" data-placeholder="Choose one" id="daterange" name="type">
                                    <option value="day" {{ (Request::get('type') == 'day') ? 'selected' : ''}}>Daily</option>
                                    <option value="monthly" {{ (Request::get('type') == 'monthly') ? 'selected' : '' }}>Monthly</option>
                                    <option value="yearly" {{ (Request::get('type') == 'yearly') ? 'selected' : '' }}>Yearly</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-4 col-lg-3">
                            <div class="form-group" id="datepicker-date-area">
                                <label class="form-label"> Date :</label>
                                <input type="text" name="start_date" id="date" value="{{Request::get('start_date') ?? date('Y-m-d')}}" autocomplete="off" class="datepicker-date form-control time" required>
                            </div>
                            <div class="form-group hilang" id="datepicker-month-area">
                                <label class="form-label"> Month :</label>
                                <input type="text" name="month" id="month" value="{{ Request::get('month') ?? date('Y-m') }}" autocomplete="off" class="datepicker-month form-control time" required>
                            </div>
                            <div class="form-group hilang" id="datepicker-year-area">
                                <label class="form-label"> Year :</label>
                                <input type="text" name="year" id="month" value="{{ Request::get('year') ?? date('Y') }}" autocomplete="off" class="datepicker-year form-control" required>
                            </div>
                        </div>

                        <div class="col-4 col-lg-5">
                            <div class="form-group">
                                <label class="form-label">User :</label>
                                <select class="form-select mr-sm-2 @error('user_id') is-invalid @enderror"
                                    id="user" name="user_id" style="width:100%">
                                    <option disabled selected>Choose User</option>
                                    @foreach ($account_users as $account_user)
                                    <option value="{{ $account_user->id }}"
                                        {{ old('account_user_id') == $account_user->id ? 'selected' : '' }}>
                                        {{ $account_user->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary w-100 btn-group-lg p-2 ">
                                    Generate
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

    <div class="row px-3 mt-3">
        <div class="col-12 col-md-4 col-lg-6" style="z-index: -999999">
            <div class="card rounded-20 border-top border-bottom border-success">
                <div class="card-body p-4">
                    <div class="d-flex no-block align-item-center">
                        <div>
                            <h2 class="fs-7">Rp. {{ number_format($total_price,0) }}</h2>
                            <h6 class="fw-medium">Gross Sales(Kotor)</h6>
                        </div>
                        <div class="ms-auto">
                            <span class="text-success display-6"><i class="ti ti-layout-grid fs-8"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-6">
            <div class="card rounded-20 border-top border-bottom border-success">
                <div class="card-body p-4">
                    <div class="d-flex no-block align-item-center">
                        <div>
                            <?php
                                $penjualan_bersih = $total_price - $modal;
                            ?>
                            <h2 class="fs-7">Rp. {{ number_format($penjualan_bersih,0) }}</h2>
                            <h6 class="fw-medium">Nett Sales(Bersih)</h6>
                        </div>
                        <div class="ms-auto">
                            <span class="text-success display-6"><i class="ti ti-layout-grid fs-8"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-0">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card rounded-20">
                <div class="card-header bg-warning" style="border-radius:15px 15px 0px 0px;">
                    <div class="row">
                        <div class="col-12 mt-1">
                            <span class="tx-bold text-lg text-white" style="font-size:20px;">
                            <i class="ti ti-file-text text-lg"></i> &nbsp;
                            {{ $page_title }}
                            </span>
                        </div>
                        {{-- <div class="col-6 mt-1">
                            <ul class="nav nav-pills mb-0 float-end" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link active custom" id="pills-table-tab" data-bs-toggle="pill" data-bs-target="#pills-table" type="button" role="tab" aria-controls="pills-table" aria-selected="true">TABLE</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link custom" id="pills-chart-tab" data-bs-toggle="pill" data-bs-target="#pills-chart" type="button" role="tab" aria-controls="pills-chart" aria-selected="false">CHART</button>
                                </li>
                              </ul>
                        </div> --}}
                    </div>

                    <div class="row">
                        <div class="col-12 mt-2">
                            @include('components.flash-message')
                        </div>
                    </div>
                </div>

                <div class="w-100 position-relative overflow-hidden">
                    <div class="card-body p-4">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-table" role="tabpanel" aria-labelledby="pills-table-tab">
                                <div class="table-responsive rounded-2">
                                    <table id="responsive-datatable" class="table border text-nowrap customize-table mb-0 align-middle">
                                        <thead class="text-dark fs-4">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kasir</th>
                                            <th>Nama Customer</th>
                                            <th>Harga Modal</th>
                                            {{-- <th>Harga Jual</th> --}}
                                            <th>Total Price</th>
                                            <th>PPN <small>(%)</small></th>
                                            <th>Menu</th>
                                            <th>Metode Pembayaran</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td class="table-head">{{ $loop->iteration }}</td>
                                                <td class="table-head">{{ $order->user->name }}</td>
                                                <td class="table-head">{{ $order->name ?? '-'}}</td>
                                                @php    
                                                    $sumModal = 0;
                                                    foreach ($order->orderDetail as $key => $value) {
                                                        $sumModal += $value->modal;
                                                    }
                                                @endphp
                                                <td class="table-head">{{ number_format($order->modal,0) ?? '0'}}</td>
                                                <td class="table-head">{{ number_format($order->total_price,0)}}</td>
                                                <td class="table-head">{{ number_format($order->pb01,0) ?? 0}}</td>
                                                <td class="table-head">
                                                    @foreach ($order->orderDetail as $item)
                                                    <li>{{ $item->restaurant->name }}</li>
                                                    @endforeach
                                                </td>
                                                <td class="table-head">{{ $order->metode_pembayaran}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-chart" role="tabpanel" aria-labelledby="pills-chart-tab">
                                <div class="card-body rounded-20 p-3">
                                    <div>
                                        <canvas id="chart-container" class="chart" style="width: 200px;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
{{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    var dom = document.getElementById('chart-container');
    var myChart = echarts.init(dom, null, {
        renderer: 'canvas',
        useDirtyRect: false
    });

    var totalPriceData = [];
    var costData = [];
    var xAxisData = [];

    @foreach($orders as $order)
        totalPriceData.push({{ $order->total_price }});
        costData.push({{ $order->modal }});
        xAxisData.push('{{ $order->created_at }}'); // Assuming 'created_at' holds date information
    @endforeach

    var option = {
        title: {
            text: ''
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data: ['Total Price', 'Cost']
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        toolbox: {
            feature: {
                saveAsImage: {}
            }
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: xAxisData // Use dynamic x-axis data (dates)
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                name: 'Total Price',
                type: 'line',
                stack: 'Total',
                data: totalPriceData // Use dynamic total price data
            },
            {
                name: 'Cost',
                type: 'line',
                stack: 'Total',
                data: costData // Use dynamic cost data
            }
            // Additional series if required...
        ]
    };

    if (option && typeof option === 'object') {
        myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);
</script>

<script>
    $('.datepicker-date').datepicker({
      format: "yyyy-mm-dd",
        startView: 2,
        minViewMode: 0,
        language: "id",
        daysOfWeekHighlighted: "0",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true,
        container: '#datepicker-date-area'
    });

    $('.datepicker-month').datepicker({
        format: "yyyy-mm",
        startView: 2,
        minViewMode: 1,
        language: "id",
        daysOfWeekHighlighted: "0",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true,
        container: '#datepicker-month-area'
    });

    $('.datepicker-year').datepicker({
        format: "yyyy",
        startView: 2,
        minViewMode: 2,
        language: "id",
        daysOfWeekHighlighted: "0",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true,
        container: '#datepicker-year-area'
    });

    let rangeNow = $('#daterange').val();
    if (rangeNow == 'day') {
        $('#datepicker-date-area').removeClass('hilang');
        const element = document.querySelector('#datepicker-date-area')
        element.classList.add('animated', 'fadeIn')
        // Hilangkan Month
        $('#datepicker-month-area').addClass('hilang');
        $('#datepicker-year-area').addClass('hilang');

    } else if(rangeNow == 'monthly') {
        $('#datepicker-month-area').removeClass('hilang');
        const element = document.querySelector('#datepicker-month-area')
        element.classList.add('animated', 'fadeIn')
        // Hilangkan Date
        $('#datepicker-date-area').addClass('hilang');
        $('#datepicker-year-area').addClass('hilang');
    } else {
        $('#datepicker-year-area').removeClass('hilang');
        const element = document.querySelector('#datepicker-year-area')
        element.classList.add('animated', 'fadeIn')
        // Hilangkan Date
        $('#datepicker-date-area').addClass('hilang');
        $('#datepicker-month-area').addClass('hilang');
    }

    $('#daterange').on('change', function () {
        val = $(this).val();
        if (val == 'day') {
            $('#datepicker-date-area').removeClass('hilang');
            const element = document.querySelector('#datepicker-date-area')
            element.classList.add('animated', 'fadeIn')
            // Hilangkan Month
            $('#datepicker-month-area').addClass('hilang');
            $('#datepicker-year-area').addClass('hilang');

        } else if(val == 'monthly') {
            $('#datepicker-month-area').removeClass('hilang');
            const element = document.querySelector('#datepicker-month-area')
            element.classList.add('animated', 'fadeIn')
            // Hilangkan Date
            $('#datepicker-date-area').addClass('hilang');
            $('#datepicker-year-area').addClass('hilang');
        } else {
            $('#datepicker-year-area').removeClass('hilang');
            const element = document.querySelector('#datepicker-year-area')
            element.classList.add('animated', 'fadeIn')
            // Hilangkan Date
            $('#datepicker-date-area').addClass('hilang');
            $('#datepicker-month-area').addClass('hilang');
        }
    })
</script>
@endpush

@endsection
