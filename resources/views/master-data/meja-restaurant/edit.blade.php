<div class="modal modal-fullscreen" id="edit-meja-restaurant{{ $meja_restaurant->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('meja-restaurant.update', $meja_restaurant->id) }}" novalidate>
                @method('patch')
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">

                            <div class="form-group mb-3">
                                <label for="nama">Nama Meja</label>
                                <input class="form-control @error('nama') is-invalid @enderror" id="nama" type="text" name="nama" placeholder="nama" required value="{{ old('nama') ?? $meja_restaurant->nama }}">

                                @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label class="">Category</label>
                                <select class="form-control @error('category') is-invalid @enderror" name="category">
                                    <option value="">Select Category</option>
                                    <option value="Indoor" {{ $meja_restaurant->category == 'Indoor' ? 'selected' : '' }}>Indoor</option>
                                    <option value="Outdoor" {{ $meja_restaurant->category == 'Outdoor' ? 'selected' : '' }}>Outdoor</option>
                                </select>

                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label class="">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" name="status">
                                    <option value="">Select Status</option>
                                    <option value="Tersedia" {{ $meja_restaurant->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="Tidak Tersedia" {{ $meja_restaurant->status == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                </select>

                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="no_meja">Nomer Meja</label>
                                <input type="number" class="form-control @error('no_meja') is-invalid @enderror" id="no_meja" name="no_meja" value="{{ old('no_meja') ?? $meja_restaurant->no_meja }}"  placeholder="Enter no_meja">
                                
                                @error('no_meja')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="kode_meja">Kode Meja</label>
                                <input type="text" class="form-control @error('kode_meja') is-invalid @enderror" id="kode_meja" name="kode_meja" value="{{ old('kode_meja') ?? $meja_restaurant->kode_meja }}"  placeholder="Enter kode_meja">
                                
                                @error('kode_meja')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label class="">Status Notifikasi</label>
                                <select class="form-control @error('status_minimal_order') is-invalid @enderror" name="status_minimal_order">
                                    <option disabled selected>Choose Status</option>
                                    <option value="Active" {{ $meja_restaurant->status_minimal_order == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ $meja_restaurant->status_minimal_order == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                
                                {{-- <input type="text" class="form-control @error('minimal_order') is-invalid @enderror" id="minimal_order" name="status_minimal_order" value="{{ old('minimal_order') ?? $meja_restaurant->minimal_order }}"  placeholder="Enter minimal_order"> --}}

                                @error('status_minimal_order')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="minimal_order">Minimal Order</label>
                                <input type="number" class="form-control @error('minimal_order') is-invalid @enderror" id="minimal_order" name="minimal_order" value="{{ old('minimal_order') ?? $meja_restaurant->minimal_order }}"  placeholder="Enter minimal_order">
                                
                                @error('minimal_order')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="position">Position</label>
                                <input type="number" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position') ?? $meja_restaurant->position }}"  placeholder="Enter position">
                                
                                @error('position')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                    </div>


                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="4">{{ $meja_restaurant->description }}</textarea>
                            {{-- <textarea name="description" id="mytextarea">{!! $meja_restaurant->description !!}</textarea> --}}
                            @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger p-2" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary mr-2 p-2">Update</button>
                </div>
            </form>
      </div>
    </div>
  </div>
<script src="https://cdn.tiny.cloud/1/6vch58fk4gud1ywlf06b61zgh32srvlfldxj53oxqnt7fpxt/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>

    tinymce.init({
        selector: '#mytextarea',
        skin: "oxide-dark",
        content_css: "dark"
    });
</script>

