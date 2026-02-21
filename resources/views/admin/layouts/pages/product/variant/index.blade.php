@extends('admin.layouts.app')
@section('title','Product Variants')
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
                        <h5>Product Variants</h5>
                        <a href="{{ route('admin.product.variants.create') }}"
                            class="btn btn-outline-primary px-5 rounded-0">
                            Add Variant
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="variantDataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>SKU</th>
                                    <th>Attributes</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($variants as $k => $v)
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ $v->product->name }}</td>
                                    <td>{{ $v->sku }}</td>
                                    <td>
                                        @foreach($v->values as $val)
                                        <span class="badge bg-secondary">
                                            {{ $val->attribute->name }}:
                                            {{ $val->value }}
                                        </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $v->price_override ?? $v->product->base_price }}
                                    </td>
                                    <td>
                                        @if($v->status)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="action-icon border border-primary text-primary me-2" href="{{ route('admin.product.variants.edit', $v->id) }}"
                                            class="btn btn-sm btn-primary me-1">
                                            <i class="bx bx-edit"></i></a>
                                        <button class="action-icon border border-danger text-danger deleteBtn" data-id="{{ $v->id }}"><i class="bx bx-trash"></i></button>
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
    $('#variantDataTable').DataTable();
});
</script>

<script>
    $(document).on('click','.deleteBtn',function(){
    let id = $(this).data('id');
    Swal.fire({
        title: 'Are you sure?',
        text: "Variant will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result)=>{
        if(result.isConfirmed){
            $.ajax({
                url:'/admin/product/variants/delete/'+id,
                type:'POST',
                data:{_method:'DELETE',_token:'{{ csrf_token() }}'},
                success:function(res){
                    if(res.status=='success'){
                        toastr.success(res.message);
                        location.reload();
                    }else{
                        toastr.error('Something went wrong!');
                    }
                }
            });
        }
    });
});
</script>
@endpush
