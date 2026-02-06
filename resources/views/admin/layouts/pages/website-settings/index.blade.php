@extends('admin.dashboard')
@section('title', 'Transport Agency | Website Settings')
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css" />

@endpush
@section('admin_content')
<div class="page-content">
    <!--end breadcrumb-->
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="pill" href="#primary-pills-website-settings"
                                role="tab" aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class='bx  bx-cog font-18 me-1'></i>
                                    </div>
                                    <div class="tab-title">Website Settings</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="pill" href="#primary-pills-profile" role="tab"
                                aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class='bx  bx-color-fill font-18 me-1'></i>
                                    </div>
                                    <div class="tab-title">Website Color Settings</div>
                                </div>
                            </a>
                        </li>
                        
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="primary-pills-website-settings" role="tabpanel">
                            <form id="websiteSettingForm" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Website Title -->
                                <div class="col-md-12 mb-3">
                                    <label for="website_title" class="form-label">Website Title</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-globe-alt'></i></span>
                                        <input type="text" name="website_title" class="form-control" id="website_title"
                                            value="{{ $websiteSetting->website_title ?? '' }}"
                                            placeholder="Website Title">
                                    </div>
                                </div>

                                <!-- Website Header Logo -->
                                <div class="col-md-12 mb-3">
                                    <label for="website_header_logo" class="form-label">Website Logo</label>
                                    <input class="form-control" type="file" name="website_header_logo"
                                        id="website_header_logo">
                                    @if($websiteSetting && $websiteSetting->website_header_logo)
                                    <img id="preview_website_header_logo"
                                        src="{{ asset($websiteSetting->website_header_logo ?? '') }}" alt="logo"
                                        class="mt-2" width="100">
                                    @endif
                                </div>

                                <!-- Favicon -->
                                <div class="col-md-12 mb-3">
                                    <label for="website_favicon" class="form-label">Favicon Icon</label>
                                    <input class="form-control" type="file" name="website_favicon" id="website_favicon">

                                    @if($websiteSetting && $websiteSetting->website_favicon)
                                    <img id="preview_website_favicon"
                                        src="{{ asset($websiteSetting->website_favicon ?? '') }}" alt="favicon"
                                        class="mt-2" width="50">
                                    @endif
                                </div>

                                <!-- Footer Logo -->
                                <div class="col-md-12 mb-3">
                                    <label for="website_footer_logo" class="form-label">Footer Logo</label>
                                    <input class="form-control" type="file" name="website_footer_logo"
                                        id="website_footer_logo">
                                    @if($websiteSetting && $websiteSetting->website_footer_logo)
                                    <img id="preview_website_footer_logo"
                                        src="{{ asset($websiteSetting->website_footer_logo ?? '') }}" alt="footer logo"
                                        class="mt-2" width="100">
                                    @endif
                                </div>

                                <!-- Footer Background Image -->
                                <div class="col-md-12 mb-3">
                                    <label for="website_footer_bg_image" class="form-label">Footer Background
                                        Image</label>
                                    <input class="form-control" type="file" name="website_footer_bg_image"
                                        id="website_footer_bg_image">
                                    @if($websiteSetting && $websiteSetting->website_footer_bg_image)
                                    <img id="preview_website_footer_bg_image"
                                        src="{{ asset($websiteSetting->website_footer_bg_image) }}" alt="footer bg"
                                        class="mt-2" width="150">
                                    @endif
                                </div>

                                <!-- Footer Background Color -->
                                <div class="col-md-12 mb-3">
                                    <label for="website_footer_bg_color" class="form-label">Footer Background
                                        Color</label>
                                    <div class="input-group">
                                        <span class="input-group-text">HEX</span>
                                        <input type="text" id="hexValue" name="website_footer_bg_color"
                                            class="form-control"
                                            value="{{ $websiteSetting->website_footer_bg_color ?? '#FFFFFF' }}"
                                            readonly>

                                        <input type="color" id="colorInput" class="d-none"
                                            value="{{ $websiteSetting->website_footer_bg_color ?? '#FFFFFF' }}">

                                        <span class="input-group-text p-0" style="width: 5%; cursor: pointer;">
                                            <div id="previewBox"
                                                style="width: 100%; height: 100%; background:{{ $websiteSetting->website_footer_bg_color ?? '#FFFFFF' }}; border-radius: 0 0.375rem 0.375rem 0;">
                                            </div>
                                        </span>
                                    </div>
                                </div>

                                <!-- Website URL -->
                                <div class="col-md-12 mb-3">
                                    <label for="website_website_url" class="form-label">Website Url</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-link'></i></span>
                                        <input type="text" name="website_website_url" class="form-control"
                                            id="website_website_url"
                                            value="{{ $websiteSetting->website_website_url ?? ''}}"
                                            placeholder="http://devsanowr.com">
                                    </div>
                                </div>

                                <!-- Email One -->
                                <div class="col-md-12 mb-3">
                                    <label for="website_email_one" class="form-label">Email One</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-envelope-open'></i></span>
                                        <input type="email" name="website_email_one" class="form-control"
                                            id="website_email_one"
                                            value="{{ $websiteSetting->website_email_one ?? '' }}"
                                            placeholder="example@gmail.com">
                                    </div>
                                </div>

                                <!-- Email Two -->
                                <div class="col-md-12 mb-3">
                                    <label for="website_email_two" class="form-label">Email Two</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-envelope-open'></i></span>
                                        <input type="email" name="website_email_two" class="form-control"
                                            id="website_email_two" value="{{ $websiteSetting->website_email_two ?? ''}}"
                                            placeholder="example2@gmail.com">
                                    </div>
                                </div>

                                <!-- Phone Number One -->
                                <div class="col-md-12 mb-3">
                                    <label for="website_phone_number_one" class="form-label">Phone Number One</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-phone'></i></span>
                                        <input type="text" name="website_phone_number_one" class="form-control"
                                            id="website_phone_number_one"
                                            value="{{ $websiteSetting->website_phone_number_one ?? ''}}"
                                            placeholder="017XXXXXXX">
                                    </div>
                                </div>

                                <!-- Phone Number Two -->
                                <div class="col-md-12 mb-3">
                                    <label for="website_phone_number_two" class="form-label">Phone Number Two</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-phone'></i></span>
                                        <input type="text" name="website_phone_number_two" class="form-control"
                                            id="website_phone_number_two"
                                            value="{{ $websiteSetting->website_phone_number_two ?? ''}}"
                                            placeholder="016XXXXXXX">
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-md-12 mb-3">
                                    <label for="website_address" class="form-label">Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-map'></i></span>
                                        <input type="text" name="website_address" class="form-control"
                                            id="website_address" value="{{ $websiteSetting->website_address ?? ''}}"
                                            placeholder="Enter address here">
                                    </div>
                                </div>

                                <!-- Footer Content -->
                                <div class="col-md-12 mb-3">
                                    <label for="website_footer_content" class="form-label">About (Short Content)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-edit'></i></span>
                                        <textarea name="website_footer_content" class="form-control" rows="3"
                                            id="website_footer_content"
                                            placeholder="Footer content here ...">{{ $websiteSetting->website_footer_content ?? '' }}</textarea>
                                    </div>
                                </div>

                                <!-- Copyright Text -->
                                <div class="col-md-12 mb-3">
                                    <label for="website_copyright_text" class="form-label">Copy Right Text</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-copyright'></i></span>
                                        <input type="text" name="website_copyright_text" class="form-control"
                                            id="website_copyright_text"
                                            value="{{ $websiteSetting->website_copyright_text ?? ''}}"
                                            placeholder="Copy right text here">
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary" id="submitBtn">
                                            <span id="btnText">Submit</span>
                                            <span id="btnSpinner" class="spinner-border spinner-border-sm d-none"
                                                role="status" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="primary-pills-profile" role="tabpanel">
                            <form id="websiteColorsForm">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <!-- Fonts -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Primary Font</label>
                                        <input type="text" class="form-control" name="font_primary"
                                            value='"Poppins", sans-serif'>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Secondary Font</label>
                                        <input type="text" class="form-control" name="font_secondary"
                                            value='"Rubik", sans-serif'>
                                    </div>

                                    <!-- Gray -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Gray Color (HEX)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="grayHex" name="gray"
                                                value="#585b6b">
                                            <input type="color" id="grayHexPicker" value="#585b6b"
                                                style="width:40px;height:38px;">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Gray Color (RGB)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="grayRgb" name="gray_rgb"
                                                value="88, 91, 107">
                                            <button type="button" class="btn btn-outline-secondary"
                                                id="grayRgbBtn">🎨</button>
                                            <input type="color" id="grayRgbPicker" style="display:none;">
                                        </div>
                                    </div>

                                    <!-- Base -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Base Color (HEX)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="baseHex" name="base"
                                                value="#FD5523">
                                            <input type="color" id="baseHexPicker" value="#FD5523"
                                                style="width:40px;height:38px;">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Base Color (RGB)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="baseRgb" name="base_rgb"
                                                value="253, 85, 35">
                                            <button type="button" class="btn btn-outline-secondary"
                                                id="baseRgbBtn">🎨</button>
                                            <input type="color" id="baseRgbPicker" style="display:none;">
                                        </div>
                                    </div>

                                    <!-- Primary -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Primary Color (HEX)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="primaryHex" name="primary"
                                                value="#F4F5F9">
                                            <input type="color" id="primaryHexPicker" value="#F4F5F9"
                                                style="width:40px;height:38px;">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Primary Color (RGB)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="primaryRgb" name="primary_rgb"
                                                value="244, 245, 249">
                                            <button type="button" class="btn btn-outline-secondary"
                                                id="primaryRgbBtn">🎨</button>
                                            <input type="color" id="primaryRgbPicker" style="display:none;">
                                        </div>
                                    </div>

                                    <!-- Black -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Black Color (HEX)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="blackHex" name="black"
                                                value="#062f3a">
                                            <input type="color" id="blackHexPicker" value="#062f3a"
                                                style="width:40px;height:38px;">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Black Color (RGB)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="blackRgb" name="black_rgb"
                                                value="6, 47, 58">
                                            <button type="button" class="btn btn-outline-secondary"
                                                id="blackRgbBtn">🎨</button>
                                            <input type="color" id="blackRgbPicker" style="display:none;">
                                        </div>
                                    </div>

                                    <!-- White -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">White Color (HEX)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="whiteHex" name="white"
                                                value="#ffffff">
                                            <input type="color" id="whiteHexPicker" value="#ffffff"
                                                style="width:40px;height:38px;">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">White Color (RGB)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="whiteRgb" name="white_rgb"
                                                value="255, 255, 255">
                                            <button type="button" class="btn btn-outline-secondary"
                                                id="whiteRgbBtn">🎨</button>
                                            <input type="color" id="whiteRgbPicker" style="display:none;">
                                        </div>
                                    </div>

                                    <!-- Border -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Border Color (HEX)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="borderHex" name="border_color"
                                                value="#e6e6e6">
                                            <input type="color" id="borderHexPicker" value="#e6e6e6"
                                                style="width:40px;height:38px;">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Border Color (RGB)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="borderRgb"
                                                name="border_color_rgb" value="230, 230, 230">
                                            <button type="button" class="btn btn-outline-secondary"
                                                id="borderRgbBtn">🎨</button>
                                            <input type="color" id="borderRgbPicker" style="display:none;">
                                        </div>
                                    </div>


                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                            <span id="colorBtnText">Submit</span>
                                            <span id="colorBtnSpinner" class="spinner-border spinner-border-sm d-none"
                                                role="status" aria-hidden="true"></span>
                                        </button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--end row-->
