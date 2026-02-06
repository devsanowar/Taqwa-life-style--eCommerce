@extends('admin.dashboard')
@section('title', 'Theme Customize')
@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-xl-12">

            <div class="card">
                <div class="card-body p-4">
                    <h5 class="mb-4">Theme Customizer</h5>
                    <form id="themeCustomizeForm" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Website Title -->
                        <div class="col-md-12 mb-3">
                            <label for="theme_style" class="form-label">Theme Style</label>
                            <div class="input-group">
                                <div class="d-flex align-items-center gap-3">

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="radio" role="switch" id="lightTheme"
                                            name="theme_style" value="light-theme" {{ ($themeCustomize->theme_style ??
                                        '') === 'light-theme' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="lightTheme">Light Theme</label>
                                    </div>

                                    <div class="form-check form-switch form-check-success">
                                        <input class="form-check-input" type="radio" role="switch" id="darkTheme"
                                            name="theme_style" value="dark-theme" {{ ($themeCustomize->theme_style ??
                                        '') === 'dark-theme' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="darkTheme">Dark Theme</label>
                                    </div>

                                    <div class="form-check form-switch form-check-danger">
                                        <input class="form-check-input" type="radio" role="switch" id="semiDarkTheme"
                                            name="theme_style" value="semi-dark" {{ ($themeCustomize->theme_style ?? '')
                                        === 'semi-dark' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="semiDarkTheme">Semi Dark</label>
                                    </div>

                                    <div class="form-check form-switch form-check-warning">
                                        <input class="form-check-input" type="radio" role="switch" id="minimalTheme"
                                            name="theme_style" value="minimal-theme" {{ ($themeCustomize->theme_style ??
                                        '') === 'minimal-theme' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="minimalTheme">Minimal Theme</label>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <span id="btnText">Submit</span>
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
</div>
@endsection

@push('scripts')

<script>
    $(document).ready(function(){
    $('#themeCustomizeForm').submit(function(e){
        e.preventDefault();

        let formData = $(this).serialize();

        let $submitBtn = $('#submitBtn');
        $submitBtn.prop('disabled', true);
        $('#btnText').text('Processing...');
        $('#btnSpinner').removeClass('d-none');

        $.ajax({
            url: "{{ route('admin.theme.customize.update') }}", // Laravel route
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $submitBtn.prop('disabled', false);
                $('#btnText').text('Submit');
                $('#btnSpinner').addClass('d-none');

                if (response.status === 'success') {
                    toastr.success(response.message);

                    if (response.data) {
                        $('html').removeClass().addClass(response.data.theme_style);
                    }

                } else {
                    toastr.error(response.message || 'An error occurred.');
                }
            },

            error: function(xhr) {
                $submitBtn.prop('disabled', false);
                $('#btnText').text('Submit');
                $('#btnSpinner').addClass('d-none');

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, messages) {
                        toastr.error(messages[0]); // Show first error message per field
                    });
                } else {
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                }
            }
        });
    });
});
</script>



@endpush
