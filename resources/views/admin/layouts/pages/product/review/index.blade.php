@extends('admin.layouts.app')
@section('title', 'All Product Reviews')
@push('styles')
<link href="{{ asset('backend') }}/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
@endpush
@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>All Product Reviews</h5>
                    <a href="{{ route('admin.product.review.create') }}" class="btn btn-outline-primary px-5 rounded-0">Add Review</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Product</th>
                                    <th>Customer Name</th>
                                    <th>Profession</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $key => $review)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $review->product->name ?? '-' }}</td>
                                    <td>{{ $review->customer_name }}</td>
                                    <td>{{ $review->profession ?? '-' }}</td>
                                    <td>{{ $review->rating ?? '-' }}</td>
                                    <td>
                                        @if($review->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.product.review.edit',$review->id) }}" class="action-icon border border-primary text-primary me-2">
                                            <i class="bx bx-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.product.review.destroy',$review->id) }}" method="POST" class="deleteForm" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="action-icon border border-danger text-danger deleteBtn">
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

    $(document).on('click', '.deleteBtn', function() {
        let form = $(this).closest('form');
        Swal.fire({
            title: 'Are you sure?',
            text: "This review will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if(result.isConfirmed){
                form.submit();
            }
        });
    });
});
</script>
@endpush
