@extends('website.layouts.app')
@section('title', 'Product Details')

@push('styles')
    <style>
        #product-details-page .offCanvas__minicart {
            position: fixed;
            top: 0;
            right: 0;
            width: 350px;
            height: 100%;
            background: #fff;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            z-index: 9999;
        }

        #product-details-page .offCanvas__minicart.is-visible {
            transform: translateX(0);
        }

        /* Offcanvas menu hidden by default */
        #product-details-page .offcanvas__sub_menu {
            display: none;
            padding-left: 15px;
        }

        /* Optional: submenu li style */
        #product-details-page .offcanvas__sub_menu_li {
            border-bottom: 1px solid #eee;
        }

        /* Submenu toggle icon */
        #product-details-page .offcanvas__menu_item.toggle::after {
            content: '+';
            float: right;
            font-weight: bold;
            cursor: pointer;
        }





        /* Submenu initial state */
        #product-details-page .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s ease, padding 0.35s ease;
            padding-left: 0;
            border-left: 1px dashed #ddd;
            margin: 0;
        }

        /* Show submenu */
        #product-details-page .submenu.show {
            padding-left: 15px;
        }

        /* Toggle arrow animation */
        #product-details-page .category-item .toggle-icon {
            font-size: 24px;
            transition: transform 0.3s ease;
        }

        #product-details-page .has-children.open>.category-item .toggle-icon {
            transform: rotate(180deg);
        }

        #product-details-page .list-group-item {
            border: unset;
        }

        /* Hover effect */
        #product-details-page .category-item:hover {
            border-radius: 5px;
            color: var(--primary-color)
        }

        #product-details-page .list-group-item.p-1.has-children {
            margin-bottom: 5px;
            border-radius: 5px;
        }

        .parant-category-class-sn {
            padding: 6px;
            border: 1px solid #dddddda3;
        }

    .product__variant--list .variant__input--fieldset {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    input[name="color"]:checked + .variant__color--value {
        border: 3px solid #007bff !important;
        box-shadow: 0 0 0 2px rgba(0,123,255,0.5) !important;
    }

    .variant__color--value {
        width: 30px !important;
        height: 30px !important;
        border-radius: 50% !important;
        border: 2px solid #666 !important;
        position: relative;
        flex-shrink: 0;
    }

    .variant__color--value span {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: block;
        background: inherit;
    }

    </style>
@endpush


@section('page_id', 'product-details-page')
@section('website_content')
    <main class="main__content_wrapper">

        @include('website.layouts.inc.breadcrumb')

        <!-- Start product details section -->
        <section class="product__details--section  section--padding">
            <div class="container-fluid">
                <div class="row row-md-reverse">
                    <div class="col-xl-3 col-lg-4">
                        @include('website.layouts.pages.product-details.product-details-sidebar')
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        <div class="product__details--sidebar__wrapper">
                            <div class="product__sidebar--wrapper__top section--padding pt-0">
                                <div class="row row-cols-xl-2 row-cols-md-2 row-cols-sm-2 row-cols-1">
                                    <div class="col">
                                        <div class="product__details--media details__media--position">




                                            <div class="product__media--preview swiper">

                                                <div class="swiper-wrapper">

                                                    @if ($productDetail->primaryImage)
                                                        <div class="swiper-slide">
                                                            <div class="product__media--preview__items">
                                                                <a class="product__media--preview__items--link glightbox"
                                                                    data-gallery="product-media-preview"
                                                                    href="{{ asset($productDetail->primaryImage->path) }}">
                                                                    <img class="product__media--preview__items--img"
                                                                        src="{{ asset($productDetail->primaryImage->path) }}"
                                                                        alt="{{ $productDetail->name }}">
                                                                </a>
                                                                <div class="product__media--view__icon">
                                                                    <a class="product__media--view__icon--link glightbox"
                                                                        href="{{ asset($productDetail->primaryImage->path) }}"
                                                                        data-gallery="product-media-preview">
                                                                        <svg class="product__media--view__icon--svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="22.51" height="22.443"
                                                                            viewBox="0 0 512 512">
                                                                            <path
                                                                                d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z"
                                                                                fill="none" stroke="currentColor"
                                                                                stroke-miterlimit="10" stroke-width="32">
                                                                            </path>
                                                                            <path fill="none" stroke="currentColor"
                                                                                stroke-linecap="round"
                                                                                stroke-miterlimit="10" stroke-width="32"
                                                                                d="M338.29 338.29L448 448">
                                                                            </path>
                                                                        </svg>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- Other Images --}}
                                                    @foreach ($productDetail->images->where('is_primary', 0)->sortBy('sort_order') as $image)
                                                        <div class="swiper-slide">
                                                            <div class="product__media--preview__items">
                                                                <a class="product__media--preview__items--link glightbox"
                                                                    data-gallery="product-media-preview"
                                                                    href="{{ asset($image->path) }}">
                                                                    <img class="product__media--preview__items--img"
                                                                        src="{{ asset($image->path) }}"
                                                                        alt="{{ $productDetail->name }}">
                                                                </a>
                                                                <div class="product__media--view__icon">
                                                                    <a class="product__media--view__icon--link glightbox"
                                                                        href="{{ asset($image->path) }}"
                                                                        data-gallery="product-media-preview">
                                                                        <svg class="product__media--view__icon--svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="22.51" height="22.443"
                                                                            viewBox="0 0 512 512">
                                                                            <path
                                                                                d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z"
                                                                                fill="none" stroke="currentColor"
                                                                                stroke-miterlimit="10" stroke-width="32">
                                                                            </path>
                                                                            <path fill="none" stroke="currentColor"
                                                                                stroke-linecap="round"
                                                                                stroke-miterlimit="10" stroke-width="32"
                                                                                d="M338.29 338.29L448 448">
                                                                            </path>
                                                                        </svg>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>






                                            {{-- Thumbnail Nav --}}
                                            <div class="product__media--nav swiper">
                                                <div class="swiper-wrapper">

                                                    @if ($productDetail->primaryImage)
                                                        <div class="swiper-slide">
                                                            <div class="product__media--nav__items">
                                                                <img class="product__media--nav__items--img"
                                                                    src="{{ asset($productDetail->primaryImage->path) }}"
                                                                    alt="{{ $productDetail->name }}">
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @foreach ($productDetail->images->where('is_primary', 0)->sortBy('sort_order') as $image)
                                                        <div class="swiper-slide">
                                                            <div class="product__media--nav__items">
                                                                <img class="product__media--nav__items--img"
                                                                    src="{{ asset($image->path) }}"
                                                                    alt="{{ $productDetail->name }}">
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>

                                                <div class="swiper__nav--btn swiper-button-next"></div>
                                                <div class="swiper__nav--btn swiper-button-prev"></div>
                                            </div>



                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="product__details--info">
                                            <form action="#">
                                                <h2 class="product__details--info__title style2 mb-15">
                                                    {{ $productDetail->name ?? 'Product Name' }}
                                                </h2>

                                                @php
                                                    $basePrice = $productDetail->base_price;
                                                    $finalPrice = $basePrice;

                                                    if (
                                                        $productDetail->discount_type &&
                                                        $productDetail->discount_value
                                                    ) {
                                                        if ($productDetail->discount_type == 'percent') {
                                                            $finalPrice =
                                                                $basePrice -
                                                                ($basePrice * $productDetail->discount_value) / 100;
                                                        } else {
                                                            $finalPrice = $basePrice - $productDetail->discount_value;
                                                        }
                                                    }
                                                @endphp

                                                <div class="product__details--info__price mb-10">
                                                    <span
                                                        class="current__price">${{ number_format($finalPrice, 2) }}</span>

                                                    @if ($finalPrice < $basePrice)
                                                        <span class="price__divided"></span>
                                                        <span class="old__price">${{ number_format($basePrice, 2) }}</span>
                                                    @endif
                                                </div>


                                                <div class="product__details--info__rating d-flex align-items-center mb-15">
                                                    <ul class="rating d-flex justify-content-center">
                                                        <li class="rating__list">
                                                            <span class="rating__list--icon">
                                                                <svg class="rating__list--icon__svg"
                                                                    xmlns="http://www.w3.org/2000/svg" width="14.105"
                                                                    height="14.732" viewBox="0 0 10.105 9.732">
                                                                    <path data-name="star - Copy"
                                                                        d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                        transform="translate(0 -0.018)" fill="currentColor">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                        <li class="rating__list">
                                                            <span class="rating__list--icon">
                                                                <svg class="rating__list--icon__svg"
                                                                    xmlns="http://www.w3.org/2000/svg" width="14.105"
                                                                    height="14.732" viewBox="0 0 10.105 9.732">
                                                                    <path data-name="star - Copy"
                                                                        d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                        transform="translate(0 -0.018)"
                                                                        fill="currentColor">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                        <li class="rating__list">
                                                            <span class="rating__list--icon">
                                                                <svg class="rating__list--icon__svg"
                                                                    xmlns="http://www.w3.org/2000/svg" width="14.105"
                                                                    height="14.732" viewBox="0 0 10.105 9.732">
                                                                    <path data-name="star - Copy"
                                                                        d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                        transform="translate(0 -0.018)"
                                                                        fill="currentColor">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                        <li class="rating__list">
                                                            <span class="rating__list--icon">
                                                                <svg class="rating__list--icon__svg"
                                                                    xmlns="http://www.w3.org/2000/svg" width="14.105"
                                                                    height="14.732" viewBox="0 0 10.105 9.732">
                                                                    <path data-name="star - Copy"
                                                                        d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                        transform="translate(0 -0.018)"
                                                                        fill="currentColor">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                        <li class="rating__list">
                                                            <span class="rating__list--icon">
                                                                <svg class="rating__list--icon__svg"
                                                                    xmlns="http://www.w3.org/2000/svg" width="14.105"
                                                                    height="14.732" viewBox="0 0 10.105 9.732">
                                                                    <path data-name="star - Copy"
                                                                        d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                        transform="translate(0 -0.018)"
                                                                        fill="currentColor">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                    <span class="product__items--rating__count--number">(24)</span>
                                                </div>
                                                <p class="product__details--info__desc mb-15">
                                                    {{ $productDetail->short_description ??
                                                        'Short description of the product goes here.' }}
                                                </p>


                                                @php
                                                    $attributes = [];

                                                    if ($productDetail->variants->isNotEmpty()) {
                                                        foreach ($productDetail->variants as $variant) {
                                                            if ($variant->values->isNotEmpty()) {
                                                                foreach ($variant->values as $value) {
                                                                    if ($value->attribute) {
                                                                        $attributes[$value->attribute->name][
                                                                            $value->id
                                                                        ] = $value;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                @endphp


                                                <div class="product__variant">
                                                    <div class="product__variant--list mb-10">
                                                        @if (isset($attributes['Color']))
                                                            <fieldset class="variant__input--fieldset">
                                                                <legend class="product__variant--title mb-8">Color :
                                                                </legend>
                                                                @foreach (collect($attributes['Color'])->unique('id') as $key => $color)
                                                                    <input id="color-{{ $color->id }}" name="color"
                                                                        type="radio" {{ $key == 0 ? 'checked' : '' }}
                                                                        value="{{ $color->id }}">

                                                                    <label class="variant__color--value"
                                                                        for="color-{{ $color->id }}"
                                                                        title="{{ $color->value }}"
                                                                        style="background-color: {{ $color->value }} !important; border: 3px solid #333 !important;">
                                                                        <span></span>
                                                                    </label>

                                                                @endforeach
                                                            </fieldset>
                                                        @endif
                                                    </div>


                                                    <div class="product__variant--list mb-15">
                                                        @if (isset($attributes['Size']))
                                                            <fieldset class="variant__input--fieldset weight">
                                                                <legend class="product__variant--title mb-8">Size :
                                                                </legend>

                                                                @foreach (collect($attributes['Size'])->unique('id') as $key => $size)
                                                                    <input id="size-{{ $size->id }}" name="size"
                                                                        type="radio" {{ $key == 0 ? 'checked' : '' }}
                                                                        value="{{ $size->id }}">

                                                                    <label class="variant__size--value red"
                                                                        for="size-{{ $size->id }}">
                                                                        {{ $size->value }}
                                                                    </label>
                                                                @endforeach

                                                            </fieldset>
                                                        @endif
                                                    </div>


                                                    <div
                                                        class="product__variant--list quantity d-flex align-items-center mb-20">
                                                        <div class="quantity__box">
                                                            <button type="button"
                                                                class="quantity__value quickview__value--quantity decrease"
                                                                aria-label="quantity value"
                                                                value="Decrease Value">-</button>
                                                            <label>
                                                                <input type="number"
                                                                    class="quantity__number quickview__value--number"
                                                                    value="1" data-counter />
                                                            </label>
                                                            <button type="button"
                                                                class="quantity__value quickview__value--quantity increase"
                                                                aria-label="quantity value"
                                                                value="Increase Value">+</button>
                                                        </div>
                                                        <button class="quickview__cart--btn primary__btn"
                                                            type="submit">Add
                                                            To Cart</button>
                                                    </div>
                                                    <div class="product__variant--list mb-15">
                                                        <a class="variant__wishlist--icon mb-15" href="wishlist.html"
                                                            title="Add to wishlist">
                                                            <i class="fa-regular fa-heart"></i>
                                                            Add to Wishlist
                                                        </a>
                                                        <button class="variant__buy--now__btn primary__btn"
                                                            type="submit">Buy it now</button>
                                                    </div>
                                                    <div class="product__details--info__meta">
                                                        <p class="product__details--info__meta--list">
                                                            <strong>Barcode:</strong> <span>565461</span>
                                                        </p>
                                                        <p class="product__details--info__meta--list"><strong>Sky:</strong>
                                                            <span>4420</span>
                                                        </p>
                                                        <p class="product__details--info__meta--list">
                                                            <strong>Vendor:</strong>
                                                            <span>{{ $productDetail->brand?->name }}</span>
                                                        </p>
                                                        <p class="product__details--info__meta--list">
                                                            <strong>Type:</strong>
                                                            <span>{{ $productDetail->category?->name }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="quickview__social d-flex align-items-center mb-15">
                                                    <label class="quickview__social--title">Social Share:</label>
                                                    <ul class="quickview__social--wrapper mt-0 d-flex">
                                                        <li class="quickview__social--list">
                                                            <a class="quickview__social--icon" target="_blank"
                                                                href="https://www.facebook.com/">
                                                                <i class="fa-brands fa-facebook-f"></i>
                                                                <span class="visually-hidden">Facebook</span>
                                                            </a>
                                                        </li>
                                                        <li class="quickview__social--list">
                                                            <a class="quickview__social--icon" target="_blank"
                                                                href="https://twitter.com/">
                                                                <i class="fa-brands fa-twitter"></i>
                                                                <span class="visually-hidden">Twitter</span>
                                                            </a>
                                                        </li>
                                                        <li class="quickview__social--list">
                                                            <a class="quickview__social--icon" target="_blank"
                                                                href="https://www.instagram.com/">
                                                                <i class="fa-brands fa-instagram"></i>
                                                                <span class="visually-hidden">Instagram</span>
                                                            </a>
                                                        </li>
                                                        <li class="quickview__social--list">
                                                            <a class="quickview__social--icon" target="_blank"
                                                                href="https://www.youtube.com/">
                                                                <i class="fa-brands fa-youtube"></i>
                                                                <span class="visually-hidden">Youtube</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="guarantee__safe--checkout">
                                                    <h5 class="guarantee__safe--checkout__title">Guaranteed Safe Checkout
                                                    </h5>
                                                    <img class="guarantee__safe--checkout__img"
                                                        src="{{ asset('frontend') }}/assets/img/other/safe-checkout.png"
                                                        alt="Payment Image">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            @include('website.layouts.pages.product-details.product-description')


                        </div>
                    </div>
                </div>
            </div>
        </section>


    </main>




@endsection

@push('frontend_scripts')
    <script src="{{ asset('frontend') }}/assets/js/product-details.js" defer="defer"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.has-children > .category-item').forEach(function(item) {
                item.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const parentLi = this.parentElement;
                    const submenu = parentLi.querySelector('.submenu');

                    if (submenu) {
                        const isOpen = parentLi.classList.contains('open');

                        if (isOpen) {
                            // Closing
                            submenu.style.maxHeight = submenu.scrollHeight +
                                "px"; // start from current height
                            submenu.offsetHeight; // force repaint
                            submenu.style.maxHeight = "0px";
                            parentLi.classList.remove('open');
                        } else {
                            // Opening
                            submenu.style.maxHeight = submenu.scrollHeight + "px";
                            parentLi.classList.add('open');

                            // Remove maxHeight after animation so dynamic children work
                            submenu.addEventListener('transitionend', function handler() {
                                if (parentLi.classList.contains('open')) {
                                    submenu.style.maxHeight = "none";
                                }
                                submenu.removeEventListener('transitionend', handler);
                            });
                        }
                    }
                });
            });
        });
    </script>


