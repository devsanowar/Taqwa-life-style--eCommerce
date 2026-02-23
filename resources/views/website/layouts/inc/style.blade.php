<link rel="shortcut icon" type="image/x-icon"
    href="{{ asset($website_setting->website_favicon ?? 'assets/img/favicon.ico') }}" />


<link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/swiper-bundle.min.css') }}" />
<link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/glightbox.min.css') }}" />
<link
    href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
    rel="stylesheet" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{ asset('frontend/assets/css/vendor/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}" />
<!-- Font Awesome Free CDN -->

@stack('styles')

<style>
    input::placeholder,
    textarea::placeholder {
        color: #303030;
        opacity: 1;
        font-size: 16px;
    }

    .search-suggestion-box {
        position: absolute;
        top: 100%;
        left: 336px;
        width: 570px;
        max-height: 400px;
        overflow-y: auto;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        padding: 5px 0;
        display: none;
    }

    /* Show class */
    .search-suggestion-box.show {
        display: block;
    }

    /* Individual suggestion item */
    .suggest-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 10px;
        transition: background 0.2s;
        cursor: pointer;
    }

    .suggest-item:hover {
        background: #f5f5f5;
    }


    .suggest-img img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 5px;
    }


    .suggest-content {
        flex: 1;
        display: flex;
        justify-content: space-between;
        justify-items: self-start;
    }

    .suggest-title {
        font-weight: 600;
        font-size: 14px;
        line-height: 1.2;
        color: #333;
    }

    .suggest-price {
        font-weight: 500;
        font-size: 13px;
        color: #555;
    }

    /* Add to cart button */
    .suggest-add-btn {
        background: #D39A15;
        color: #fff;
        border: none;
        padding: 5px 8px;
        border-radius: 3px;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.2s;
    }

    .suggest-add-btn:hover {
        background: #926600;
    }
</style>