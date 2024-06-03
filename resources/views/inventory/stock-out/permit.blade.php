<div class="modal modal-fullscreen" id="permit{{ $stok_keluar->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">EDIT {{ strtoupper($page_title) }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="forms-sample" method="POST" action="{{ route('permit.store') }}" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label class="">Action</label>
                                <input type="hidden" name="id_stock" id="id_stock" value="{{ $stok_keluar->id }}" />
                                <select class="form-control @error('action') is-invalid @enderror" name="action">
                                    <option disabled selected>Choose Action</option>
                                    <option value="edit">Edit</option>
                                    <option value="delete">Delete</option>
                                </select>

                                @error('action')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label class="">Page</label>
                                <select class="form-control @error('page') is-invalid @enderror" name="page">
                                    <option selected value="Stok Keluar">Stok Keluar</option>
                                </select>

                                @error('page')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="datetime">Date</label>
                                <input type="date" class="form-control @error('datetime') is-invalid @enderror" id="datetime" name="datetime" value="{{  date('Y-m-d') ?? old('datetime') }}"  placeholder="No Meja">

                                @error('datetime')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="4"></textarea>

                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger p-2" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary mr-2 p-2">Send Permit</button>
                </div>
            </form>
        </div>
    </div>
</div>



