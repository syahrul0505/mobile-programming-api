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
                        <li class="breadcrumb-item active">{{ $page_title }} /</li>
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

                        {{-- <div class="col-4 col-lg-5">
                            <div class="form-group">
                                <label class="form-label">Product :</label>
                                <select class="form-select mr-sm-2 @error('restaurant_id') is-invalid @enderror"
                                    id="user" name="restaurant_id" style="width:100%">
                                    <option disabled selected>Choose Product</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}

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

    <div class="row align-items-center mt-4">
        <div class="col-lg-12 grid-margin stretch-card" style="margin-top: 150px;">
            <div class="card rounded-20">
                <div class="card-header bg-warning" style="border-radius:15px 15px 0px 0px;">
                    <div class="row">
                        <div class="col-6 mt-1">
                            <span class="tx-bold text-lg text-white" style="font-size:20px;">
                            <i class="far fa-user text-lg"></i> &nbsp;
                            {{ $page_title }}
                            </span>
                        </div>

                        @can('stock-in-create')
                        <div class="col-6 d-flex justify-content-end">
                            <a href="{{ route('stock-in-products.create') }}" class="btn btn-sm btn-info p-2">
                                <i class="fa fa-plus"></i>
                                Add New
                            </a>
                        </div>
                        @endcan
                    </div>

                    <div class="row">
                        <div class="col-12 mt-2">
                            @include('components.flash-message')
                        </div>
                    </div>
                </div>

                <div class="w-100 position-relative overflow-hidden">
                    <div class="card-body p-4">
                        <div class="table-responsive rounded-2">
                            <table id="dataTableStockIn" class="table border text-nowrap customize-table mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Stock In</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stock_ins as $stock_in)

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $stock_in->product->name ?? '' }}</td>
                                        <td>{{ $stock_in->product_in }}</td>
                                        <td>{{ $stock_in->description }}</td>
                                        @if(auth()->user()->can('stock-in-delete'))
                                        <td>
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown"aria-expanded="false">
                                                <i class="fa fa-ellipsis-v fs-6"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @can('stock-in-delete')
                                                <a href="#" class="dropdown-item d-flex align-items-center gap-3" onclick="modalDelete('Stock In', '{{ $stock_in->product->name }}', '/stock-in-products/' + {{ $stock_in->id }}, '/stock-in-products/')">
                                                    <i class="far fa-trash-alt"></i>
                                                    Delete
                                                </a>
                                                @endcan
                                            </ul>
                                        </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
