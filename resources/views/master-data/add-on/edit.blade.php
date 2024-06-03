@extends('layouts.app')

@section('style')

@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ $page_title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('master-data.add-ons.index') }}">Add On</a></li>
                        <li class="breadcrumb-item active">{{ $page_title }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card" style="border-radius:15px;">
                <div class="card-header text-center bg-warning" style="border-radius:15px 15px 0px 0px;">
                    <h3 class="card-title text-white">{{ $page_title }}</h3>
                </div>

                <form action="{{ route('master-data.add-ons.update',$add_ons->id) }}" method="POST">
                    @method('patch')
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="add_on_name" class="form-label">Name</label>
                                    <input type="text" name="add_on_name" value="{{ old('add_on_name') ?? $add_ons->name }}" class="form-control" placeholder="add_on_name" id="add_on_name" aria-describedby="add_on_name">
                                </div>
                                @error('add_on_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="minimal_choice" class="form-label">minimal Choice</label>
                                    <input type="number" name="minimal_choice" value="{{ old('minimal_choice') ?? $add_ons->minimal_choice }}" class="form-control" placeholder="minimal_choice" id="minimal_choice" aria-describedby="minimal_choice">
                                </div>
                                @error('minimal_choice')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <h4>Add On Detail <small class="text-danger">*</small></h4>
                        <hr>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <table class="table table-striped" id="addOnTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Harga</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($add_ons->detailAddOn as $key => $item)
                                        {{-- {{ dd($item) }} --}}
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name[]" value="{{ $item->name }}"  placeholder="name">

                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </td>

                                            <td>
                                                <input type="text" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga[]" value="{{ $item->harga }}"  placeholder="harga">

                                                @error('harga')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-outline-success" id="btn-add-document" onclick="addField()">
                                                    <i class="fas fa-plus-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-danger btn-remove" onclick="$(this).parent().parent().remove();"><i class="fa fa-minus"></i></button>

                                            <td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-warning mt-2 text-end" style="border-radius:0px 0px 15px 15px;">
                        <a class="btn btn-danger" href="{{ route('master-data.tags.index') }}">
                            Back
                        </a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    function addField() {
        var rowCount = $('#addOnTable tr').length;
        $("#addOnTable").find('tbody')
            .append(
                $('<tr>' +
                    '<td><input class="form-control" placeholder="Input nama" type="text" name="name[]" id="nama'+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    '<td><input class="form-control" placeholder="Input harga" type="number" name="harga[]" id="harga'+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    '<td style="max-width: 6% !important"><button type="button" class="btn btn-outline-danger btn-remove" onclick="$(this).parent().parent().remove();changeOptionValue();"><i class="fa fa-minus"></i></button></td>' +
                    '</tr>'
                )
            )
    }

  </script>
@endsection
