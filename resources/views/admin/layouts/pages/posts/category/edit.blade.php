@extends('admin.layouts.app')
@section('title', 'Edit Category')
@section('admin_content')
<div class="page-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="">Edit Post Category</h5>
                        <a href="{{ route('admin.post.category.index') }}" class="btn btn-outline-primary px-5 rounded-0">All Category</a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.post.category.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" value="{{ $category->id }}">

                        <div class="row mb-3">
                            <label for="input35" class="col-sm-3 col-form-label">Category Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="post_category_name" id="input35"
                                    value="{{ $category->post_category_name ?? '' }}" placeholder="Enter Category Name">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="input39" class="col-sm-3 col-form-label">Select Parent Category</label>
                            <div class="col-sm-9">
                                <select class="form-select" id="input39" name="parent_id">
                                    <option value="">None</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : ''
                                        }}>
                                        {{ $cat->post_category_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="input35" class="col-sm-3 col-form-label"> Description </label>
                            <div class="col-sm-9">
                                <textarea type="text" name="description" class="form-control" rows="4"
                                    placeholder="Enter category description">{!! $category->description !!}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="status" class="col-sm-3 col-form-label">Select Status</label>
                            <div class="col-sm-9">
                                <select class="form-select" id="status" name="status" required>
                                    <option value="" disabled {{ is_null($category->status) ? 'selected' : '' }}>--
                                        Select Status --</option>
                                    <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>DeActive</option>
                                </select>
                            </div>
                        </div>



                        <div class="row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-md-9">
                                <div class="d-flex justify-content-end align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-5 rounded-0" id="submitBtn">
                                        <span id="btnText"> Update</span>
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
