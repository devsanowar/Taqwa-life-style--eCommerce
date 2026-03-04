<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Product Details</title>
    <meta name="description" content="Morden Bootstrap HTML5 Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend') }}/assets/img/favicon.ico">

    @include('website.layouts.inc.style')

    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/custom.css">

</head>

<body>

    @include('website.layouts.inc.header')

    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Product Details</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white"
                                        href="index.html">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Product
                                        Details</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Start product details section -->
        <section class="product__details--section section--padding">
            <div class="container">
                <div class="row row-cols-lg-2 row-cols-md-2">
                    <div class="col">
                        <div class="product__details--media">
                            <div class="product__media--preview swiper">
                                <div class="swiper-wrapper">
                                    @forelse($productDetail->sortedImages as $image)
                                        <div class="swiper-slide">
                                            <div class="product__media--preview__items">
                                                <a class="product__media--preview__items--link glightbox"
                                                    data-gallery="product-media-preview"
                                                    href="{{ asset($image->path) }}">
                                                    <img class="product__media--preview__items--img"
                                                        src="{{ asset($image->path) }}"
                                                        alt="{{ $productDetail->name ?? 'product-media-img' }}">
                                                </a>
                                                <div class="product__media--view__icon">
                                                    <a class="product__media--view__icon--link glightbox"
                                                        href="{{ asset($image->path) }}"
                                                        data-gallery="product-media-preview">
                                                        <svg class="product__media--view__icon--svg"
                                                            xmlns="http://www.w3.org/2000/svg" width="22.51"
                                                            height="22.443" viewBox="0 0 512 512">
                                                            <path
                                                                d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z"
                                                                fill="none" stroke="currentColor"
                                                                stroke-miterlimit="10" stroke-width="32"></path>
                                                            <path fill="none" stroke="currentColor"
                                                                stroke-linecap="round" stroke-miterlimit="10"
                                                                stroke-width="32" d="M338.29 338.29L448 448"></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        {{-- Fallback content --}}
                                    @endforelse
                                </div>
                            </div>

                            <div class="product__media--nav swiper">
                                <div class="swiper-wrapper">
                                    @forelse($productDetail->sortedImages as $image)
                                        <div class="swiper-slide">
                                            <div class="product__media--nav__items">
                                                <img class="product__media--nav__items--img"
                                                    src="{{ asset($image->path) }}"
                                                    alt="{{ $productDetail->name ?? 'product-nav-img' }}">
                                            </div>
                                        </div>
                                    @empty
                                        {{-- Fallback content --}}
                                    @endforelse
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

                                    if ($productDetail->discount_type && $productDetail->discount_value) {
                                        if ($productDetail->discount_type == 'percent') {
                                            $finalPrice =
                                                $basePrice - ($basePrice * $productDetail->discount_value) / 100;
                                        } else {
                                            $finalPrice = $basePrice - $productDetail->discount_value;
                                        }
                                    }
                                @endphp

                                <div class="product__details--info__price mb-10">
                                    <span class="current__price">${{ number_format($finalPrice, 2) }}</span>

                                    @if ($finalPrice < $basePrice)
                                        <span class="price__divided"></span>
                                        <span class="old__price">${{ number_format($basePrice, 2) }}</span>
                                    @endif
                                </div>


                                <div class="product__details--info__rating d-flex align-items-center mb-15">
                                    <ul class="rating d-flex justify-content-center">
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg"
                                                    width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy"
                                                        d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                        transform="translate(0 -0.018)" fill="currentColor">
                                                    </path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg"
                                                    width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy"
                                                        d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                        transform="translate(0 -0.018)" fill="currentColor">
                                                    </path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg"
                                                    width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
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
                                                    xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732"
                                                    viewBox="0 0 10.105 9.732">
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
                                                    xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732"
                                                    viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy"
                                                        d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                        transform="translate(0 -0.018)" fill="currentColor">
                                                    </path>
                                                </svg>
                                            </span>
                                        </li>
                                    </ul>
                                    <span class="product__items--rating__count--number">(24)</span>
                                </div>
                                <p class="product__details--info__desc mb-15">
                                    {!! $productDetail->short_description ?? 'Short description of the product goes here.' !!}
                                </p>


                                @php
                                    $attributes = [];

                                    if ($productDetail->variants->isNotEmpty()) {
                                        foreach ($productDetail->variants as $variant) {
                                            if ($variant->values->isNotEmpty()) {
                                                foreach ($variant->values as $value) {
                                                    if ($value->attribute) {
                                                        $attributes[$value->attribute->name][$value->id] = $value;
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
                                                        for="color-{{ $color->id }}" title="{{ $color->value }}"
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


                                    <div class="product__variant--list quantity d-flex align-items-center mb-20">
                                        <div class="quantity__box">
                                            <button type="button"
                                                class="quantity__value quickview__value--quantity decrease">-</button>

                                            <label>
                                                <input type="number"
                                                    class="quantity__number quickview__value--number" value="1"
                                                    min="1" />
                                            </label>

                                            <button type="button"
                                                class="quantity__value quickview__value--quantity increase">+</button>
                                        </div>

                                        <!-- IMPORTANT CHANGE -->
                                        <button class="quickview__cart--btn primary__btn add-to-cart-details"
                                            type="button" data-id="{{ $productDetail->id }}">
                                            Add To Cart
                                        </button>
                                    </div>
                                    <div class="product__variant--list mb-15">
                                        <a class="product__items--action__btn add-to-wishlist"
                                            href="javascript:void(0)" data-id="{{ $productDetail->id }}">
                                            <i class="fa-regular fa-heart"></i>
                                            Add to Wishlist
                                        </a>
                                        <button class="variant__buy--now__btn primary__btn mt-4" type="submit">Buy it
                                            now</button>
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
                                @php
                                    $currentUrl = urlencode(url()->current());
                                    $title = urlencode($productDetail->name);
                                @endphp

                                <div class="quickview__social d-flex align-items-center mb-15">
                                    <label class="quickview__social--title">Social Share:</label>

                                    <ul class="quickview__social--wrapper mt-0 d-flex">

                                        <!-- Facebook -->
                                        <li class="quickview__social--list">
                                            <a class="quickview__social--icon" target="_blank"
                                                href="https://www.facebook.com/sharer/sharer.php?u={{ $currentUrl }}">
                                                <i class="fa-brands fa-facebook-f"></i>
                                                <span class="visually-hidden">Facebook</span>
                                            </a>
                                        </li>

                                        <!-- Twitter -->
                                        <li class="quickview__social--list">
                                            <a class="quickview__social--icon" target="_blank"
                                                href="https://twitter.com/intent/tweet?url={{ $currentUrl }}&text={{ $title }}">
                                                <i class="fa-brands fa-twitter"></i>
                                                <span class="visually-hidden">Twitter</span>
                                            </a>
                                        </li>

                                        <!-- WhatsApp -->
                                        <li class="quickview__social--list">
                                            <a class="quickview__social--icon" target="_blank"
                                                href="https://api.whatsapp.com/send?text={{ $title }}%20{{ $currentUrl }}">
                                                <i class="fa-brands fa-whatsapp"></i>
                                                <span class="visually-hidden">WhatsApp</span>
                                            </a>
                                        </li>

                                        <!-- LinkedIn -->
                                        <li class="quickview__social--list">
                                            <a class="quickview__social--icon" target="_blank"
                                                href="https://www.linkedin.com/sharing/share-offsite/?url={{ $currentUrl }}">
                                                <i class="fa-brands fa-linkedin-in"></i>
                                                <span class="visually-hidden">LinkedIn</span>
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
        </section>
        <!-- End product details section -->

        <!-- Start product details tab section -->
        <section class="product__details--tab__section section--padding">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <ul class="product__details--tab d-flex mb-30">
                            <li class="product__details--tab__list active" data-toggle="tab"
                                data-target="#description">
                                Description</li>
                            <li class="product__details--tab__list" data-toggle="tab" data-target="#reviews">Product
                                Reviews</li>
                        </ul>
                        <div class="product__details--tab__inner border-radius-10">
                            <div class="tab_content">
                                <div id="description" class="tab_pane active show">
                                    <div class="product__tab--content">
                                        <div class="product__tab--content__step mb-30">
                                            <h2 class="product__tab--content__title h4 mb-10">
                                                {{ $productDetail->name ?? '' }}</h2>
                                            <p class="product__tab--content__desc">
                                                {!! $productDetail->long_description ?? 'Long description of the product goes here.' !!}
                                            </p>
                                        </div>

                                    </div>
                                </div>
                                <div id="reviews" class="tab_pane">
                                    <div class="product__reviews">
                                        <div class="product__reviews--header">
                                            <h2 class="product__reviews--header__title h3 mb-20">Customer Reviews</h2>
                                            <div class="reviews__ratting d-flex align-items-center">
                                                <ul class="rating d-flex">
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
                                                <span class="reviews__summary--caption">Based on 2 reviews</span>
                                            </div>
                                            <a class="actions__newreviews--btn primary__btn" href="#writereview">Write
                                                A
                                                Review</a>
                                        </div>
                                        <div class="reviews__comment--area">
                                            <div class="reviews__comment--list d-flex">
                                                <div class="reviews__comment--thumb">
                                                    <img src="{{ asset('frontend') }}/assets/img/other/comment-thumb1.png"
                                                        alt="comment-thumb">
                                                </div>
                                                <div class="reviews__comment--content">
                                                    <div class="reviews__comment--top d-flex justify-content-between">
                                                        <div class="reviews__comment--top__left">
                                                            <h3 class="reviews__comment--content__title h4">Richard
                                                                Smith</h3>
                                                            <ul class="rating reviews__comment--rating d-flex">
                                                                <li class="rating__list">
                                                                    <span class="rating__list--icon">
                                                                        <svg class="rating__list--icon__svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14.105" height="14.732"
                                                                            viewBox="0 0 10.105 9.732">
                                                                            <path data-name="star - Copy"
                                                                                d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                                transform="translate(0 -0.018)"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </li>
                                                                <li class="rating__list">
                                                                    <span class="rating__list--icon">
                                                                        <svg class="rating__list--icon__svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14.105" height="14.732"
                                                                            viewBox="0 0 10.105 9.732">
                                                                            <path data-name="star - Copy"
                                                                                d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                                transform="translate(0 -0.018)"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </li>
                                                                <li class="rating__list">
                                                                    <span class="rating__list--icon">
                                                                        <svg class="rating__list--icon__svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14.105" height="14.732"
                                                                            viewBox="0 0 10.105 9.732">
                                                                            <path data-name="star - Copy"
                                                                                d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                                transform="translate(0 -0.018)"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </li>
                                                                <li class="rating__list">
                                                                    <span class="rating__list--icon">
                                                                        <svg class="rating__list--icon__svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14.105" height="14.732"
                                                                            viewBox="0 0 10.105 9.732">
                                                                            <path data-name="star - Copy"
                                                                                d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                                transform="translate(0 -0.018)"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </li>
                                                                <li class="rating__list">
                                                                    <span class="rating__list--icon">
                                                                        <svg class="rating__list--icon__svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14.105" height="14.732"
                                                                            viewBox="0 0 10.105 9.732">
                                                                            <path data-name="star - Copy"
                                                                                d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                                transform="translate(0 -0.018)"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <span class="reviews__comment--content__date">February 18,
                                                            2022</span>
                                                    </div>
                                                    <p class="reviews__comment--content__desc">Lorem ipsum, dolor sit
                                                        amet consectetur adipisicing elit. Eos ex repellat officiis
                                                        neque. Veniam, rem nesciunt. Assumenda distinctio, autem error
                                                        repellat eveniet ratione dolor facilis accusantium amet
                                                        pariatur, non eius!</p>
                                                </div>
                                            </div>
                                            <div class="reviews__comment--list margin__left d-flex">
                                                <div class="reviews__comment--thumb">
                                                    <img src="{{ asset('frontend') }}/assets/img/other/comment-thumb2.png"
                                                        alt="comment-thumb">
                                                </div>
                                                <div class="reviews__comment--content">
                                                    <div class="reviews__comment--top d-flex justify-content-between">
                                                        <div class="reviews__comment--top__left">
                                                            <h3 class="reviews__comment--content__title h4">Laura
                                                                Johnson</h3>
                                                            <ul class="rating reviews__comment--rating d-flex">
                                                                <li class="rating__list">
                                                                    <span class="rating__list--icon">
                                                                        <svg class="rating__list--icon__svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14.105" height="14.732"
                                                                            viewBox="0 0 10.105 9.732">
                                                                            <path data-name="star - Copy"
                                                                                d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                                transform="translate(0 -0.018)"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </li>
                                                                <li class="rating__list">
                                                                    <span class="rating__list--icon">
                                                                        <svg class="rating__list--icon__svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14.105" height="14.732"
                                                                            viewBox="0 0 10.105 9.732">
                                                                            <path data-name="star - Copy"
                                                                                d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                                transform="translate(0 -0.018)"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </li>
                                                                <li class="rating__list">
                                                                    <span class="rating__list--icon">
                                                                        <svg class="rating__list--icon__svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14.105" height="14.732"
                                                                            viewBox="0 0 10.105 9.732">
                                                                            <path data-name="star - Copy"
                                                                                d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                                transform="translate(0 -0.018)"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </li>
                                                                <li class="rating__list">
                                                                    <span class="rating__list--icon">
                                                                        <svg class="rating__list--icon__svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14.105" height="14.732"
                                                                            viewBox="0 0 10.105 9.732">
                                                                            <path data-name="star - Copy"
                                                                                d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                                transform="translate(0 -0.018)"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </li>
                                                                <li class="rating__list">
                                                                    <span class="rating__list--icon">
                                                                        <svg class="rating__list--icon__svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14.105" height="14.732"
                                                                            viewBox="0 0 10.105 9.732">
                                                                            <path data-name="star - Copy"
                                                                                d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                                transform="translate(0 -0.018)"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <span class="reviews__comment--content__date">February 18,
                                                            2022</span>
                                                    </div>
                                                    <p class="reviews__comment--content__desc">Lorem ipsum, dolor sit
                                                        amet consectetur adipisicing elit. Eos ex repellat officiis
                                                        neque. Veniam, rem nesciunt. Assumenda distinctio, autem error
                                                        repellat eveniet ratione dolor facilis accusantium amet
                                                        pariatur, non eius!</p>
                                                </div>
                                            </div>
                                            <div class="reviews__comment--list d-flex">
                                                <div class="reviews__comment--thumb">
                                                    <img src="{{ asset('frontend') }}/assets/img/other/comment-thumb3.png"
                                                        alt="comment-thumb">
                                                </div>
                                                <div class="reviews__comment--content">
                                                    <div class="reviews__comment--top d-flex justify-content-between">
                                                        <div class="reviews__comment--top__left">
                                                            <h3 class="reviews__comment--content__title h4">John Deo
                                                            </h3>
                                                            <ul class="rating reviews__comment--rating d-flex">
                                                                <li class="rating__list">
                                                                    <span class="rating__list--icon">
                                                                        <svg class="rating__list--icon__svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14.105" height="14.732"
                                                                            viewBox="0 0 10.105 9.732">
                                                                            <path data-name="star - Copy"
                                                                                d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                                transform="translate(0 -0.018)"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </li>
                                                                <li class="rating__list">
                                                                    <span class="rating__list--icon">
                                                                        <svg class="rating__list--icon__svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14.105" height="14.732"
                                                                            viewBox="0 0 10.105 9.732">
                                                                            <path data-name="star - Copy"
                                                                                d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                                transform="translate(0 -0.018)"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </li>
                                                                <li class="rating__list">
                                                                    <span class="rating__list--icon">
                                                                        <svg class="rating__list--icon__svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14.105" height="14.732"
                                                                            viewBox="0 0 10.105 9.732">
                                                                            <path data-name="star - Copy"
                                                                                d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                                transform="translate(0 -0.018)"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </li>
                                                                <li class="rating__list">
                                                                    <span class="rating__list--icon">
                                                                        <svg class="rating__list--icon__svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14.105" height="14.732"
                                                                            viewBox="0 0 10.105 9.732">
                                                                            <path data-name="star - Copy"
                                                                                d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                                transform="translate(0 -0.018)"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </li>
                                                                <li class="rating__list">
                                                                    <span class="rating__list--icon">
                                                                        <svg class="rating__list--icon__svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14.105" height="14.732"
                                                                            viewBox="0 0 10.105 9.732">
                                                                            <path data-name="star - Copy"
                                                                                d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                                transform="translate(0 -0.018)"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <span class="reviews__comment--content__date">February 18,
                                                            2022</span>
                                                    </div>
                                                    <p class="reviews__comment--content__desc">Lorem ipsum, dolor sit
                                                        amet consectetur adipisicing elit. Eos ex repellat officiis
                                                        neque. Veniam, rem nesciunt. Assumenda distinctio, autem error
                                                        repellat eveniet ratione dolor facilis accusantium amet
                                                        pariatur, non eius!</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="writereview" class="reviews__comment--reply__area">
                                            <form action="#">
                                                <h3 class="reviews__comment--reply__title mb-15">Add a review </h3>
                                                <div class="reviews__ratting d-flex align-items-center mb-20">
                                                    <ul class="rating d-flex">
                                                        <li class="rating__list">
                                                            <span class="rating__list--icon">
                                                                <svg class="rating__list--icon__svg"
                                                                    xmlns="http://www.w3.org/2000/svg" width="14.105"
                                                                    height="14.732" viewBox="0 0 10.105 9.732">
                                                                    <path data-name="star - Copy"
                                                                        d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                        transform="translate(0 -0.018)"
                                                                        fill="currentColor"></path>
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
                                                                        fill="currentColor"></path>
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
                                                                        fill="currentColor"></path>
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
                                                                        fill="currentColor"></path>
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
                                                                        fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 mb-10">
                                                        <textarea class="reviews__comment--reply__textarea" placeholder="Your Comments...."></textarea>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 mb-15">
                                                        <label>
                                                            <input class="reviews__comment--reply__input"
                                                                placeholder="Your Name...." type="text">
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 mb-15">
                                                        <label>
                                                            <input class="reviews__comment--reply__input"
                                                                placeholder="Your Email...." type="email">
                                                        </label>
                                                    </div>
                                                </div>
                                                <button class="reviews__comment--btn text-white primary__btn"
                                                    data-hover="Submit" type="submit">SUBMIT</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End product details tab section -->

        <!-- Start product section -->
        <section class="product__section product__section--style3 section--padding">
            <div class="container product3__section--container">
                <div class="section__heading text-center mb-50">
                    <h2 class="section__heading--maintitle">You may also like</h2>
                </div>
                <div class="product__section--inner product__swiper--column4__activation swiper">
                    <div class="swiper-wrapper">

                        @foreach ($relatedProducts as $key => $product)
                            <div class="swiper-slide">
                                <div class="product__items">
                                    <div class="product__items--thumbnail">
                                        <a class="product__items--link"
                                            href="{{ route('product.details', ['slug' => $product->slug]) }}">

                                            <img class="product__items--img product__primary--img"
                                                src="{{ $product->primaryImage ? asset($product->primaryImage->path) : asset('frontend/assets/img/product/product3.png') }}"
                                                alt="{{ $product->name }}" />

                                            @php
                                                $secondary = $product->images->where('is_primary', 0)->first();
                                            @endphp

                                            <img class="product__items--img product__secondary--img"
                                                src="{{ $secondary ? asset($secondary->path) : asset('frontend/assets/img/product/product4.png') }}"
                                                alt="{{ $product->name }}" />
                                        </a>

                                        @if ($product->discount_value)
                                            <div class="product__badge">
                                                <span class="product__badge--items sale">Sale</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="product__items--content">
                                        <span class="product__items--content__subtitle">
                                            {{ $product->category->name ?? '' }}
                                            @if ($product->brand)
                                                , {{ $product->brand->name }}
                                            @endif
                                        </span>
                                        <h3 class="product__items--content__title h4">
                                            <a
                                                href="{{ route('product.details', ['slug' => $product->slug]) }}">{{ $product->name ?? '' }}</a>
                                        </h3>
                                        @php
                                            $finalPrice = $product->base_price;

                                            if ($product->discount_type == 'percent') {
                                                $finalPrice -= ($product->base_price * $product->discount_value) / 100;
                                            }

                                            if ($product->discount_type == 'fixed') {
                                                $finalPrice -= $product->discount_value;
                                            }
                                        @endphp
                                        <div class="product__items--price">
                                            <span class="current__price">৳{{ number_format($finalPrice, 2) }}</span>

                                            @if ($product->discount_value)
                                                <span class="price__divided"></span>
                                                <span
                                                    class="old__price">৳{{ number_format($product->base_price, 2) }}</span>
                                            @endif
                                        </div>
                                        <ul class="rating product__rating d-flex">
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
                                                            transform="translate(0 -0.018)" fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </li>
                                        </ul>
                                        <ul class="product__items--action d-flex">
                                            <li class="product__items--action__list">
                                                <a href="javascript:void(0)"
                                                    class="product__items--action__btn add-to-cart-btn"
                                                    data-id="{{ $product->id }}">
                                                    <svg class=" product__items--action__btn--svg"
                                                        xmlns="http://www.w3.org/2000/svg" width="22.51"
                                                        height="20.443" viewBox="0 0 14.706 13.534">
                                                        <g transform="translate(0 0)">
                                                            <g>
                                                                <path data-name="Path 16787"
                                                                    d="M4.738,472.271h7.814a.434.434,0,0,0,.414-.328l1.723-6.316a.466.466,0,0,0-.071-.4.424.424,0,0,0-.344-.179H3.745L3.437,463.6a.435.435,0,0,0-.421-.353H.431a.451.451,0,0,0,0,.9h2.24c.054.257,1.474,6.946,1.555,7.33a1.36,1.36,0,0,0-.779,1.242,1.326,1.326,0,0,0,1.293,1.354h7.812a.452.452,0,0,0,0-.9H4.74a.451.451,0,0,1,0-.9Zm8.966-6.317-1.477,5.414H5.085l-1.149-5.414Z"
                                                                    transform="translate(0 -463.248)"
                                                                    fill="currentColor">
                                                                </path>
                                                                <path data-name="Path 16788"
                                                                    d="M5.5,478.8a1.294,1.294,0,1,0,1.293-1.353A1.325,1.325,0,0,0,5.5,478.8Zm1.293-.451a.452.452,0,1,1-.431.451A.442.442,0,0,1,6.793,478.352Z"
                                                                    transform="translate(-1.191 -466.622)"
                                                                    fill="currentColor">
                                                                </path>
                                                                <path data-name="Path 16789"
                                                                    d="M13.273,478.8a1.294,1.294,0,1,0,1.293-1.353A1.325,1.325,0,0,0,13.273,478.8Zm1.293-.451a.452.452,0,1,1-.431.451A.442.442,0,0,1,14.566,478.352Z"
                                                                    transform="translate(-2.875 -466.622)"
                                                                    fill="currentColor">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                    <span class="add__to--cart__text">
                                                        + Add to cart</span>
                                                </a>

                                            </li>
                                            <li class="product__items--action__list">
                                                <a class="product__items--action__btn add-to-wishlist"
                                                    href="javascript:void(0)" data-id="{{ $product->id }}">
                                                    <svg class="product__items--action__btn--svg"
                                                        xmlns="http://www.w3.org/2000/svg" width="25.51"
                                                        height="23.443" viewBox="0 0 512 512">
                                                        <path
                                                            d="M352.92 80C288 80 256 144 256 144s-32-64-96.92-64c-52.76 0-94.54 44.14-95.08 96.81-1.1 109.33 86.73 187.08 183 252.42a16 16 0 0018 0c96.26-65.34 184.09-143.09 183-252.42-.54-52.67-42.32-96.81-95.08-96.81z"
                                                            fill="none" stroke="currentColor"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="32"></path>
                                                    </svg>
                                                    <span class="visually-hidden">Wishlist</span>
                                                </a>
                                            </li>
                                            <li class="product__items--action__list">
                                                <a class="product__items--action__btn" data-open="modal1"
                                                    href="javascript:void(0)">
                                                    <svg class="product__items--action__btn--svg"
                                                        xmlns="http://www.w3.org/2000/svg" width="25.51"
                                                        height="23.443" viewBox="0 0 512 512">
                                                        <path
                                                            d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z"
                                                            fill="none" stroke="currentColor"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="32" />
                                                        <circle cx="256" cy="256" r="80" fill="none"
                                                            stroke="currentColor" stroke-miterlimit="10"
                                                            stroke-width="32" />
                                                    </svg>
                                                    <span class="visually-hidden">Quick View</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="swiper__nav--btn swiper-button-next"></div>
                    <div class="swiper__nav--btn swiper-button-prev"></div>
                </div>
            </div>
        </section>
        <!-- End product section -->

        <!-- Start shipping section -->
        <section class="shipping__section2 shipping__style3 section--padding pt-0">
            <div class="container">
                <div class="shipping__section2--inner shipping__style3--inner d-flex justify-content-between">
                    <div class="shipping__items2 d-flex align-items-center">
                        <div class="shipping__items2--icon">
                            <img src="{{ asset('frontend') }}/assets/img/other/shipping1.png" alt="">
                        </div>
                        <div class="shipping__items2--content">
                            <h2 class="shipping__items2--content__title h3">Shipping</h2>
                            <p class="shipping__items2--content__desc">From handpicked sellers</p>
                        </div>
                    </div>
                    <div class="shipping__items2 d-flex align-items-center">
                        <div class="shipping__items2--icon">
                            <img src="{{ asset('frontend') }}/assets/img/other/shipping2.png" alt="">
                        </div>
                        <div class="shipping__items2--content">
                            <h2 class="shipping__items2--content__title h3">Payment</h2>
                            <p class="shipping__items2--content__desc">From handpicked sellers</p>
                        </div>
                    </div>
                    <div class="shipping__items2 d-flex align-items-center">
                        <div class="shipping__items2--icon">
                            <img src="{{ asset('frontend') }}/assets/img/other/shipping3.png" alt="">
                        </div>
                        <div class="shipping__items2--content">
                            <h2 class="shipping__items2--content__title h3">Return</h2>
                            <p class="shipping__items2--content__desc">From handpicked sellers</p>
                        </div>
                    </div>
                    <div class="shipping__items2 d-flex align-items-center">
                        <div class="shipping__items2--icon">
                            <img src="{{ asset('frontend') }}/assets/img/other/shipping4.png" alt="">
                        </div>
                        <div class="shipping__items2--content">
                            <h2 class="shipping__items2--content__title h3">Support</h2>
                            <p class="shipping__items2--content__desc">From handpicked sellers</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End shipping section -->
    </main>

    @include('website.layouts.inc.footer')


    <!-- Scroll top bar -->
    @include('website.layouts.inc.script')

    <script>
        $(document).ready(function() {

            // Quantity increase/decrease
            $(document).on('click', '.increase, .decrease', function() {

                let input = $(this).closest('.quantity__box').find('.quantity__number');
                let qty = parseInt(input.val());

                if ($(this).hasClass('increase')) {
                    qty++;
                } else {
                    qty = Math.max(1, qty - 1);
                }

                input.val(qty);
            });


            // Add to cart from product details
            $(document).on('click', '.add-to-cart-details', function(e) {

                e.preventDefault();

                let button = $(this);
                let productId = button.data('id');
                let qty = $('.quickview__value--number').val();
                let variantId = $('#selectedVariantId').val() || null;

                $.ajax({
                    url: "{{ route('addToCart') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: productId,
                        variant_id: variantId,
                        order_qty: qty
                    },
                    beforeSend: function() {
                        button.addClass('loading');
                    },
                    success: function(response) {

                        $('.cart_count').text(response.itemCount);

                        $('#mini-cart-container').html(response.mini_cart_html);

                        $('.offCanvas__minicart').addClass('active');

                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Error!');
                    },
                    complete: function() {
                        button.removeClass('loading');
                    }
                });

            });

        });
    </script>


</body>

</html>
