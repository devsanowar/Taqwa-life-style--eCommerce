<div class="shop__sidebar--widget widget__area">


    <div class="single__widget widget__bg">
        <h2 class="widget__title h3">Top Rated Product</h2>
        <div class="product__grid--inner">

            @foreach ($relatedProducts as $key => $product)
            <div class="product__items product__items--grid d-flex align-items-center">
                <div class="product__items--grid__thumbnail position__relative">
                    <a class="product__items--link" href="{{ route('product.details', $product->slug) }}">
                        @php
                        $primary = $product->primaryImage ?? $product->images->first();
                        $secondary = $product->images->where('id', '!=', $primary->id)->first();
                        @endphp

                        <img class="product__items--img product__primary--img"
                            src="{{ asset($primary->path ?? 'frontend/assets/img/product/small-product1.png') }}"
                            alt="product-img">
                        <img class="product__items--img product__secondary--img"
                            src="{{ asset($secondary->path ?? 'frontend/assets/img/product/small-product2.png') }}"
                            alt="product-img">
                    </a>
                </div>


                <div class="product__items--grid__content">
                    <h3 class="product__items--content__title h4"><a
                            href="{{ route('product.details', $product->slug) }}">{{ $product->name }}</a></h3>
                    @php
                    $basePrice = $productDetail->base_price;
                    $finalPrice = $basePrice;

                    if ($productDetail->discount_type && $productDetail->discount_value) {
                    if ($productDetail->discount_type == 'percent') {
                    $finalPrice = $basePrice - ($basePrice * $productDetail->discount_value) / 100;
                    } else {
                    $finalPrice = $basePrice - $productDetail->discount_value;
                    }
                    }
                    @endphp
                    <div class="product__items--price">
                        <span class="current__price">${{ number_format($finalPrice, 2) }}</span>

                        @if ($finalPrice < $basePrice) <span class="price__divided"></span>
                            <span class="old__price">${{ number_format($basePrice, 2) }}</span>
                            @endif
                    </div>
                    <ul class="rating product__rating d-flex">
                        <li class="rating__list">
                            <span class="rating__list--icon">
                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105"
                                    height="14.732" viewBox="0 0 10.105 9.732">
                                    <path data-name="star - Copy"
                                        d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                        transform="translate(0 -0.018)" fill="currentColor"></path>
                                </svg>
                            </span>
                        </li>
                        <li class="rating__list">
                            <span class="rating__list--icon">
                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105"
                                    height="14.732" viewBox="0 0 10.105 9.732">
                                    <path data-name="star - Copy"
                                        d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                        transform="translate(0 -0.018)" fill="currentColor"></path>
                                </svg>
                            </span>
                        </li>
                        <li class="rating__list">
                            <span class="rating__list--icon">
                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105"
                                    height="14.732" viewBox="0 0 10.105 9.732">
                                    <path data-name="star - Copy"
                                        d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                        transform="translate(0 -0.018)" fill="currentColor"></path>
                                </svg>
                            </span>
                        </li>
                        <li class="rating__list">
                            <span class="rating__list--icon">
                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105"
                                    height="14.732" viewBox="0 0 10.105 9.732">
                                    <path data-name="star - Copy"
                                        d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                        transform="translate(0 -0.018)" fill="currentColor"></path>
                                </svg>
                            </span>
                        </li>
                        <li class="rating__list">
                            <span class="rating__list--icon">
                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105"
                                    height="14.732" viewBox="0 0 10.105 9.732">
                                    <path data-name="star - Copy"
                                        d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                        transform="translate(0 -0.018)" fill="currentColor"></path>
                                </svg>
                            </span>
                        </li>
                    </ul>
                </div>

            </div>
            @endforeach
        </div>
    </div>

    <div class="single__widget widget__bg">
        <h2 class="widget__title h3">Categories</h2>
        <ul class="widget__categories--menu">
            @foreach($categories as $category)
            @if(is_null($category->parent_id))
            @include('website.layouts.pages.product-details.partials.category-recursive', ['category' => $category])
            @endif
            @endforeach
        </ul>
    </div>


    <div class="single__widget widget__bg">
        <h2 class="widget__title h3">Brands</h2>
        <ul class="widget__tagcloud">
            <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="shop.html">Jacket</a></li>
            <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="shop.html">Women</a></li>
            <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="shop.html">Oversize</a></li>
            <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="shop.html">Cotton </a></li>
            <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="shop.html">Shoulder </a></li>
            <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="shop.html">Winter</a></li>
            <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="shop.html">Accessories</a>
            </li>
            <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="shop.html">Dress </a></li>
        </ul>
    </div>
</div>
