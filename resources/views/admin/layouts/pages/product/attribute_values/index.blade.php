@extends('admin.layouts.app')
@section('title', 'All Attribute Values')

@push('styles')
<link href="{{ asset('backend') }}/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
@endpush

@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>All Attribute Values</h5>
                    <a href="{{ route('admin.product.attribute_value.create') }}"
                        class="btn btn-outline-primary px-5 rounded-0">Add Value</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Attribute</th>
                                    <th>Value</th>
                                    <th>Slug</th>
                                    <th>Sort Order</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attributeValues as $key => $val)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $val->attribute->name ?? '-' }}</td>
                                    <td>{{ $val->value }}</td>
                                    <td>{{ $val->slug }}</td>
                                    <td>{{ $val->sort_order }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.product.attribute_value.edit', $val->id) }}"
                                            class="action-icon border border-primary text-primary me-2">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <button type="button"
                                            class="action-icon border border-danger text-danger deleteBtn"
                                            data-id="{{ $val->id }}">
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
            text: "This attribute value will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: '/admin/product/attribute-values/' + id,
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
