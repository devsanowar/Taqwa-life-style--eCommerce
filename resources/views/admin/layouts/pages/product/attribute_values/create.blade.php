@extends('admin.layouts.app')
@section('title', 'Add Attribute Value')

@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Add Attribute Value</h5>
                    <a href="{{ route('admin.product.attribute_value.index') }}" class="btn btn-outline-primary px-5 rounded-0">All Values</a>
                </div>

                <div class="card-body p-4">
                    <form id="addAttributeValueForm">
                        @csrf

                        {{-- Attribute --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Attribute</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="attribute_id" required>
                                    <option value="">-- Select Attribute --</option>
                                    @foreach($attributes as $attr)
                                        <option value="{{ $attr->id }}">{{ $attr->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Value --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Value</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="value" required>
                            </div>
                        </div>

                        {{-- Sort Order --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Sort Order</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="sort_order" value="0">
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
    $("#addAttributeValueForm").submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $('#btnText').text('Processing...');
        $('#btnSpinner').removeClass('d-none');
        $('#submitBtn').prop('disabled', true);

        $.ajax({
            url: "{{ route('admin.product.attribute_value.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                if(res.status === 'success'){
                    toastr.success(res.message);
                    $("#addAttributeValueForm")[0].reset();
                } else {
                    toastr.error(res.message);
                }
            },
            error: function(xhr){
                if(xhr.status === 422){
                    $.each(xhr.responseJSON.errors,function(k,v){
                        toastr.error(v[0]);
                    });
                }
            },
            complete: function(){
                $('#btnText').text('Submit');
                $('#btnSpinner').addClass('d-none');
                $('#submitBtn').prop('disabled', false);
            }
        });
    });
});
</script>
@endpush
