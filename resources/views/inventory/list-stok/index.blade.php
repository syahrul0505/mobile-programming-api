@extends('layouts.app')

@section('style')
<style>
    .hilang{
    display: none;
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

    {{-- <form action="" method="get" class="p-2 row mt-3">
        <div class="col-12 mb-0">
            <div class="card rounded-20">
                <div class="card-header bg-warning rounded-t-20 pt-1 pl-2 pb-1 pr-2">
                    <h4 class="text-center text-uppercase text-white mt-1">Filter Stok</h4>
                </div>
                <div class="card-body rounded-20">
                    <div class="row align-items-center">
                        <div class="col-6 col-lg-2 mb-3">
                            <div class="form-group ">
                                <label class="form-label"> Period :</label>
                                <select class="form-control select2" data-placeholder="Choose one" id="daterange" name="type">
                                    <option value="day" {{ (Request::get('type') == 'day') ? 'selected' : ''}}>Daily</option>
                                    <option value="monthly" {{ (Request::get('type') == 'monthly') ? 'selected' : '' }}>Monthly</option>
                                    <option value="yearly" {{ (Request::get('type') == 'yearly') ? 'selected' : '' }}>Yearly</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3 mb-3">
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
                                <input type="text" name="year" id="year" value="{{ Request::get('year') ?? date('Y') }}" autocomplete="off" class="datepicker-year form-control" required>
                            </div>
                        </div>

                        <div class="col-12 col-lg-5">
                            <div class="form-group mb-3">
                                <label class="form-label">Material :</label>
                                <select class="form-select mr-sm-2 @error('material_id') is-invalid @enderror" id="material_id" name="material_id" style="width:100%">
                                    <option disabled selected>Choose Material</option>
                                    @foreach ($materials as $material)
                                    <option value="{{ $material->id }}"
                                        {{ old('material_id') == $material->id ? 'selected' : '' }}>
                                        {{ $material->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-warning btn-group-lg p-2 w-100">
                                Generate
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form> --}}

    <div class="row mt-2">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card rounded-20">
                <div class="card-header bg-warning" style="border-radius:15px 15px 0px 0px;">
                    <div class="row align-items-center">
                        <div class="col-6 mt-1">
                            <span class="tx-bold text-lg text-white" style="font-size:20px;">
                            <i class="far fa-user text-lg"></i> &nbsp;
                            {{ $page_title }}
                            </span>
                        </div>

                        <div class="col-6 d-flex justify-content-end">
                            @can('stock-in-create')
                            <a href="{{ route('stock-ins.create') }}" class="btn btn-sm btn-success me-2" style="padding: 0.4rem;">
                                Stock In
                            </a>
                            @endcan
                            @can('stock-out-create')
                            <a href="{{ route('stock-outs.create') }}" class="btn btn-sm btn-danger me-2" style="padding: 0.4rem;">
                                Stock Out
                            </a>
                            @endcan
                        </div>
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
                            <table id="dataTable" class="table border text-nowrap customize-table mb-0 align-middle">
                              <thead class="text-dark fs-4">
                                <tr>
                                  <th>No</th>
                                  <th>Name</th>
                                  <th>Total Stock</th>
                                  <th>Stock In</th>
                                  <th>Stock Out</th>
                                </tr>
                              </thead>
                              <tbody>
                                  {{-- {{ dd($materials) }} --}}
                                @foreach ($materials as $material)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $material->name }}</td>
                                    <td>{{ $material->totalStock($material->id) }}</td>
                                    <td>{{ $material->stockIn->sum('material_in') }}</td>
                                    <td>{{ $material->stockOut->sum('material_out') }}</td>
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

@push('script')
{{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> --}}
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

@endsection
