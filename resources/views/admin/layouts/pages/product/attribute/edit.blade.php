@extends('admin.layouts.app')
@section('title', 'Edit Attribute')

@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Edit Attribute</h5>
                    <a href="{{ route('admin.product.attribute.index') }}"
                        class="btn btn-outline-primary px-5 rounded-0">All Attributes</a>
                </div>

                <div class="card-body p-4">
                    <form id="editAttributeForm">
                        @csrf
                        @method('PUT')

                        {{-- Name --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Attribute Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" value="{{ $attribute->name }}"
                                    required>
                            </div>
                        </div>

                        {{-- Code --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Attribute Code</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="code" value="{{ $attribute->code }}"
                                    required>
                            </div>
                        </div>

                        {{-- Type --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Type</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="type" required>
                                    <option value="select" {{ $attribute->type=='select' ? 'selected' : '' }}>Select
                                    </option>
                                    <option value="text" {{ $attribute->type=='text' ? 'selected' : '' }}>Text</option>
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
<script>
    $(document).ready(function() {
    $("#editAttributeForm").submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $('#btnText').text('Processing...');
        $('#btnSpinner').removeClass('d-none');
        $('#submitBtn').prop('disabled', true);

        $.ajax({
            url: "{{ route('admin.product.attribute.update', $attribute->id) }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                if (res.status === 'success') {
                    toastr.success(res.message);
                    setTimeout(() => {
                        window.location.href = "{{ route('admin.product.attribute.index') }}";
                    }, 1000);
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
                $('#btnText').text('Update');
                $('#btnSpinner').addClass('d-none');
                $('#submitBtn').prop('disabled', false);
            }
        });
    });
});
</script>
@endpush