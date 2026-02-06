@extends('admin.layouts.app')
@section('title', 'All Categories')
@push('styles')
<link href="{{ asset('backend') }}/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
@endpush

@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>All Categories</h5>
                        <a href="{{ route('admin.product.category.create') }}"
                            class="btn btn-outline-primary px-5 rounded-0">Add Category</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Parent</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key => $cat)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        @if($cat->image)
                                        <img src="{{ asset('storage/'.$cat->image) }}" width="50">
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>{{ $cat->name }}</td>
                                    <td>{{ $cat->parent->name ?? '-' }}</td>
                                    <td class="text-center">
                                        @if($cat->status)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">

                                        <a href="{{ route('admin.product.category.edit',$cat->id) }}"
                                            class="action-icon border border-primary text-primary me-2">
                                            <i class="bx bx-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.product.category.destroy',$cat->id) }}"
                                            method="POST" class="deleteMenuForm" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="action-icon border border-danger text-danger deleteBtn"
                                                data-id="{{ $cat->id }}">
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
    // Initialize DataTable
    var table = $('#example').DataTable();

    $(document).on('click', '.deleteBtn', function() {
        let button = $(this);
        let id = button.data('id');
        let row = button.closest('tr');

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
            if(result.isConfirmed){
                $.ajax({
                    url: '/admin/product/categories/' + id, // change route as per your module
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res){
                        if(res.status === 'success'){
                            toastr.success(res.message);

                            // 🔹 Remove row from DataTable
                            table.row(row).remove().draw(false);

                            // If you need custom numbering:
                            table.rows().every(function(rowIdx, tableLoop, rowLoop){
                                this.cell(rowIdx, 0).data(rowIdx + 1);
                            });
                            table.draw(false);

                        } else {
                            toastr.error('Something went wrong!');
                        }
                    },
                    error:function(){
                        toastr.error('Unexpected error. Please try again.');
                    }
                });
            }
        });
    });
});

</script>

@endpush
