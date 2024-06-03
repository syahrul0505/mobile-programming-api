<div class="modal modal-fullscreen" id="tambah-meja-restaurant" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $page_title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="forms-sample" action="{{ route('meja-restaurant.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group mb-3">
                            <label for="nama">Nama Meja</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}"  placeholder="Enter nama">
                            
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
                                <option disabled selected>Choose Category</option>
                                <option value="Indoor">Indoor</option>
                                <option value="Outdoor">Outdoor</option>
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
                                <option disabled selected>Choose Status</option>
                            <option value="Tersedia">Tersedia</option>
                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                            </select>
                            
                            @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="col-lg-4">
                        <div class="form-group mb-3">
                            <label for="no_meja">Nomer Meja</label>
                            <input type="number" class="form-control @error('no_meja') is-invalid @enderror" id="no_meja" name="no_meja" value="{{ old('no_meja') }}"  placeholder="Enter no_meja">
                            
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
                            <input type="text" class="form-control @error('kode_meja') is-invalid @enderror" id="kode_meja" name="kode_meja" value="{{ old('kode_meja') }}"  placeholder="Enter kode_meja">
                            
                            @error('kode_meja')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group mb-3">
                            <label class="">Status Minimal Order</label>
                            <select class="form-control @error('status_minimal_order') is-invalid @enderror" name="status_minimal_order">
                                <option disabled selected>Choose Status Minimal Order</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            </select>
                            
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
                            <input type="number" min="0" class="form-control @error('minimal_order') is-invalid @enderror" id="minimal_order" name="minimal_order" value="{{ old('minimal_order') }}"  placeholder="Enter Minimal Order">
                            
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
                            <input type="number" min="0" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position') }}"  placeholder="Enter Minimal Order">
                            
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
                        <textarea name="description" class="form-control" id="description" rows="4"></textarea>
                        {{-- <textarea name="description" id="mytextarea"></textarea> --}}
                        @error('content')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger p-2" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary mr-2 p-2">Submit</button>
                </div>
            </form>
        </div>
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
