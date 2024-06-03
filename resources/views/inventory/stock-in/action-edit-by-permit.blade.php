@extends('home')

@section('style')

@endsection

@section('content')

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card rounded-20">
                <div class="card-header rounded-t-20">
                    <h3 class="text-center">{{ $page_title }}</h3>
                </div>
                <div class="card-body rounded-b-20">
                    <form class="forms-sample" method="POST" action="{{ route('updateByPermit', $token) }}" novalidate>
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label>Material</label>
                                <select class="js-example-basic-single @error('material_id') is-invalid @enderror" id="material_id" name="material_id" style="width:100%">
                                    @foreach ($materials as $material)
                                    <option value="{{ $material->id }}" {{ $stok_masuk->material_id == $material->id ? 'selected' : '' }}>{{ $material->nama }} </option>
                                    @endforeach
                                </select>
                                @error('material_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="material_masuk">Stok Masuk</label>
                                <input class="form-control @error('material_masuk') is-invalid @enderror" id="name" type="text" name="material_masuk" placeholder="Stok MAsuk" required value="{{ old('material_masuk') ?? $stok_masuk->material_masuk }}">

                                @error('material_masuk')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" id="description" rows="4">{{ $stok_masuk->description }}</textarea>

                                @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('permit.index') }}" class="btn btn-danger p-2">Back</a>
                            <button type="submit" class="btn btn-primary mr-2 p-2">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script>
     $("#checkbox").click(function () {
       if ($("#checkbox").is(':checked')) {
           $("#e1 > option").prop("selected", "selected");
           $("#e1").trigger("change");
       } else {
           $("#e1 > option").removeAttr("selected");
           $("#e1").val("");
           $("#e1").trigger("change");
       }
   });
</script>
@endsection

