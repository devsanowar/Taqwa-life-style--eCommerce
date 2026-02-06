<div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMenuModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="menuForm" method="POST" action="{{ route('admin.website.menu.store') }}">
                    @csrf
                    <!-- Menu Name -->
                    <div class="col-md-12 mb-3">
                        <label for="menu_name" class="form-label">Menu Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class='bx bx-menu'></i></span>
                            <input type="text" name="menu_name" class="form-control" id="menu_name"
                                value="{{ old('menu_name', $menu->menu_name ?? '') }}" placeholder="Enter menu name">
                        </div>
                    </div>

                    <!-- Menu URL -->
                    <div class="col-md-12 mb-3">
                        <label for="menu_url" class="form-label">Menu URL</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class='bx bx-link'></i></span>
                            <input type="text" name="menu_url" class="form-control" id="menu_url"
                                value="{{ old('menu_url', $menu->menu_url ?? '') }}"
                                placeholder="/about, /contact, etc.">
                        </div>
                    </div>

                    <!-- Parent Menu -->
                    <div class="col-md-12 mb-3">
                        <label for="parent_id" class="form-label">Parent Menu</label>
                        <select name="parent_id" id="parent_id" class="form-control">
                            <option value="">-- None (Top Level) --</option>
                            @foreach($parents as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->menu_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Order -->
                    <div class="col-md-12 mb-3">
                        <label for="order" class="form-label">Order</label>
                        <input type="number" name="order" class="form-control" id="order"
                            value="{{ old('order', $menu->order ?? 0) }}" min="0">
                    </div>

                    <!-- Status -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label d-block mb-2">Status</label>
                        <div class="d-flex align-items-center gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_active" id="active" value="1">
                                <label class="form-check-label" for="active">Active</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_active" id="inactive" value="0">
                                <label class="form-check-label" for="inactive">Inactive</label>
                            </div>
                        </div>
                    </div>



                    <!-- Submit -->
                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <span id="btnText">Save Menu</span>
                                <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
