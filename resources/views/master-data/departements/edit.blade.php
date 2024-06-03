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
                        <li class="breadcrumb-item"><a href="{{ route('master-data.departements.index') }}">Departement</a></li>
                        <li class="breadcrumb-item active">{{ $page_title }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card card-primary" style="border-radius:15px;">
                <div class="card-header text-center bg-warning" style="border-radius:15px 15px 0px 0px;">
                    <h3 class="card-title text-white">{{ $page_title }}</h3>
                </div>

                <form action="{{ route('master-data.departements.update',$departement->id) }}" method="POST" >
                    @method('patch')
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ old('name') ?? $departement->name }}" class="form-control" placeholder="Name" id="name" aria-describedby="name">
                                </div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">Permissions</label> <br>
                                    {{-- <small>Select All</small>
                                    <input type="checkbox" id="checkbox"> --}}

                                    <div class="select2-purple">
                                        <select class="js-example-basic-multiple" name="permissions[]" id="e1" data-placeholder="Select The Permissions" multiple data-dropdown-css-class="select2-purple" style="width: 100%;">
                                            @foreach ($permissions as $permission)
                                                <option value="{{$permission->id}}"
                                                    @foreach (old('permissions') ?? $rolePermissions as $id)
                                                        @if ($id == $permission->id)
                                                            {{ ' selected' }}
                                                        @endif
                                                    @endforeach>
                                                    {{$permission->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @error('permissions')
                                        <span class="text-danger f-12">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer bg-warning mt-2 text-end" style="border-radius:0px 0px 15px 15px;">
                        <a class="btn btn-danger" href="{{ route('master-data.departements.index') }}">
                            Back
                        </a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
@endpush
@endsection
