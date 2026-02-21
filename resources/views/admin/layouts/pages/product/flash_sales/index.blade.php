@extends('admin.layouts.app')
@section('title', 'Flash Sales')

@push('styles')
<link href="{{ asset('backend') }}/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
@endpush

@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between">
                    <h5>Flash Sales</h5>
                    <a href="{{ route('admin.flash_sales.create') }}" class="btn btn-outline-primary px-5 rounded-0">Add
                        Flash
                        Sale</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered" id="flashTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Status</th>
                                <th>Items</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $k => $sale)
                            <tr>
                                <td>{{ $k + 1 }}</td>
                                <td>{{ $sale->title }}</td>
                                <td>{{ $sale->start_at }}</td>
                                <td>{{ $sale->end_at }}</td>
                                <td><span class="badge bg-info">{{ $sale->status }}</span></td>
                                <td>{{ $sale->items_count }}</td>
                                <td>
                                    <a class="action-icon border border-primary text-primary me-2" href="{{ route('admin.flash_sales.edit', $sale->id) }}"
                                            class="btn btn-sm btn-primary me-1">
                                            <i class="bx bx-edit"></i></a>
                                    <button class="action-icon border border-danger text-danger deleteBtn"
                                        data-id="{{ $sale->id }}">
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
@endsection

@push('scripts')
<script src="{{ asset('backend') }}/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('backend') }}/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('backend') }}/assets/js/sweetalert2.js"></script>

<script>
    $('#flashTable').DataTable();

        $(document).on('click', '.deleteBtn', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'Flash sale will be deleted!',
                icon: 'warning',
                showCancelButton: true
            }).then((res) => {
                if (res.isConfirmed) {
                    $.post('/admin/flash-sales/delete/' + id, {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    }, function(r) {
                        if (r.status == 'success') {
                            toastr.success(r.message);
                            location.reload();
                        }
                    });
                }
            });
        });
</script>
@endpush
