@extends('admin.layouts.app')
@section('title', 'Edit Category')

@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Edit Category</h5>
                        <a href="{{ route('admin.product.category.index') }}"
                            class="btn btn-outline-primary px-5 rounded-0">All Categories</a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form id="editCategoryForm" enctype="multipart/form-data" data-id="{{ $category->id }}">
                        @csrf
                        @method('PUT')

                        {{-- Name --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Category Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $category->name) }}">
                            </div>
                        </div>

                        {{-- Parent --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Parent Category</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="parent_id">
                                    <option value="">-- No Parent --</option>
                                    @foreach($categories->where('parent_id', null) as $parent)
                                    <option value="{{ $parent->id }}" {{ ($category->
                                        parent_id==$parent->id)?'selected':'' }}>{{ $parent->name }}</option>
                                    @foreach($categories->where('parent_id', $parent->id) as $child)
                                    <option value="{{ $child->id }}" {{ ($category->parent_id==$child->id)?'selected':''
                                        }}>-- {{ $child->name }}
                                    </option>
                                    @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Image</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="image">
                                @if(!empty($category->image))
                                <img src="{{ asset($category->image) }}" class="mt-2 border rounded"
                                    width="120">
                                @endif
                            </div>
                        </div>

                        {{-- Sort Order --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Sort Order</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="sort_order"
                                    value="{{ old('sort_order', $category->sort_order) }}">
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="status">
                                    <option value="1" {{ $category->status ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$category->status ? 'selected' : '' }}>Inactive</option>
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
    $(document).ready(function(){
    $("#editCategoryForm").submit(function(e){
        e.preventDefault();

        let id = $(this).data('id');
        let formData = new FormData(this);
        formData.append('_method','PUT');

        $('#btnText').text('Processing...');
        $('#btnSpinner').removeClass('d-none');
        $('#submitBtn').prop('disabled',true);

        $.ajax({
            url: "/admin/product/categories/"+id,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
                if(res.status==='success'){
                    toastr.success(res.message);

                    setTimeout(function(){
                        window.location.href =  res.actionUrl;
                    },1000);

                } else {
                    toastr.error('Something went wrong');
                }
            },
            error:function(xhr){
                if(xhr.status===422){
                    $.each(xhr.responseJSON.errors,function(k,v){
                        toastr.error(v[0]);
                    });
                } else {
                    toastr.error('Unexpected error. Please try again.');
                }
            },
            complete:function(){
                $('#btnText').text('Update');
                $('#btnSpinner').addClass('d-none');
                $('#submitBtn').prop('disabled',false);
            }
        });
    });
});
</script>
@endpush
