@extends('admin.layouts.app')
@section('title', 'Edit Product')
@push('styles')
<style>
    .remove-image {
        position: absolute;
        top: -6px;
        right: -6px;
        background: red;
        color: #fff;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        text-align: center;
        line-height: 20px;
        font-size: 14px;
        cursor: pointer;
        z-index: 999;
    }
</style>
@endpush
@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Edit Product</h5>
                        <a href="{{ route('admin.product.index') }}" class="btn btn-outline-primary px-5 rounded-0">All
                            Products</a>
                    </div>
                </div>

                <div class="card-body p-4">

                    <form id="editProductForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="product_id" value="{{ $product->id }}">

                        {{-- Category --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Category</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="category_id">
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' :
                                        '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Brand --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Brand</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="brand_id">
                                    <option value="">-- None --</option>
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' :
                                        '' }}>
                                        {{ $brand->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Name --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Product Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" value="{{ $product->name }}">
                            </div>
                        </div>

                        {{-- Price --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Base Price</label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01" class="form-control" name="base_price"
                                    value="{{ $product->base_price }}">
                            </div>
                        </div>

                        {{-- Discount --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Discount</label>
                            <div class="col-sm-4">
                                <select class="form-select" name="discount_type">
                                    <option value="">None</option>
                                    <option value="percent" {{ $product->discount_type=='percent'?'selected':''
                                        }}>Percent</option>
                                    <option value="fixed" {{ $product->discount_type=='fixed'?'selected':'' }}>Fixed
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <input type="number" class="form-control" name="discount_value"
                                    value="{{ $product->discount_value }}">
                            </div>
                        </div>

                        {{-- Short Description --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Short Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control"
                                    name="short_description">{{ $product->short_description }}</textarea>
                            </div>
                        </div>

                        {{-- Long Description --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Long Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control"
                                    name="long_description">{{ $product->long_description }}</textarea>
                            </div>
                        </div>

                        {{-- Images --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Replace Images</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="images[]" multiple>
                                <small class="text-muted">Upload new images to replace old ones.</small>
                            </div>
                        </div>

                        {{-- Existing Images --}}
@if($product->images->count())
<div class="row mb-3">
    <label class="col-sm-3 col-form-label">Current Images</label>
    <div class="col-sm-9 d-flex flex-wrap gap-2" id="existingImages">
        @foreach($product->images as $img)
        <div class="img-wrap position-relative" data-id="{{ $img->id }}">
            <img src="{{ asset($img->path) }}" width="80" class="border">
            <span class="remove-image" data-id="{{ $img->id }}">×</span>
            <div class="form-check mt-1 text-center">
                <input type="radio" name="primary_image" value="{{ $img->id }}" class="form-check-input"
                    {{ $img->is_primary ? 'checked' : '' }}>
                <label class="form-check-label">Primary</label>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- New Images Upload --}}
<div class="row mb-3">
    <label class="col-sm-3 col-form-label">Add Images</label>
    <div class="col-sm-9">
        <input type="file" class="form-control" name="images[]" multiple>
        <small class="text-muted">Upload new images without removing old ones.</small>
    </div>
</div>

<input type="hidden" name="removed_images" id="removed_images">




                        {{-- Flags --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Options</label>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="featured" value="1" {{
                                        $product->featured ? 'checked' : '' }}>
                                    <label class="form-check-label">Featured</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="flash_sale_enabled" value="1"
                                        {{ $product->flash_sale_enabled ? 'checked' : '' }}>
                                    <label class="form-check-label">Flash Sale</label>
                                </div>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="status">
                                    <option value="1" {{ $product->status==1?'selected':'' }}>Active</option>
                                    <option value="0" {{ $product->status==0?'selected':'' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-md-9 text-end">
                                <button type="submit" class="btn btn-primary px-5 rounded-0" id="submitBtn">
                                    <span id="btnText">Update</span>
                                    <span id="btnSpinner" class="spinner-border spinner-border-sm d-none ms-2"></span>
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script src="{{ asset('backend') }}/assets/js/sweetalert2.js"></script>


<script>
$(document).ready(function() {

    let removedImages = [];

    // Remove existing image (frontend only)
    $(document).on('click', '.remove-image', function() {
        let wrapper = $(this).closest('.img-wrap');
        let imageId = $(this).data('id');

        Swal.fire({
            title: 'Remove this image?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }).then((result) => {
            if(result.isConfirmed){
                removedImages.push(imageId); // Add to removed array
                $('#removed_images').val(removedImages.join(',')); // Set hidden input
                wrapper.fadeOut(300, function(){ $(this).remove(); });
            }
        });
    });

    // Ajax form submit
    $('#editProductForm').submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);

        $('#btnText').text('Processing...');
        $('#btnSpinner').removeClass('d-none');
        $('#submitBtn').prop('disabled', true);

        $.ajax({
            url: '/admin/product/update/' + $('#product_id').val(),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
                if(res.status === 'success'){
                    toastr.success(res.message);
                    setTimeout(() =>{
                        window.location.href = "{{ route('admin.product.index') }}";
                    }, 1500);
                } else {
                    toastr.error('Something went wrong');
                }
            },
            error: function(xhr){
                if(xhr.status === 422){
                    $.each(xhr.responseJSON.errors, function(k,v){
                        toastr.error(v[0]);
                    });
                }
            },
            complete: function(){
                $('#btnText').text('Update');
                $('#btnSpinner').addClass('d-none');
                $('#submitBtn').prop('disabled', false);
            }
        });
    });

});
</script>

@endpush
