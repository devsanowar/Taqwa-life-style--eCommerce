@extends('admin.layouts.app')
@section('title', 'Add Category')
@section('admin_content')
<div class="page-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="">Add Post Category</h5>
                        <a href="{{ route('admin.post.category.index') }}" class="btn btn-outline-primary px-5 rounded-0">All Category</a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form id="addPostCategoryForm">
                        @csrf

                        <div class="row mb-3">
                            <label for="input35" class="col-sm-3 col-form-label">Category Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="post_category_name" id="input35"
                                    placeholder="Enter Category Name">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="input39" class="col-sm-3 col-form-label">Select Parant Category</label>
                            <div class="col-sm-9">
                                <select class="form-select" id="input39" name="parent_id">
                                    <option value="">None</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->post_category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="input35" class="col-sm-3 col-form-label"> Description </label>
                            <div class="col-sm-9">
                                <textarea type="text" name="description" class="form-control" rows="4"
                                    placeholder="Enter category description"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="input39" class="col-sm-3 col-form-label">Select Status</label>
                            <div class="col-sm-9">
                                <select class="form-select" id="input39" name="status">
                                    <option selected>Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">DeActive</option>
                                </select>
                            </div>
                        </div>


                        <div class="row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-md-9">
                                <div class="d-flex justify-content-end align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-5 rounded-0" id="submitBtn">
                                        <span id="btnText">Submit</span>
                                        <span id="btnSpinner"
                                            class="spinner-border spinner-border-sm d-none ms-2"></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                </div>
                </form>
            </div>
        </div>


    </div>
</div>
<!--end row-->
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $("#addPostCategoryForm").submit(function(e){
            e.preventDefault();
            let formData = $(this).serialize();

            // Spinner show
            $('#btnText').text('Processing...');
            $('#btnSpinner').removeClass('d-none');
            $('#submitBtn').prop('disabled', true);

            $.ajax({
                url: "{{ route('admin.post.category.store') }}",
                type : "POST",
                data : formData,

                success:function(response){
                    $("#addPostCategoryForm")[0].reset();
                    if (response.status === 'success') {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message ?? 'Something went wrong!');
                    }

                    // location.reload();

                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function (key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error('An unexpected error occurred. Please try again.');
                    }
                },
                complete: function () {
                    // Spinner hide & button reset
                    $('#btnText').text('Submit');
                    $('#btnSpinner').addClass('d-none');
                    $('#submitBtn').prop('disabled', false);
                }
            });
        });
    });
</script>
@endpush