</div>
@endsection
@push('scripts')


<script>
    function hexToRgb(hex) {
    hex = hex.replace('#','');
    let bigint = parseInt(hex,16);
    let r = (bigint >>16) & 255;
    let g = (bigint >>8) & 255;
    let b = bigint & 255;
    return r + ',' + g + ',' + b;
}

// RGB button trigger
function setupRgbPicker(rgbInputId, btnId, pickerId){
    const rgbInput = document.getElementById(rgbInputId);
    const btn = document.getElementById(btnId);
    const picker = document.getElementById(pickerId);

    btn.addEventListener('click', () => picker.click());
    picker.addEventListener('input', () => {
        rgbInput.value = hexToRgb(picker.value);
    });
}

// Setup all RGB pickers
setupRgbPicker('grayRgb', 'grayRgbBtn', 'grayRgbPicker');
setupRgbPicker('baseRgb', 'baseRgbBtn', 'baseRgbPicker');
setupRgbPicker('primaryRgb', 'primaryRgbBtn', 'primaryRgbPicker');
setupRgbPicker('blackRgb', 'blackRgbBtn', 'blackRgbPicker');
setupRgbPicker('whiteRgb', 'whiteRgbBtn', 'whiteRgbPicker');
setupRgbPicker('borderRgb', 'borderRgbBtn', 'borderRgbPicker');
</script>

