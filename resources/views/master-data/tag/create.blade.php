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
                        <li class="breadcrumb-item"><a href="{{ route('master-data.tags.index') }}">Tag</a></li>
                        <li class="breadcrumb-item active">{{ $page_title }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 mt-4">
        <div class="card" style="border-radius:15px;">
            <div class="card-header text-center bg-warning" style="border-radius:15px 15px 0px 0px;">
                <h3 class="card-title text-white">{{ $page_title }}</h3>
            </div>
            <form action="{{ route('master-data.tags.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="tag_name" class="form-label">Tag Name</label>
                                <input type="text" name="tag_name" value="{{ old('tag_name') }}" class="form-control" placeholder="tag_name" id="tag_name" aria-describedby="tag_name">
                            </div>
                            @error('tag_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="position" class="form-label">Position</label>
                                <input type="number" name="position" value="{{ old('position') }}" class="form-control" placeholder="position" id="position" aria-describedby="position">
                            </div>
                            @error('position')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-lg-12">
                          <div class="form-group mb-3">
                              <label for="status">Status</label>
                              <select class="form-control form-select @error('status') is-invalid @enderror" name="status">
                                  <option disabled selected>Choose Status</option>
                                  <option value="active" {{ (old('status') == 'active') ? 'selected' : '' }}>Active</option>
                                  <option value="inactive" {{ (old('status') == 'inactive') ? 'selected' : '' }}>Inactive</option>
                              </select>
                              @error('status')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                          </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end bg-warning" style="border-radius:0px 0px 15px 15px;">
                    <a class="btn btn-danger" href="{{ route('master-data.tags.index') }}">
                        Back
                    </a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
