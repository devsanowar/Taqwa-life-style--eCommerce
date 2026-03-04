@extends('website.layouts.app')
@section('title', 'Cart Page')
@section('page_id', 'cart_page')
@section('website_content')
<main class="main__content_wrapper">

    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">Shopping Cart</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="index.html">Home</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">Shopping Cart</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- cart section start -->
    <section class="cart__section section--padding">
        <div class="container-fluid">
            <div class="cart__section--inner">
                <h2 class="cart__title mb-40">Shopping Cart</h2>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="cart__table">
                            <table class="cart__table--inner">
                                <thead class="cart__table--header">
                                    <tr class="cart__table--header__items">
                                        <th class="cart__table--header__list">Product</th>
                                        <th class="cart__table--header__list">Price</th>
                                        <th class="cart__table--header__list">Quantity</th>
                                        <th class="cart__table--header__list">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="cart__table--body">

                                    @php $subtotal = 0; @endphp

                                    @forelse($cart as $key => $item)
                                        @php
                                            $total = $item['price'] * $item['qty'];
                                            $subtotal += $total;
                                        @endphp
                                        <tr class="cart__table--body__items" data-key="{{ $key }}">
                                            <td class="cart__table--body__list">
                                                <div class="cart__product d-flex align-items-center">
                                                    <button class="cart__remove--btn remove-item" data-key="{{ $key }}" type="button">✕</button>
                                                    <div class="cart__thumbnail">
                                                        <img class="border-radius-5" src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}">
                                                    </div>
                                                    <div class="cart__content">
                                                        <h4 class="cart__content--title">{{ $item['name'] }}</h4>
                                                        @if(!empty($item['attributes']))
                                                            @foreach($item['attributes'] as $attr => $val)
                                                                <span class="cart__content--variant">{{ strtoupper($attr) }}: {{ $val }}</span>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="cart__table--body__list">
                                                <span class="cart__price" data-price="{{ $item['price'] }}">৳{{ number_format($item['price'],2) }}</span>
                                            </td>
                                            <td class="cart__table--body__list">
                                                <div class="quantity__box">
                                                    <button type="button" class="quantity__value decrease" data-key="{{ $key }}">-</button>
                                                    <input type="number" class="quantity__number" value="{{ $item['qty'] }}" readonly>
                                                    <button type="button" class="quantity__value increase" data-key="{{ $key }}">+</button>
                                                </div>
                                            </td>
                                            <td class="cart__table--body__list">
                                                <span class="cart__price row-total">৳{{ number_format($total,2) }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Cart is empty</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                            <div class="continue__shopping d-flex justify-content-between">
                                <a class="continue__shopping--link" href="shop.html">Continue shopping</a>
                                <button class="continue__shopping--clear" type="button" id="clear-cart">Clear Cart</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cart__summary border-radius-10">
                            <div class="cart__summary--total mb-20">
                                <table class="cart__summary--total__table">
                                    <tbody>
                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left">SUBTOTAL</td>
                                            <td class="cart__summary--amount text-right">৳<span id="cart-subtotal">{{ number_format($subtotal,2) }}</span></td>
                                        </tr>
                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left">GRAND TOTAL</td>
                                            <td class="cart__summary--amount text-right">৳<span id="cart-grand-total">{{ number_format($subtotal,2) }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart__summary--footer">
                                <p class="cart__summary--footer__desc">Shipping & taxes calculated at checkout</p>
                                <ul class="d-flex justify-content-between">
                                    <li><button class="cart__summary--footer__btn primary__btn" type="button">Update Cart</button></li>
                                    <li><a class="cart__summary--footer__btn primary__btn checkout" href="checkout.html">Check Out</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- cart section end -->

</main>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

    function updateCartUI(response, key, qty) {
        // Update row qty
        let row = $('tr[data-key="'+key+'"]');
        row.find('.quantity__number').val(qty);

        // Update row total
        let price = parseFloat(row.find('.cart__price').data('price'));
        row.find('.row-total').text('৳'+(price * qty).toFixed(2));

        // Update subtotal & grand total
        $('#cart-subtotal').text(response.subtotal);
        $('#cart-grand-total').text(response.subtotal);

        // Update mini cart count
        $('.cart_count').text(response.itemCount);
    }

    // Increase / Decrease quantity
    $(document).on('click', '.increase, .decrease', function() {
        let key = $(this).data('key');
        let row = $('tr[data-key="'+key+'"]');
        let qtyInput = row.find('.quantity__number');
        let qty = parseInt(qtyInput.val());

        if ($(this).hasClass('increase')) qty++;
        else qty = Math.max(1, qty - 1);

        $.post("{{ route('cart.updateQty') }}", {
            _token: "{{ csrf_token() }}",
            cart_key: key,
            qty: qty
        }, function(response) {
            updateCartUI(response, key, qty);
        });
    });

    // Remove item
    $(document).on('click', '.remove-item', function() {
        let key = $(this).data('key');

        $.post("{{ route('cart.removeItem') }}", {
            _token: "{{ csrf_token() }}",
            cart_key: key
        }, function(response) {
            $('tr[data-key="'+key+'"]').remove();

            // Update subtotal & grand total
            $('#cart-subtotal').text(response.subtotal);
            $('#cart-grand-total').text(response.subtotal);

            // Update mini cart count
            $('.cart_count').text(response.itemCount);

            // If cart empty
            if(Object.keys(response.cart).length === 0) {
                $('.cart__table--body').html('<tr><td colspan="4" class="text-center">Cart is empty</td></tr>');
            }
        });
    });

});
</script>
@endpush
