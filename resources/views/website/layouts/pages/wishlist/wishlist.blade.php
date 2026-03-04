@extends('website.layouts.app')
@section('title', 'Wishlist')
@section('page_id', 'wishlist_page')
@section('website_content')
    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Wishlist</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Wishlist</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- cart section start -->
        <section class="cart__section section--padding">
            <div class="container">
                <div class="cart__section--inner">
                    <form action="#">
                        <h2 class="cart__title mb-40">Wishlist</h2>
                        <div class="cart__table">
                            <table class="cart__table--inner">
                                <thead class="cart__table--header">
                                    <tr class="cart__table--header__items">
                                        <th class="cart__table--header__list">Product</th>
                                        <th class="cart__table--header__list">Price</th>
                                        <th class="cart__table--header__list text-center">STOCK STATUS</th>
                                        <th class="cart__table--header__list text-right">ADD TO CART</th>
                                    </tr>
                                </thead>
                                <tbody class="cart__table--body">

                                    @forelse($wishlist as $item)
                                        <tr class="cart__table--body__items" data-id="{{ $item['product_id'] }}">

                                            <td class="cart__table--body__list">
                                                <div class="cart__product d-flex align-items-center">

                                                    <!-- Remove Button -->
                                                    <button class="cart__remove--btn remove-wishlist-item" type="button"
                                                        data-id="{{ $item['product_id'] }}">

                                                        <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24" width="16px" height="16px">
                                                            <path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12
                                        L 3.2929688 19.292969 L 4.7070312 20.707031
                                        L 12 13.414062 L 19.292969 20.707031
                                        L 20.707031 19.292969 L 13.414062 12
                                        L 20.707031 4.7070312 L 19.292969 3.2929688
                                        L 12 10.585938 Z" />
                                                        </svg>
                                                    </button>

                                                    <div class="cart__thumbnail">
                                                        <a href="{{ route('product.details', $item['slug']) }}">
                                                            <img class="border-radius-5" src="{{ asset($item['image']) }}"
                                                                alt="{{ $item['name'] }}">
                                                        </a>
                                                    </div>

                                                    <div class="cart__content">
                                                        <h4 class="cart__content--title">
                                                            <a href="{{ route('product.details', $item['slug']) }}">
                                                                {{ $item['name'] }}
                                                            </a>
                                                        </h4>

                                                        @if(!empty($item['attributes']))
                                                            @foreach($item['attributes'] as $attr => $vals)
                                                                @foreach($vals as $val)
                                                                    <span class="cart__content--variant">
                                                                        {{ strtoupper($attr) }}: {{ $val['value'] ?? $val }}
                                                                    </span>
                                                                @endforeach
                                                            @endforeach
                                                        @endif

                                                    </div>

                                                </div>
                                            </td>

                                            <td class="cart__table--body__list">
                                                <span class="cart__price">
                                                    ৳{{ number_format($item['price'], 2) }}
                                                </span>
                                            </td>

                                            <td class="cart__table--body__list text-center">
                                                <span class="in__stock text__secondary">
                                                    In Stock
                                                </span>
                                            </td>

                                            <td class="cart__table--body__list text-right">
                                                <a href="javascript:void(0)" class="product__items--action__btn add-to-cart-btn"
                                        data-id="{{ $item['product_id'] }}" style="background: var(--secondary-color); color:#fff; padding:0px 15px">
                                                  <i class="fa-solid fa-cart-arrow-down"></i>  +Add To Cart
                                                </a>
                                            </td>

                                        </tr>

                                    @empty

                                        <tr>
                                            <td colspan="4" class="text-center">
                                                Your wishlist is empty
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                            <div class="continue__shopping d-flex justify-content-between">
                                <a class="continue__shopping--link" href="index.html">Continue shopping</a>
                                <a class="continue__shopping--clear" href="shop.html">View All Products</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- cart section end -->

        <!-- Start product section -->
        {{-- @include('website.layouts.pages.home.featured-product') --}}


    </main>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.remove-wishlist-item', function() {

            let button = $(this);
            let productId = button.data('id');

            $.post("{{ route('addToWishlist') }}", {
                _token: "{{ csrf_token() }}",
                product_id: productId
            }, function(response) {

                button.closest('tr').remove();

                $('.wishlist_count').text(response.wishlistCount);

                toastr.success(response.message);

                if (response.wishlistCount == 0) {
                    location.reload();
                }
            });

        });
    </script>

@endpush
