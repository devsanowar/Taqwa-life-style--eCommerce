@extends('admin.layouts.app')
@section('title', 'Add Flash Sale Item')

@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Add Flash Sale Item</h5>
                        <a href="{{ route('admin.flash_sale_items.index') }}"
                           class="btn btn-outline-primary px-5 rounded-0">All Items</a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form id="flashSaleItemForm">
                        @csrf

                        {{-- Flash Sale --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Flash Sale</label>
                            <div class="col-sm-9">
                                <input type="text"
                                    class="form-control bg-light"
                                    value="{{ $flashSale->title }}"
                                    disabled>

                                <input type="hidden" name="flash_sale_id" value="{{ $flashSale->id }}">

                            </div>
                        </div>

                        {{-- Product --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Product</label>
                            <div class="col-sm-9">
                                <select name="product_id" class="form-select">
                                    <option value="">-- Select Product --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->name }} ({{ $product->base_price }}৳)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Variant --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Variant</label>
                            <div class="col-sm-9">
                                <select name="variant_id" class="form-select">
                                    <option value="">-- Select Variant --</option>
                                    @foreach($variants as $variant)
                                        <option value="{{ $variant->id }}">
                                            {{ $variant->product->name }} - {{ $variant->sku }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Either product or variant must be selected</small>
                            </div>
                        </div>

                        {{-- Discount Type --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Discount Type</label>
                            <div class="col-sm-9">
                                <select name="discount_type" class="form-select">
                                    <option value="percent">Percent (%)</option>
                                    <option value="fixed">Fixed (৳)</option>
                                </select>
                            </div>
                        </div>

                        {{-- Discount Value --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Discount Value</label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01" class="form-control" name="discount_value">
                            </div>
                        </div>

                        {{-- Priority --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Priority</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="priority" value="0">
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select name="status" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
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
    $("#flashSaleItemForm").submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $('#btnText').text('Processing...');
        $('#btnSpinner').removeClass('d-none');
        $('#submitBtn').prop('disabled', true);

        $.ajax({
            url: "{{ route('admin.flash_sale_items.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                if (res.status === 'success') {
                    toastr.success(res.message);
                    $("#flashSaleItemForm")[0].reset();
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

