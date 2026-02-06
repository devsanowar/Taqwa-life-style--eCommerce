@extends('admin.dashboard')
@section('title', 'website menus')
@push('styles')
<link href="{{ asset('backend') }}/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
@endpush
@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-xl-12">
            <h6 class="mb-0 text-uppercase d-flex justify-content-between align-items-center">
                All Menus
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMenuModal">
                    Add Menu
                </button>
            </h6>

            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">S/N</th>
                                    <th>Menu Name</th>
                                    <th>Parent Menu</th>
                                    <th>Menu Url</th>
                                    <th class="text-center">Order By</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Created At</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($menus as $index => $menuItem)
                                <tr id="row-{{ $menuItem->id }}">
                                    <!-- Serial Number -->
                                    <td class="text-center">{{ $index + 1 }}</td>

                                    <!-- Menu Name -->
                                    <td>
                                        {{ $menuItem->menu_name ?? '' }}
                                        @if($menuItem->children->count() > 0)
                                        <span class="badge bg-info ms-2">Has Submenu</span>
                                        @endif
                                    </td>

                                    <!-- Parent Menu -->
                                    <td>
                                        @if($menuItem->parent)
                                        <span class="badge bg-secondary">{{ $menuItem->parent->menu_name }}</span>
                                        @else
                                        <span class="badge bg-primary">Parent</span>
                                        @endif
                                    </td>

                                    <!-- Menu URL -->
                                    <td><a href="{{ $menuItem->menu_url }}" target="_blank">{{ $menuItem->menu_url
                                            }}</a></td>

                                    <!-- Order -->
                                    <td class="text-center">{{ $menuItem->order ?? 0 }}</td>

                                    <!-- Status -->
                                    <td class="text-center">
                                        @if($menuItem->is_active)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <!-- Created At -->
                                    <td class="text-center">{{ $menuItem->created_at->format('Y/m/d') ?? '' }}</td>

                                    <!-- Action Buttons -->
                                    <td class="text-center">
                                        <!-- Edit Button -->
                                        <a href="javascript:void(0);"
                                            class="action-icon border border-primary text-primary me-2 editMenuBtn"
                                            data-bs-toggle="modal" data-bs-target="#editMenuModal"
                                            data-id="{{ $menuItem->id }}" data-name="{{ $menuItem->menu_name }}"
                                            data-url="{{ $menuItem->menu_url }}"
                                            data-parent="{{ $menuItem->parent_id }}" data-order="{{ $menuItem->order }}"
                                            data-status="{{ $menuItem->is_active }}">
                                            <i class="bx bx-edit"></i>
                                        </a>


                                        <form action="{{ route('admin.website.menu.destroy', $menuItem->id) }}"
                                            method="POST" class="deleteMenuForm" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="action-icon border border-danger text-danger deleteBtn"
                                                data-id="{{ $menuItem->id }}">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>


                                    </td>



                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Menu not found!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            @include('admin.layouts.pages.menu.create')
            @include('admin.layouts.pages.menu.edit')
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
		  } );
</script>
<script>
    $(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );

			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
</script>

<script>
    $(document).on('click', '.editMenuBtn', function () {
    let id = $(this).data('id');
    let name = $(this).data('name');
    let url = $(this).data('url');
    let parent = $(this).data('parent');
    let order = $(this).data('order');
    let status = $(this).data('status');

    $('#edit_menu_id').val(id);
    $('#edit_menu_name').val(name);
    $('#edit_menu_url').val(url);
    $('#edit_parent_id').val(parent);
    $('#edit_order').val(order);
    if(status == 1){
        $('#edit_active').prop('checked', true);
    } else {
        $('#edit_inactive').prop('checked', true);
    }

    $('#editMenuForm').attr('action', '/admin/website-menu/update/' + id);
});

</script>


<script>
    $(document).ready(function() {
    $(document).on('click', '.deleteBtn', function() {
        let button = $(this);
        let form = button.closest('form');
        let rowId = button.data('id');

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
                form.submit(); // Laravel will handle deletion
            }
        });
    });
});
</script>



@endpush
