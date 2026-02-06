@extends('admin.layouts.app')
@section('title', 'All Products')

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
                        <h5>All Products</h5>
                        <a href="{{ route('admin.product.create') }}" class="btn btn-outline-primary px-5 rounded-0">Add
                            Product</a>
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
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $key => $product)
                                <tr>
                                    <td>{{ $key+1 }}</td>

                                    {{-- Primary Image --}}
                                    <td>
                                        @if($product->primaryImage)
                                        <img src="{{ asset($product->primaryImage->path) }}" width="50">
                                        @else
                                        -
                                        @endif
                                    </td>

                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? '-' }}</td>
                                    <td>{{ $product->brand->name ?? '-' }}</td>

                                    <td>৳ {{ number_format($product->base_price,2) }}</td>

                                    <td>
                                        @if($product->discount_type)
                                        {{ $product->discount_value }}
                                        ({{ ucfirst($product->discount_type) }})
                                        @else
                                        -
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if($product->status)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="text-center">

                                        <a href="{{ route('admin.product.edit',$product->id) }}"
                                            class="action-icon border border-primary text-primary me-2">
                                            <i class="bx bx-edit"></i>
                                        </a>

                                        <button type="button"
                                            class="action-icon border border-danger text-danger deleteBtn"
                                            data-id="{{ $product->id }}">
                                            <i class="bx bx-trash"></i>
                                        </button>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Laravel pagination (optional if not using DataTable paging) --}}
                        <div class="mt-3">
                            {{ $products->links() }}
                        </div>

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
            text: "This product will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: '/admin/product/delete/' + id,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res){
                        if(res.status === 'success'){
                            toastr.success(res.message);

                            // Remove row
                            table.row(row).remove().draw(false);

                            // Re-number S/N
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
