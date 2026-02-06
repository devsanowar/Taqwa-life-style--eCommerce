<table id="example" class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($brands as $key => $brand)
        <tr data-id="{{ $brand->id }}">
            <td>{{ $brands->firstItem() + $key }}</td>
            <td>{{ $brand->name }}</td>
            <td>
                {!! $brand->status
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>' !!}
            </td>
            <td>
                <button class="btn btn-sm btn-primary editBtn" data-id="{{ $brand->id }}">Edit</button>
                <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $brand->id }}">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div id="pagination-links" class="mt-2" style=" float: right;">
    {!! $brands->links('admin.layouts.pages.product.brand.partials.pagination') !!}
</div>