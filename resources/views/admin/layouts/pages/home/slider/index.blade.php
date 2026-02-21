@extends('admin.layouts.app')
@section('title', 'All Sliders')

@push('styles')
<link href="{{ asset('backend') }}/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
@endpush

@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                {{-- Header --}}
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>All Sliders</h5>
                        <a href="{{ route('admin.home.slider.create') }}"
                           class="btn btn-outline-primary px-5 rounded-0">
                           Add Slider
                        </a>
                    </div>
                </div>

                {{-- Body --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Sub Title</th>
                                    <th>Sort Order</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sliders as $key => $slider)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    {{-- Image --}}
                                    <td>
                                        <img src="{{ asset('uploads/sliders/'.$slider->image) }}"
                                             alt="slider image"
                                             width="80"
                                             class="border rounded">
                                    </td>

                                    {{-- Title --}}
                                    <td>{{ $slider->title }}</td>

                                    {{-- Sub Title --}}
                                    <td>{{ Str::limit($slider->sub_title, 30, '...') }}</td>

                                    {{-- Sort Order --}}
                                    <td>{{ $slider->sort_order }}</td>

                                    {{-- Status --}}
                                    <td class="text-center">
                                        @if($slider->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>

                                    {{-- Action --}}
                                    <td class="text-center">

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.home.slider.edit',$slider->id) }}"
                                           class="action-icon border border-primary text-primary me-2">
                                            <i class="bx bx-edit"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.home.slider.destroy',$slider->id) }}"
                                              method="POST"
                                              style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    class="action-icon border border-danger text-danger deleteBtn"
                                                    data-id="{{ $slider->id }}">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script src="{{ asset('backend') }}/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('backend') }}/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('backend') }}/assets/js/sweetalert2.js"></script>

<script>
$(document).ready(function() {
    $('#example').DataTable();
});
</script>

<script>
$(document).ready(function() {
    $(document).on('click', '.deleteBtn', function() {
        let button = $(this);
        let form = button.closest('form');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

@endpush