<script>
    // Convert HEX → RGB
    function hexToRgb(hex) {
        let r = 0, g = 0, b = 0;
        hex = hex.replace("#", "");
        if (hex.length === 3) {
            r = parseInt(hex[0]+hex[0], 16);
            g = parseInt(hex[1]+hex[1], 16);
            b = parseInt(hex[2]+hex[2], 16);
        } else if (hex.length === 6) {
            r = parseInt(hex.substring(0,2), 16);
            g = parseInt(hex.substring(2,4), 16);
            b = parseInt(hex.substring(4,6), 16);
        }
        return `${r}, ${g}, ${b}`;
    }

    // Bind picker + hex + rgb sync
    function bindColor(pickerId, hexId, rgbId) {
        const picker = document.getElementById(pickerId);
        const hex = document.getElementById(hexId);
        const rgb = document.getElementById(rgbId);

        picker.addEventListener("input", () => {
            hex.value = picker.value;
            rgb.value = hexToRgb(picker.value);
        });

        hex.addEventListener("input", () => {
            picker.value = hex.value;
            rgb.value = hexToRgb(hex.value);
        });
    }

    bindColor("grayPicker", "grayHex", "grayRgb");
    bindColor("basePicker", "baseHex", "baseRgb");
    bindColor("primaryPicker", "primaryHex", "primaryRgb");
    bindColor("blackPicker", "blackHex", "blackRgb");
    bindColor("whitePicker", "whiteHex", "whiteRgb");
    bindColor("borderPicker", "borderHex", "borderRgb");
