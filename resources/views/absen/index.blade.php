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
                        <li class="breadcrumb-item active">{{ $page_title }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row px-3 mt-3">
        <div class="col-12 col-md-4 col-lg-6">
            <div class="card rounded-20 border-top border-bottom border-warning">
                <div class="card-body p-4">
                    <div class="d-flex no-block align-item-center">
                        <div>
                            <h2 class="fs-7">{{(Auth::user()->name != null) ? Auth::user()->name : '' }}</h2>
                        </div>
                        <div class="ms-auto">
                            <span class="text-success display-6"><i class="ti ti-layout-grid fs-8"></i></span>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label"> Period :</label>
                            <select class="form-control select2" data-placeholder="Choose one" id="daterange" name="type">
                                <option value="masuk">Masuk</option>
                                <option value="keluar">Keluar</option>
                            </select>
                        </div>
                    </div>
                    
                    <form action="{{ route('absens-masuk') }}" method="POST" id="form-masuk">
                        @csrf
                        <div class="form-group mt-4">
                            @if ($absen_masuk)
                                <button disabled type="button" class="btn btn-success w-100 btn-group-lg p-2">
                                    Sudah Masuk
                                </button>
                            @else
                                <button type="submit" class="btn btn-warning w-100 btn-group-lg p-2">
                                    Masuk
                                </button>
                            @endif
                        </div>
                    </form>
                    
                    <form action="{{ route('absens-keluar') }}" method="POST" id="form-keluar" class="d-none">
                        @csrf
                        <div class="form-group mt-4">
                            @if ($absen_keluar)
                                <button disabled type="button" class="btn btn-danger w-100 btn-group-lg p-2">
                                    Sudah Keluar
                                </button>
                            @else
                                <button type="submit" class="btn btn-danger w-100 btn-group-lg p-2">
                                    Keluar
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-0">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card rounded-20">
                <div class="card-header bg-warning" style="border-radius:15px 15px 0px 0px;">
                    <div class="row">
                        <div class="col-6 mt-1">
                            <span class="tx-bold text-lg text-white" style="font-size:20px;">
                            <i class="far fa-user text-lg"></i> &nbsp;
                            {{ $page_title }}
                            </span>
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
                            <table id="responsive-datatable" class="table border text-nowrap customize-table mb-0 align-middle">
                              <thead class="text-dark fs-4">
                                <tr>
                                  <th><h6 class="fw-semibold mb-0">No</h6></th>
                                  <th><h6 class="fw-semibold mb-0">Name</h6></th>
                                  <th><h6 class="fw-semibold mb-0">Date</h6></th>
                                  <th><h6 class="fw-semibold mb-0">Jam Masuk</h6></th>
                                  <th><h6 class="fw-semibold mb-0">Jam Keluar</h6></th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($absens as $order)
                                    <tr>
                                        <td class="table-head">{{ $loop->iteration }}</td>
                                        <td class="table-head">{{ Auth::user()->name }}</td>
                                        <td class="table-head">{{ $order->date }}</td>
                                        <td class="table-head">{{ $order->start_time}}</td>
                                        <td class="table-head">{{ $order->end_time}}</td>
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


{{-- <script>
    document.getElementById('daterange').addEventListener('change', function() {
        var selectedValue = this.value;

        if (selectedValue === 'masuk') {
            document.getElementById('form-masuk').classList.remove('d-none');
            document.getElementById('form-keluar').classList.add('d-none');
        } else if (selectedValue === 'keluar') {
            document.getElementById('form-masuk').classList.add('d-none');
            document.getElementById('form-keluar').classList.remove('d-none');
        }
    });
</script> --}}
<script>
    $(document).ready(function() {
        $('#daterange').change(function() {
            var selectedOption = $(this).val();
            
            if (selectedOption === 'masuk') {
                $('#form-masuk').removeClass('d-none');
                $('#form-keluar').addClass('d-none');
            } else if (selectedOption === 'keluar') {
                $('#form-keluar').removeClass('d-none');
                $('#form-masuk').addClass('d-none');
            }
        });
    });
</script>

@endpush

@endsection
