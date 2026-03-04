<div class="shop__sidebar--widget widget__area d-none d-lg-block">
    <div class="single__widget widget__bg">
        <h2 class="widget__title h3">Categories</h2>

        <ul class="widget__categories--menu">
           @foreach($categories as $category)
            @if(is_null($category->parent_id))
            @include('website.layouts.pages.shop.partials.category_item', ['category' => $category])
            @endif
            @endforeach
        </ul>
    </div>


    <div class="single__widget price__filter widget__bg">
        <h2 class="widget__title h3">Filter By Price</h2>
        <form class="price__filter--form" action="#" id="priceFilterForm">
            <div class="price__filter--form__inner mb-15 d-flex align-items-center">
                <div class="price__filter--group">
                    <label class="price__filter--label" for="Filter-Price-GTE2">From</label>
                    <div class="price__filter--input border-radius-5 d-flex align-items-center">
                        <span class="price__filter--currency">$</span>
                        <label>
                            <input class="price__filter--input__field border-0" name="min_price" type="number"
                                placeholder="0" min="0" max="10000.00">
                        </label>
                    </div>
                </div>
                <div class="price__divider">
                    <span>-</span>
                </div>
                <div class="price__filter--group">
                    <label class="price__filter--label" for="Filter-Price-LTE2">To</label>
                    <div class="price__filter--input border-radius-5 d-flex align-items-center">
                        <span class="price__filter--currency">$</span>
                        <label>
                            <input class="price__filter--input__field border-0" name="max_price" type="number"
                                min="0" placeholder="10000.00" max="10000.00">
                        </label>
                    </div>
                </div>
            </div>
            <button class="price__filter--btn primary__btn" type="submit">Filter</button>
        </form>
    </div>
    <div class="single__widget widget__bg">
    <h2 class="widget__title h3">Recent Products</h2>

    <div class="product__grid--inner">
        @foreach ($recentProducts as $product)
            @php
                $primaryPath = $product->primaryImage?->path
                    ?? optional($product->images->firstWhere('is_primary', 1))->path;

                $secondaryPath = optional($product->images->firstWhere('is_primary', 0))->path
                    ?? $primaryPath;

                // DB-তে যদি "public/uploads/..." থাকে, asset() এর জন্য "public/" কেটে দিন
                $primaryPath = $primaryPath ? ltrim(preg_replace('#^public/#', '', $primaryPath), '/') : null;
                $secondaryPath = $secondaryPath ? ltrim(preg_replace('#^public/#', '', $secondaryPath), '/') : null;

                $primaryUrl = $primaryPath ? asset($primaryPath) : asset('frontend/assets/img/product/default.png');
                $secondaryUrl = $secondaryPath ? asset($secondaryPath) : $primaryUrl;

                $final = (float) $product->final_price;
                $base  = (float) $product->base_price;
                $hasDiscount = $final < $base;
            @endphp

            <div class="product__items product__items--grid d-flex align-items-center">
                <div class="product__items--grid__thumbnail position__relative">
                    <a class="product__items--link" href="{{ url('/product/' . $product->slug) }}">
                        <img class="product__items--img product__primary--img" src="{{ $primaryUrl }}" alt="product-img">
                        <img class="product__items--img product__secondary--img" src="{{ $secondaryUrl }}" alt="product-img">
                    </a>
                </div>

                <div class="product__items--grid__content">
                    <h3 class="product__items--content__title h4">
                        <a href="{{ url('/product-details/' . $product->slug) }}">{{ $product->name }}</a>
                    </h3>

                    <div class="product__items--price">
                        <span class="current__price">৳{{ number_format($final, 2) }}</span>
                        @if ($hasDiscount)
                            <span class="price__divided"></span>
                            <span class="old__price">৳{{ number_format($base, 2) }}</span>
                        @endif
                    </div>

                    {{-- আপনার existing rating SVG block এখানে 그대로 রাখতে পারেন --}}
                </div>
            </div>
        @endforeach
    </div>
</div>

    <div class="single__widget widget__bg">
        <h2 class="widget__title h3">Brands</h2>
        <ul class="widget__tagcloud">
            <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="#">Jacket</a></li>
            <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="#">Women</a></li>
            <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="#">Oversize</a></li>
            <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="#">Cotton </a></li>
            <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="#">Shoulder </a></li>
            <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="#">Winter</a></li>
            <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="#">Accessories</a>
            </li>
            <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="#">Dress </a></li>
        </ul>
    </div>
</div>
