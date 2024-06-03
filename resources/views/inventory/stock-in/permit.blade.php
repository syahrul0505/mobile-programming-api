<div class="modal modal-fullscreen" id="permit{{ $stok_masuk->id }}" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <input type="hidden" name="id_stock" id="id_stock" value="{{ $stok_masuk->id }}" />
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
                                    <option selected value="Stok Masuk">Stok Masuk</option>
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

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label>User</label>
                                <input type="checkbox" id="checkbox">
                                <select name="email" class="js-example-basic-multiple select2-department select2" id="e1{{ $stok_masuk->id }}" multiple ="multiple" style="width:100%">
                                    @foreach ($users as $user)
                                    @if ($user->getRoleNames()[0] == 'Admin')
                                    <option value="{{$user->email}}"
                                        @foreach (old('user_id') ?? [] as $id)
                                        @if ($id == $user->id)
                                        {{ 'selected' }}
                                        @endif
                                        @endforeach>
                                        {{$user->name}}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
        
                                @error('tag_id')
                                      <span class="text-danger text-sm">
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

<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>


<script>
    $("#checkbox").click(function () {
        if ($("#checkbox").is(':checked')) {
            $("#e1{{$stok_masuk->id}} > option").prop("selected", "selected");
            $("#e1{{$stok_masuk->id}}").trigger("change");
        } else {
            $("#e1{{$stok_masuk->id}} > option").removeAttr("selected");
            $("#e1{{$stok_masuk->id}}").val("");
            $("#e1{{$stok_masuk->id}}").trigger("change");
        }
    });
</script>




