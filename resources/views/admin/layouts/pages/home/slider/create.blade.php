@extends('admin.layouts.app')
@section('title', 'Add Slider')

@section('admin_content')
<div class="page-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Add Slider</h5>
                        <a href="{{ route('admin.home.slider.index') }}" class="btn btn-outline-primary px-5 rounded-0">
                            All Sliders
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form id="addSliderForm">
                        @csrf

                        {{-- Title --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="title">
                                <div class="text-danger small" id="error-title"></div>
                            </div>
                        </div>

                        {{-- Sub Title --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Sub Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="sub_title">
                                <div class="text-danger small" id="error-sub_title"></div>
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Slider Image</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="image">
                                <div class="text-danger small" id="error-image"></div>
                            </div>
                        </div>

                        {{-- Sort Order --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Sort Order</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="sort_order">
                                <div class="text-danger small" id="error-sort_order"></div>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="status">
                                    <option value="">Select</option>
                                    <option value="1">Active</option>
                                    <option value="0">DeActive</option>
                                </select>
                                <div class="text-danger small" id="error-status"></div>
                            </div>
                        </div>


                        {{-- Submit Button --}}
                        <div class="row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-md-9">
                                <div class="d-flex justify-content-end align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-5 rounded-0" id="submitBtn">
                                        <span id="btnText">Submit</span>
                                        <span id="btnSpinner" class="spinner-border spinner-border-sm d-none ms-2">
                                        </span>
                                    </button>
                                </div>
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
    $(document).ready(function(){
    $("#addSliderForm").submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);

        $('#btnText').text('Processing...');
        $('#btnSpinner').removeClass('d-none');
        $('#submitBtn').prop('disabled', true);

        $.ajax({
            url: "{{ route('admin.home.slider.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                $("#addSliderForm")[0].reset();
                if(response.status === 'success'){
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message ?? 'Something went wrong!');
                }
            },
            error: function(xhr){

                if(xhr.status === 422){

                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function(key, value){

                        $('#error-' + key).text(value[0]);
                        $('[name="'+key+'"]').addClass('is-invalid');

                    });

                } else {
                    toastr.error('Something went wrong.');
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