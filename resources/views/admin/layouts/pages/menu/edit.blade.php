<!-- Edit Menu Modal -->
<div class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="editMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editMenuForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_menu_id" name="id">

                    <div class="mb-3">
                        <label>Menu Name</label>
                        <input type="text" name="menu_name" id="edit_menu_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Menu URL</label>
                        <input type="text" name="menu_url" id="edit_menu_url" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Parent Menu</label>
                        <select name="parent_id" id="edit_parent_id" class="form-control">
                            @foreach($parents as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->menu_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Order</label>
                        <input type="number" name="order" id="edit_order" class="form-control" min="0">
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="edit_active" value="1">
                            <label class="form-check-label" for="edit_active">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="edit_inactive" value="0">
                            <label class="form-check-label" for="edit_inactive">Inactive</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Menu</button>
                </form>

            </div>
        </div>
    </div>
</div>
