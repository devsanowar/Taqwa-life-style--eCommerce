@extends('admin.layouts.app')
@section('title', 'Add Product')

@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Add Product</h5>
                        <a href="{{ route('admin.product.index') }}" class="btn btn-outline-primary px-5 rounded-0">All
                            Products</a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form id="addProductForm" enctype="multipart/form-data">
                        @csrf

                        {{-- Category --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Category</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="category_id" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Brand --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Brand</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="brand_id">
                                    <option value="">-- No Brand --</option>
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Name --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Product Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>

                        {{-- Base Price --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Base Price</label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01" class="form-control" name="base_price" required>
                            </div>
                        </div>

                        {{-- Discount --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Discount</label>
                            <div class="col-sm-4">
                                <select class="form-select" name="discount_type">
                                    <option value="">-- None --</option>
                                    <option value="percent">Percent</option>
                                    <option value="fixed">Fixed</option>
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <input type="number" step="0.01" class="form-control" name="discount_value"
                                    placeholder="Discount Value">
                            </div>
                        </div>

                        {{-- Short Description --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Short Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="short_description"></textarea>
                            </div>
                        </div>

                        {{-- Long Description --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Long Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="long_description" rows="4"></textarea>
                            </div>
                        </div>

                        {{-- Flags --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Options</label>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="featured" value="1">
                                    <label class="form-check-label">Featured</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="flash_sale_enabled" value="1">
                                    <label class="form-check-label">Flash Sale</label>
                                </div>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>

                        {{-- Images --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Product Images</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="images[]" multiple>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-md-9 text-end">
                                <button type="submit" class="btn btn-primary px-5 rounded-0" id="submitBtn">
                                    <span id="btnText">Submit</span>
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

<script>
    $(document).ready(function() {
    $("#addProductForm").submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $('#btnText').text('Processing...');
        $('#btnSpinner').removeClass('d-none');
        $('#submitBtn').prop('disabled', true);

        $.ajax({
            url: "{{ route('admin.product.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                if (res.status === 'success') {
                    toastr.success(res.message);
                    $("#addProductForm")[0].reset();
                } else {
                    toastr.error('Something went wrong');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function(k, v) {
                        toastr.error(v[0]);
                    });
                }
            },
            complete: function() {
                $('#btnText').text('Submit');
                $('#btnSpinner').addClass('d-none');
                $('#submitBtn').prop('disabled', false);
            }
        });
    });
});
</script>


@endpush