</script>

<script>
    $(document).ready(function() {

    $('#websiteSettingForm').on('submit', function(e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);

        let $submitBtn = $('#submitBtn');
        $submitBtn.prop('disabled', true);
        $('#btnText').text('Processing...');
        $('#btnSpinner').removeClass('d-none');

        $.ajax({
            url: "{{ route('admin.website.setting.update') }}", // Laravel route
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure CSRF token is included
            },
            success: function(response) {
                $submitBtn.prop('disabled', false);
                $('#btnText').text('Submit');
                $('#btnSpinner').addClass('d-none');

                if (response.status === 'success') {
                    toastr.success(response.message);

                    if (response.data) {
                        if(response.data.website_header_logo){
                            $('#preview_website_header_logo').attr('src', response.data.website_header_logo + '?t=' + new Date().getTime());
                        }
                        if(response.data.website_favicon){
                            $('#preview_website_favicon').attr('src', response.data.website_favicon + '?t=' + new Date().getTime());
                        }
                        if(response.data.website_footer_logo){
                            $('#preview_website_footer_logo').attr('src', response.data.website_footer_logo + '?t=' + new Date().getTime());
                        }
                        if(response.data.website_footer_bg_image){
                            $('#preview_website_footer_bg_image').attr('src', response.data.website_footer_bg_image + '?t=' + new Date().getTime());
                        }
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


// Website Color update

$(document).ready(function(){
    $('#websiteColorsForm').submit(function(e){
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);

        let $submitBtn = $('#submitBtn');
        $submitBtn.prop('disabled', true);
        $('#colorBtnText').text('Processing...');
        $('#colorBtnSpinner').removeClass('d-none');

        $.ajax({
            url: "{{ route('admin.website.setting.color.update') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $submitBtn.prop('disabled', false);
                $('#colorBtnText').text('Submit');
                $('#colorBtnSpinner').addClass('d-none');

                if (response.status === 'success') {
                    toastr.success(response.message);

                } else {
                    toastr.error(response.message || 'An error occurred.');
                }
            },

            error: function(xhr) {
                $submitBtn.prop('disabled', false);
                $('#colorBtnText').text('Submit');
                $('#colorBtnSpinner').addClass('d-none');

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, messages) {
                        toastr.error(messages[0]);
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
