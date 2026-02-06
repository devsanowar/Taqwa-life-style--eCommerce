@extends('admin.layouts.app')
@section('title', 'Add Product Variant')

@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Add Variant</h5>
                        <a href="{{ route('admin.product.index') }}" class="btn btn-outline-primary px-5 rounded-0">All
                            Products</a>
                        <a href="{{ route('admin.product.variants.index') }}" class="btn btn-outline-primary px-5 rounded-0">All
                            Variants</a>
                    </div>
                </div>

                <div class="card-body p-4">

                    <form id="addVariantForm">
                        @csrf

                        {{-- Product --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Product</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="product_id" required>
                                    <option value="">-- Select Product --</option>
                                    @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- SKU --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">SKU</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="sku" required>
                            </div>
                        </div>

                        {{-- Price Override --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Price Override</label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01" class="form-control" name="price_override">
                                <small class="text-muted">Leave empty to use product base price</small>
                            </div>
                        </div>

                        {{-- Attributes --}}
                        @foreach($attributes as $attr)
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">{{ $attr->name }}</label>
                            <div class="col-sm-9 d-flex flex-wrap gap-2">

                                @foreach($attr->values as $val)
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="checkbox" name="attributes[{{ $attr->id }}][]"
                                        value="{{ $val->id }}">
                                    <label class="form-check-label">
                                        {{ $val->value }}
                                    </label>
                                </div>
                                @endforeach

                            </div>
                        </div>
                        @endforeach

                        {{-- Variant Image --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Variant Image</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="image">
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

                        {{-- Submit --}}
                        <div class="row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-md-9 text-end">
                                <button type="submit" class="btn btn-primary px-5 rounded-0" id="submitBtn">
                                    <span id="btnText">Create Variant</span>
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
    $(document).on('submit','#addVariantForm',function(e){
    e.preventDefault();
    let formData = new FormData(this);

    $('#btnText').text('Processing...');
    $('#btnSpinner').removeClass('d-none');
    $('#submitBtn').prop('disabled', true);

    $.ajax({
        url: "{{ route('admin.product.variants.store') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(res){
            if(res.status === 'success'){
                toastr.success(res.message);
                $('#addVariantForm')[0].reset();
            }
        },
        error:function(xhr){
            $.each(xhr.responseJSON.errors,function(k,v){
                toastr.error(v[0]);
            });
        },
        complete:function(){
            $('#btnText').text('Create Variant');
            $('#btnSpinner').addClass('d-none');
            $('#submitBtn').prop('disabled', false);
        }
    });
});


</script>
@endpush
