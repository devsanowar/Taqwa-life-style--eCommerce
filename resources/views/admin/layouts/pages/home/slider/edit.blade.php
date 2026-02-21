@extends('admin.layouts.app')
@section('title', 'Edit Slider')

@section('admin_content')
<div class="page-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                {{-- Header --}}
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Edit Slider</h5>
                        <a href="{{ route('admin.home.slider.index') }}"
                           class="btn btn-outline-primary px-5 rounded-0">
                           All Sliders
                        </a>
                    </div>
                </div>

                {{-- Body --}}
                <div class="card-body p-4">
                    <form id="editSliderForm">
                        @csrf
                        @method('PUT')

                        {{-- Title --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Title</label>
                            <div class="col-sm-9">
                                <input type="text"
                                       class="form-control"
                                       name="title"
                                       value="{{ $slider->title }}">
                            </div>
                        </div>

                        {{-- Sub Title --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Sub Title</label>
                            <div class="col-sm-9">
                                <input type="text"
                                       class="form-control"
                                       name="sub_title"
                                       value="{{ $slider->sub_title }}">
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Slider Image</label>
                            <div class="col-sm-9">
                                <input type="file"
                                       class="form-control"
                                       name="image">

                                @if($slider->image)
                                <div class="mt-2">
                                    <img src="{{ asset('uploads/sliders/'.$slider->image) }}"
                                         width="120"
                                         class="border rounded">
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Sort Order --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Sort Order</label>
                            <div class="col-sm-9">
                                <input type="number"
                                       class="form-control"
                                       name="sort_order"
                                       value="{{ $slider->sort_order }}">
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="status">
                                    <option value="1" {{ $slider->status == 1 ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0" {{ $slider->status == 0 ? 'selected' : '' }}>
                                        DeActive
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-md-9">
                                <div class="d-flex justify-content-end align-items-center gap-3">
                                    <button type="submit"
                                            class="btn btn-primary px-5 rounded-0"
                                            id="submitBtn">
                                        <span id="btnText">Update</span>
                                        <span id="btnSpinner"
                                              class="spinner-border spinner-border-sm d-none ms-2">
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

    $("#editSliderForm").submit(function(e){
        e.preventDefault();

        let formData = new FormData(this);

        $('#btnText').text('Updating...');
        $('#btnSpinner').removeClass('d-none');
        $('#submitBtn').prop('disabled', true);

        $.ajax({
            url: "{{ route('admin.home.slider.update',$slider->id) }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function(response){
                if(response.status === 'success'){
                    toastr.success(response.message);
                    setTimeout( () => {
                        window.location.href = response.actionUrl;
                    }, 1500);
                } else {
                    toastr.error(response.message ?? 'Something went wrong!');
                }
            },

            error: function(xhr){
                if(xhr.status === 422){
                    $.each(xhr.responseJSON.errors, function(key, value){
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error('An unexpected error occurred.');
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
