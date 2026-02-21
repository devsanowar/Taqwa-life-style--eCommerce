@extends('admin.layouts.app')
@section('title', 'Flash Sale Items')

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
                        <h5>Flash Sale</h5>
                        <a href="{{ route('admin.flash_sale_items.create') }}"
                            class="btn btn-outline-primary px-5 rounded-0">Add Item</a>
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
                                    <th>Variant</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($items as $key => $item)
                                @php
                                $product = $item->product;
                                $variant = $item->variant;
                                @endphp
                                <tr>
                                    <td>{{ $key+1 }}</td>

                                    <td>

                                        @if($item->product && $item->product->primaryImage)
                                            <img src="{{ asset($item->product->primaryImage->path) }}"
                                                width="50" height="50"
                                                style="object-fit:cover;border-radius:4px;">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>

                                    <td>{{ $product->name ?? '-' }}</td>

                                    <td>
                                        @if($variant)
                                        <span class="badge bg-info">{{ $variant->sku }}</span>
                                        @else -
                                        @endif
                                    </td>

                                    <td>{{ $product->category->name ?? '-' }}</td>
                                    <td>{{ $product->brand->name ?? '-' }}</td>

                                    <td>
                                        ৳ {{ number_format($variant->price_override ?? $product->base_price ?? 0,2) }}
                                    </td>

                                    <td>
                                        {{ $item->discount_value }}
                                        ({{ ucfirst($item->discount_type) }})
                                    </td>

                                    <td>{{ $item->priority }}</td>

                                    <td>
                                        @if(now()->between($flash->start_at, $flash->end_at))
                                        <span class="badge bg-success">Live</span>
                                        @else
                                        <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <button type="button"
                                            class="action-icon border border-danger text-danger deleteBtn"
                                            data-id="{{ $item->id }}">
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
            text: "This flash sale item will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if(result.isConfirmed){

                let url = "{{ route('admin.flash_sale_items.delete', ':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function(res){
                        if(res.status === 'deleted'){
                            table.row(row).remove().draw(false);
                            toastr.success('Item deleted');
                        }
                    }
                });
            }
        });
    });
});
</script>
@endpush
