@extends('layouts.app')

@section('style')
@endsection
<style>
    .radius-r-20{
        border-radius: 20px 50% 50% 20px !important;
    }
    .card {
        cursor: pointer;
        transition: all 0.2s;
    }

    .card:hover {
        transform: scale(1.02) !important;
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 5px 8px rgba(0, 0, 0, .06);
    }
    .bg-gray-400{
        background: #191c24;
    }
</style>

@section('content')
    <div class="row mt-4">
        @can('user-list')
        <div class="col-12 col-lg-4 col-md-6" onclick="location.href='{{ route('master-data.users.index') }}'">
            <div class="card w-100 bg-card-blue mb-3">
                <div class="p-4 d-flex align-items-stretch h-100">
                  <div class="row">
                    <div class="col-4 col-md-3 d-flex align-items-center">
                      <img src="{{ asset('assets/images/logos/user.png') }}" class="rounded img-fluid" />
                    </div>
                    <div class="col-8 col-md-9 d-flex align-items-center">
                      <div>
                        <a href="javascript:void(0)" class="text-white fw-bold fs-4 link lh-sm">Users</a>
                        <h6 class="card-subtitle mt-2 mb-0 fw-normal" style="color:#ffffffad;">
                          Create,Update, and Delete Menu Users
                        </h6>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        @endcan
        @can('user-list')
        <div class="col-12 col-lg-4 col-md-6" onclick="location.href='{{ route('master-data.departements.index') }}'">
            <div class="card w-100 bg-card-blue mb-3">
                <div class="p-4 d-flex align-items-stretch h-100">
                  <div class="row">
                    <div class="col-4 col-md-3 d-flex align-items-center">
                      <img src="{{ asset('assets/images/logos/department.png') }}" class="rounded img-fluid" />
                    </div>
                    <div class="col-8 col-md-9 d-flex align-items-center">
                      <div>
                        <a href="javascript:void(0)" class="text-white fw-bold fs-4 link lh-sm">Departements</a>
                        <h6 class="card-subtitle mt-2 mb-0 fw-normal" style="color:#ffffffad;">
                          Create,Update, and Delete Menu Departements
                        </h6>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        @endcan
        @can('material-list')
        
        @endcan
        <div class="col-12 col-lg-4 col-md-6" onclick="location.href='{{ route('products.index') }}'">
            <div class="card w-100 bg-card-blue mb-3">
                <div class="p-4 d-flex align-items-stretch h-100">
                  <div class="row">
                    <div class="col-4 col-md-3 d-flex align-items-center">
                      <img src="{{ asset('assets/images/logos/material.png') }}" class="rounded img-fluid" />
                    </div>
                    <div class="col-8 col-md-9 d-flex align-items-center">
                      <div>
                        <a href="javascript:void(0)" class="text-white fw-bold fs-4 link lh-sm">Product</a>
                        <h6 class="card-subtitle mt-2 mb-0 fw-normal" style="color:#ffffffad;">
                          Create,Update, and Delete Menu Product
                        </h6>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>

        @can('tag-list')
        <div class="col-12 col-lg-4 col-md-6" onclick="location.href='{{ route('master-data.tags.index') }}'">
            <div class="card w-100 bg-card-blue mb-3">
                <div class="p-4 d-flex align-items-stretch h-100">
                  <div class="row">
                    <div class="col-4 col-md-3 d-flex align-items-center">
                      <img src="{{ asset('assets/images/logos/tag.png') }}" class="rounded img-fluid" />
                    </div>
                    <div class="col-8 col-md-9 d-flex align-items-center">
                      <div>
                        <a href="javascript:void(0)" class="text-white fw-bold fs-4 link lh-sm">Category</a>
                        <h6 class="card-subtitle mt-2 mb-0 fw-normal" style="color:#ffffffad;">
                          Create,Update, and Delete Menu Category
                        </h6>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        @endcan

        @can('other-setting')
        <div class="col-12 col-lg-4 col-md-6" onclick="location.href='{{ route('master-data.other-settings.index') }}'">
            <div class="card w-100 bg-card-blue mb-3">
                <div class="p-4 d-flex align-items-stretch h-100">
                  <div class="row">
                    <div class="col-4 col-md-3 d-flex align-items-center">
                      <img src="{{ asset('assets/images/logos/other.png') }}" class="rounded img-fluid" />
                    </div>
                    <div class="col-8 col-md-9 d-flex align-items-center">
                      <div>
                        <a href="javascript:void(0)" class="text-white fw-bold fs-4 link lh-sm">Other Setting</a>
                        <h6 class="card-subtitle mt-2 mb-0 fw-normal" style="color:#ffffffad;">
                          Create,Update, and Delete Menu Other Setting
                        </h6>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        @endcan

    </div>
@endsection
