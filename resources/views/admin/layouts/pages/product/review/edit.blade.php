@extends('admin.layouts.app')
@section('title', 'Edit Product Review')
@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Edit Review</h5>
                    <a href="{{ route('admin.product.review.index') }}" class="btn btn-outline-primary px-5 rounded-0">All Reviews</a>
                </div>
                <div class="card-body p-4">
                    <form id="editReviewForm">
                        @csrf
                        @method('PUT')
                        {{-- Product --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Product</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="product_id">
                                    <option value="">-- Select Product --</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ $productReview->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Customer Name --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Customer Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="customer_name" value="{{ $productReview->customer_name }}">
                            </div>
                        </div>

                        {{-- Profession --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Profession</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="profession" value="{{ $productReview->profession }}">
                            </div>
                        </div>

                        {{-- Review --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Review</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="review" rows="4">{{ $productReview->review }}</textarea>
                            </div>
                        </div>

                        {{-- Rating --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Rating (1-5)</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="rating" min="1" max="5" value="{{ $productReview->rating }}">
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="status">
                                    <option value="1" {{ $productReview->status ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$productReview->status ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary">Update</button>
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
    $("#editReviewForm").submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('admin.product.review.update', $productReview->id) }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                toastr.success(response.message);
                setTimeout(() => {
                    window.location.href = response.actionUrl;
                }, 1500);
            },
            error: function(xhr){
                if(xhr.status === 422){
                    $.each(xhr.responseJSON.errors, function(key, value){
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error('Something went wrong!');
                }
            }
        });
    });
});
</script>
@endpush
