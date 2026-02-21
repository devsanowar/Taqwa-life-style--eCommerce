@extends('admin.layouts.app')
@section('title', 'Create Flash Sale')

@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Add Flash Sale</h5>
                    <a href="{{ route('admin.flash_sales.index') }}" class="btn btn-outline-primary px-5 rounded-0">All Flash Sales</a>
                </div>

                <div class="card-body p-4">
                    <form id="flashForm">
                        @csrf

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Title</label>
                            <div class="col-sm-9">
                                <input type="text" name="title" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Start At</label>
                            <div class="col-sm-9">
                                <input type="datetime-local" name="start_at" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">End At</label>
                            <div class="col-sm-9">
                                <input type="datetime-local" name="end_at" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Auto Start</label>
                            <div class="col-sm-9">
                                <select name="auto_start" class="form-select">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Auto Expire</label>
                            <div class="col-sm-9">
                                <select name="auto_expire" class="form-select">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary px-5">Create</button>
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
    $('#flashForm').submit(function(e) {
            e.preventDefault();
            $.post("{{ route('admin.flash_sales.store') }}", $(this).serialize(), function(res) {
                toastr.success(res.message);
                window.location = "{{ route('admin.flash_sales.index') }}";
            });
        });
</script>
@endpush
