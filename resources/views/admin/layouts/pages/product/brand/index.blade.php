@extends('admin.layouts.app')
@section('title', 'Brands')
@push('styles')
<link href="{{ asset('backend/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush

@section('admin_content')
<div class="page-content">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Brands</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#brandModal">Add Brand</button>
        </div>

        <div class="card-body">
            <div id="brandTable">
                @include('admin.layouts.pages.product.brand.partials.brands_table')
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="brandModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Brand</h5>
            </div>
            <div class="modal-body">
                <form id="brandForm" method="POST" action="javascript:void(0);">
                    @csrf
                    <input type="hidden" id="brand_id">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <button class="btn btn-primary w-100">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script src="{{ asset('backend') }}/assets/js/sweetalert2.js"></script>
<script>
    $(document).on('submit', '#brandForm', function(e){
    e.preventDefault();

    let id = $('#brand_id').val();
    let url = id
        ? '/admin/product/brands/update/' + id
        : '/admin/product/brands/store';

    $.ajax({
        url: url,
        type: 'POST',
        data: $(this).serialize(),
        success: function(res){
        toastr.success(res.message);
        $('#brandModal').modal('hide');

        let brand = res.brand;

        let rowHtml = `
            <tr data-id="${brand.id}">
                <td>1</td>
                <td>${brand.name}</td>
                <td>${brand.status == 1
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>'}</td>
                <td>
                    <button class="btn btn-sm btn-primary editBtn" data-id="${brand.id}">Edit</button>
                    <button class="btn btn-sm btn-danger deleteBtn" data-id="${brand.id}">Delete</button>
                </td>
            </tr>
        `;

        if(brand.id){
            // 🔹 update existing row
            let existingRow = $('tr[data-id="'+brand.id+'"]'); // Use brand.id from response
            if(existingRow.length){
                existingRow.replaceWith(rowHtml);
            } else {
                // fallback, insert if somehow row not found
                $('#example tbody').prepend(rowHtml);
            }
        } else {
            // 🔹 new insert
            $('#example tbody').prepend(rowHtml);
        }

        // 🔹 update serial numbers
        $('#example tbody tr').each(function(index){
            $(this).find('td:first').text(index + 1);
        });

        // reset form
        $('#brandForm')[0].reset();
        $('#brand_id').val('');
    },
        error: function(xhr){
            if(xhr.status === 422){
                $.each(xhr.responseJSON.errors, function(key, value){
                    toastr.error(value[0]);
                });
            } else {
                toastr.error('Unexpected error occurred.');
            }
        }
    });
});

</script>


<script>
    $(document).on('click', '.editBtn', function(){
        let id = $(this).data('id');

        $.get('/admin/product/brands/edit/' + id, function(data){
            $('#brand_id').val(data.id);
            $('#brandForm input[name="name"]').val(data.name);
            $('#brandForm select[name="status"]').val(data.status);
            $('#brandModal').modal('show');
        });
    });
</script>

<script>
    $(document).on('click', '.deleteBtn', function(){
    let button = $(this);
    let id = button.data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result)=>{
        if(result.isConfirmed){
            $.ajax({
                url: '/admin/product/brands/delete/' + id,
                type: 'POST',
                data: {_method: 'DELETE', _token: '{{ csrf_token() }}'},
                success: function(res){
                    toastr.success(res.message);
                    button.closest('tr').remove();

                    // Update serial numbers
                    $('#example tbody tr').each(function(index){
                        $(this).find('td:first').text(index + 1);
                    });
                }
            });
        }
    });
});
</script>

<script>
    $(document).on('click', '#pagination-links a', function(e){
        e.preventDefault();

        let url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html',
            success: function(data){
                $('#brandTable').html(data);
            },
            error: function(){
                toastr.error('Failed to load data.');
            }
        });
    });

</script>


@endpush
