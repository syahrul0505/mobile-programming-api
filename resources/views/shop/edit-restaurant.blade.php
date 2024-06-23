<div class="modal fade" id="restaurant-edit-{{ $restaurant->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="restaurant-edit-{{ $restaurant->id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restaurant-edit-{{ $restaurant->id }}Label">Restaurant Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('restaurants.update',$restaurant->id) }}" method="POST" enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" name="name" value="{{ old('name') ?? $restaurant->name }}" class="form-control" placeholder="name" id="name" aria-describedby="name">
                                        </div>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="modal" class="form-label">Modal</label>
                                            <input type="number" min="0" name="modal" value="{{ old('modal') ?? $restaurant->modal }}" class="form-control" placeholder="modal" id="modal" aria-describedby="modal">
                                        </div>
                                        @error('modal')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="number" name="price" id="price" value="{{ old('price') ?? $restaurant->price }}" class="form-control" placeholder="price" id="price" aria-describedby="price">
                                        </div>
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
{{--                                     
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="stock_in" class="form-label">Stock Tersedia</label>
                                            <input type="number" name="stock_in" id="stock_in" value="{{ old('stock_in') ?? $restaurant->current_stock }}" class="form-control" placeholder="stock_in" id="stock_in" aria-describedby="stock_in">
                                        </div>
                                        @error('stock_in')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="stock_per_day" class="form-label">Stock In</label>
                                            <input type="number" name="stock_per_day" id="stock_per_day" value="{{ old('stock_per_day') ?? $restaurant->stock_per_day }}" class="form-control" placeholder="stock_per_day" id="stock_per_day" aria-describedby="stock_per_day">
                                        </div>
                                        @error('stock_per_day')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> --}}

                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-lg-12 mt-2">
                                        <div class="form-group mb-3">
                                            <label for="form-file" class="form-label">Image</label> <br>
                                            <img src="{{ asset('assets/images/restaurant/'.($restaurant->avatar ?? 'user.jpg')) }}" width="15%"height="15%" class=" mb-2 rounded-circle me-n2 card-hover border border-2 border-white">
                                            <input type="file" name="image" class="form-control" id="form-file">
                                        </div>
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div class="small text-danger">*Kosongkan jika tidak mau diisi</div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Tag</label>

                                            <select name="tag_id[]" class="form-control" id="tag-input-select2-edit-{{ $restaurant->id }}" multiple="multiple" style="width:100%">
                                                @foreach ($tags as $tag)
                                                    <option value="{{$tag->id}}" {{ (in_array($tag->id, $restaurant->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                        {{$tag->tag_name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="status">Status</label>
                                            <select class="form-select @error('status') is-invalid @enderror" name="status">
                                                <option disabled selected>Choose Status</option>
                                                <option value="active" {{ ($restaurant->status == 'active') ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ ($restaurant->status == 'inactive') ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="number" name="price" id="price" value="{{ old('price') ?? $restaurant->price }}" class="form-control" placeholder="price" id="price" aria-describedby="price">
                                        </div>
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                           <label for="description">Description</label>
                                           <textarea name="description-restaurant" class="form-control" id="description" rows="4">{{ $restaurant->description }}</textarea>
                                           @error('content')
                                           <span class="invalid-feedback" role="alert">
                                               <strong>{{ $message }}</strong>
                                           </span>
                                           @enderror
                                       </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer mt-2 text-end" style="border-radius:0px 0px 15px 15px;">
                        <button button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('modal-scripts')
<script>
    $(document).ready(function() {
        let ItemId = {{ $restaurant->id }};
        $('#tag-input-select2-edit-' + ItemId).select2({
            dropdownParent: $('#restaurant-edit-' + ItemId)
        });
    });
</script>
@endpush