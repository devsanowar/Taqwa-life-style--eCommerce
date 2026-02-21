@extends('admin.layouts.app')
@section('title', 'Edit Product Variant')

@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Edit Variant</h5>
                        <a href="{{ route('admin.product.variants.index') }}"
                            class="btn btn-outline-primary px-5 rounded-0">All Variants</a>
                    </div>
                </div>

                <div class="card-body p-4">

                    <form id="editVariantForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="variant_id" value="{{ $variant->id }}">

                        {{-- Product --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Product</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="product_id" required disabled>
                                    @foreach($products as $p)
                                    <option value="{{ $p->id }}" {{ $variant->product_id==$p->id?'selected':'' }}>{{
                                        $p->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Product cannot be changed</small>
                            </div>
                        </div>

                        {{-- SKU --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">SKU</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="sku" value="{{ $variant->sku }}" required>
                            </div>
                        </div>

                        {{-- Base Price Override --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Base Price Override</label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01" class="form-control" name="price_override"
                                    value="{{ $variant->price_override }}">
                                <small class="text-muted">Leave empty to use product base price</small>
                            </div>
                        </div>

                        {{-- Attributes --}}
                        @foreach($attributes as $attr)
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">{{ $attr->name }}</label>
                            <div class="col-sm-9">
                                @foreach($attr->values as $val)
                                @php
                                    $checked = array_key_exists($val->id, $prices);
                                $price = $prices[$val->id] ?? 0;
                                $colorImage = $colorImages[$val->id] ?? null;



                                @endphp

                                <div class="d-flex align-items-center mb-2 border p-2 rounded">

                                    <div class="form-check me-3">
                                        <input class="form-check-input attrCheck" type="checkbox"
                                            data-value="{{ $val->id }}" {{ $checked ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $val->value }}</label>
                                    </div>

                                    {{-- Color Image --}}
                                    @if($attr->code == 'color')
                                    @if($colorImage)
                                    <img src="{{ asset($colorImage) }}" width="50" class="me-2 border">
                                    @endif
                                    <input type="file" class="form-control w-50" name="color_images[{{ $val->id }}]">
                                    @endif

                                    {{-- Price Input --}}
                                    @if($attr->code != 'color')
                                    <input type="hidden" name="prices[{{ $val->id }}]" value="{{ $price }}">
                                    <input type="number" step="0.01"
                                        class="form-control w-25 priceInput {{ $checked ? '' : 'd-none' }}"
                                        data-hidden="prices[{{ $val->id }}]" value="{{ $price }}"
                                        placeholder="Extra Price">
                                    @endif

                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach

                        {{-- Status --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="status">
                                    <option value="1" {{ $variant->status? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$variant->status? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-md-9 text-end">
                                <button type="submit" class="btn btn-primary px-5 rounded-0" id="submitBtn">
                                    <span id="btnText">Update Variant</span>
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
    $(document).on('change','.attrCheck',function(){
    let row = $(this).closest('.d-flex');
    let visible = row.find('.priceInput');
    let hiddenName = visible.data('hidden');
    let hidden = row.find('input[name="'+hiddenName+'"]');

    if(this.checked){
        if(visible.length) visible.removeClass('d-none');
        if(hidden.length && !hidden.val()) hidden.val(0);
    } else {
        if(visible.length) visible.addClass('d-none').val('');
        if(hidden.length) hidden.val('');
    }
});

$(document).on('input','.priceInput',function(){
    let hiddenName = $(this).data('hidden');
    $('input[name="'+hiddenName+'"]').val($(this).val());
});


$(document).ready(function(){
    $('.attrCheck:checked').each(function(){
        let row = $(this).closest('.d-flex');
        let visible = row.find('.priceInput');
        let hiddenName = visible.data('hidden');
        let hidden = row.find('input[name="'+hiddenName+'"]');

        if(visible.length){
            visible.removeClass('d-none');
            if(hidden.length) hidden.val(visible.val());
        }
    });
});


$(document).on('submit','#editVariantForm',function(e){
    e.preventDefault();
    let formData = new FormData(this);

    $('#btnText').text('Processing...');
    $('#btnSpinner').removeClass('d-none');
    $('#submitBtn').prop('disabled', true);

    $.ajax({
        url: "{{ route('admin.product.variants.update', $variant->id) }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(res){
            if(res.status === 'success'){
                toastr.success(res.message);
                setTimeout(function(){
                    window.location.href = "{{ route('admin.product.variants.index') }}";
                }, 1000);
            }
        },
        error:function(xhr){
            $.each(xhr.responseJSON.errors,function(k,v){
                toastr.error(v[0]);
            });
        },
        complete:function(){
            $('#btnText').text('Update Variant');
            $('#btnSpinner').addClass('d-none');
            $('#submitBtn').prop('disabled', false);
        }
    });
});
</script>
@endpush