<script>
    document.addEventListener('DOMContentLoaded', function() {

    const galleryMainEl = document.querySelector('.product__media--preview.swiper');
    const galleryThumbsEl = document.querySelector('.product__media--nav.swiper');

    if(galleryMainEl && galleryThumbsEl) {

        const galleryThumbs = new Swiper(galleryThumbsEl, {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
            slideToClickedSlide: true,
            loop: false,
        });

        const galleryMain = new Swiper(galleryMainEl, {
            spaceBetween: 10,
            loop: false,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: galleryThumbs
            }
        });
    }

    // Lightbox init
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
    });

    // Color variant image change
    const colorInputs = document.querySelectorAll('input[name="color"]');
    const galleryMainSwiper = document.querySelector('.product__media--preview.swiper').swiper;
    const galleryThumbsSwiper = document.querySelector('.product__media--nav.swiper').swiper;

    // Store variant color images (pass from controller)
    const variantColorImages = @json($productDetail->variantColorImages ?? []);

    colorInputs.forEach(input => {
        input.addEventListener('change', function() {
            const selectedColorId = this.value;

            // Find image for this color
            const colorImage = variantColorImages.find(item =>
                item.attribute_value_id == selectedColorId
            );

            if(colorImage) {
                // Replace all slides with color-specific image
                galleryMainSwiper.removeAllSlides();
                galleryThumbsSwiper.removeAllSlides();

                const mainSlide = document.createElement('div');
                mainSlide.className = 'swiper-slide';
                mainSlide.innerHTML = `
                    <div class="product__media--preview__items">
                        <a class="product__media--preview__items--link glightbox"
                           data-gallery="product-media-preview"
                           href="{{ asset('') }}${colorImage.image_path}">
                            <img class="product__media--preview__items--img"
                                 src="{{ asset('') }}${colorImage.image_path}"
                                 alt="Product color variant">
                        </a>
                        <div class="product__media--view__icon">
                            <a class="product__media--view__icon--link glightbox"
                               href="{{ asset('') }}${colorImage.image_path}"
                               data-gallery="product-media-preview">
                                <svg class="product__media--view__icon--svg"
                                     xmlns="http://www.w3.org/2000/svg"
                                     width="22.51" height="22.443"
                                     viewBox="0 0 512 512">
                                    <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z"
                                          fill="none" stroke="currentColor"
                                          stroke-miterlimit="10" stroke-width="32"></path>
                                    <path fill="none" stroke="currentColor"
                                          stroke-linecap="round"
                                          stroke-miterlimit="10" stroke-width="32"
                                          d="M338.29 338.29L448 448"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                `;

                const thumbSlide = document.createElement('div');
                thumbSlide.className = 'swiper-slide';
                thumbSlide.innerHTML = `
                    <div class="product__media--nav__items">
                        <img class="product__media--nav__items--img"
                             src="{{ asset('') }}${colorImage.image_path}"
                             alt="Product color variant">
                    </div>
                `;

                galleryMainSwiper.appendSlide(mainSlide);
                galleryThumbsSwiper.appendSlide(thumbSlide);

                galleryMainSwiper.slideTo(0);
                galleryThumbsSwiper.slideTo(0);

                // Reinitialize lightbox
                lightbox.reload();
            }
        });
    });

});
</script>
@endpush
