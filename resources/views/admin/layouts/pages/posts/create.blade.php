@extends('admin.layouts.app')
@section('title', 'Add Post')
@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush
@section('admin_content')
<div class="page-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="">Add Post</h5>
                        <a href="{{ route('admin.post.index') }}" class="btn btn-outline-primary px-5 rounded-0">All
                            Post</a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form id="addPostForm">
                        @csrf

                        {{-- Post Title --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Post Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="title" placeholder="Enter Post Title">
                            </div>
                        </div>

                        {{-- Category --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Select Category</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="category_id">
                                    <option value="">-- Select --</option>
                                    @foreach($categories->where('parent_id', null) as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->post_category_name }}</option>
                                    @foreach($categories->where('parent_id', $parent->id) as $child)
                                    <option value="{{ $child->id }}">-- {{ $child->post_category_name }}</option>
                                    @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Excerpt --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Excerpt</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="excerpt" rows="2"
                                    placeholder="Short summary"></textarea>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Content</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="editor" name="description"
                                    placeholder="Write full description">{{ old('description', $post->description ?? '') }}</textarea>
                            </div>
                        </div>

                        {{-- Thumbnail --}}
                        <div class="row mb-3" style="margin-top:60px">
                            <label class="col-sm-3 col-form-label">Thumbnail</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="thumbnail">

                                @if(!empty($post->thumbnail))
                                <img src="{{ asset('uploads/post_images/'.$post->thumbnail) }}" alt="Thumbnail"
                                    class="mt-2 border rounded" width="120">
                                @endif
                            </div>
                        </div>


                        {{-- Status --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">DeActive</option>
                                </select>
                            </div>
                        </div>

                        {{-- --- SEO Fields --- --}}
                        <h6 class="mb-3 mt-4 text-uppercase">SEO Meta Information</h6>

                        {{-- Meta Title --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Meta Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="meta_title" placeholder="SEO title">
                            </div>
                        </div>

                        {{-- Meta Keywords --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Meta Keywords</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="meta_keywords"
                                    placeholder="keyword1, keyword2">
                            </div>
                        </div>

                        {{-- Meta Description --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Meta Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="meta_description" rows="3"
                                    placeholder="SEO description"></textarea>
                            </div>
                        </div>

                        {{-- Submit Button --}}
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

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var quill = new Quill('#editor', {
		  theme: 'snow'
		});
</script>
<script>
    $(document).ready(function(){
    $("#addPostForm").submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);

        // Spinner show
        $('#btnText').text('Processing...');
        $('#btnSpinner').removeClass('d-none');
        $('#submitBtn').prop('disabled', true);

        $.ajax({
            url: "{{ route('admin.post.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                $("#addPostForm")[0].reset();
                if(response.status === 'success'){
                    toastr.success(response.message);
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
                    toastr.error('An unexpected error occurred. Please try again.');
                }
            },
            complete: function(){
                // Spinner hide
                $('#btnText').text('Submit');
                $('#btnSpinner').addClass('d-none');
                $('#submitBtn').prop('disabled', false);
            }
        });
    });
});

</script>
@endpush
