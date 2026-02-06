@extends('admin.layouts.app')
@section('title', 'All Attributes')

@push('styles')
<link href="{{ asset('backend') }}/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
@endpush

@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>All Attributes</h5>
                    <a href="{{ route('admin.product.attribute.create') }}" class="btn btn-outline-primary px-5 rounded-0">Add Attribute</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attributes as $key => $attr)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $attr->name }}</td>
                                    <td>{{ $attr->code }}</td>
                                    <td>{{ ucfirst($attr->type) }}</td>
                                    <td>{{ $attr->created_at->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.product.attribute.edit', $attr->id) }}" class="action-icon border border-primary text-primary me-2">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <button type="button" class="action-icon border border-danger text-danger deleteBtn" data-id="{{ $attr->id }}">
                                            <i class="bx bx-trash"></i>
                                        </button>
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
    var table = $('#example').DataTable();

    $(document).on('click', '.deleteBtn', function() {
        let button = $(this);
        let id = button.data('id');
        let row = button.closest('tr');

        Swal.fire({
            title: 'Are you sure?',
            text: "This attribute will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: '/admin/product/attributes/' + id,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res){
                        if(res.status === 'success'){
                            toastr.success(res.message);
                            table.row(row).remove().draw(false);
                            table.rows().every(function(rowIdx){
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
