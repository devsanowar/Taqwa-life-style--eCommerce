<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('frontend/assets/js/vendor/popper.js') }}" defer="defer"></script>
<script src="{{ asset('frontend/assets/js/vendor/bootstrap.min.js') }}" defer="defer"></script>
<script src="{{ asset('frontend/assets/js/plugins/swiper-bundle.min.js') }}" defer="defer"></script>
<script src="{{ asset('frontend/assets/js/plugins/glightbox.min.js') }}" defer="defer"></script>

<script src="{{ asset('frontend/assets/js/script.js') }}" defer="defer"></script>

    <script src="{{ asset('frontend') }}/js/toastr.min.js"></script>


    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif

        @if (session('info'))
            toastr.info("{{ session('info') }}");
        @endif
    </script>

<script>
    $(document).on('click', '.add-to-cart-btn', function(e) {
    e.preventDefault();

    let button = $(this);
    let productId = button.data('id');
    let variantId = $('#selectedVariantId').val() || null;

    $.ajax({
        url: "{{ route('addToCart') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            product_id: productId,
            variant_id: variantId,
            order_qty: 1
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
</script>

<script>
    // Increase / Decrease
$(document).on('click', '.increase, .decrease', function() {

    let key = $(this).data('key');
    let parent = $(this).closest('.minicart__product--items');
    let input = parent.find('.quantity__number');
    let qty = parseInt(input.val());

    if ($(this).hasClass('increase')) {
        qty++;
    } else {
        qty = Math.max(1, qty - 1);
    }

    updateCartQty(key, qty);
});

// Remove item
$(document).on('click', '.minicart__product--remove', function() {

    let key = $(this).data('key');

    $.ajax({
        url: "{{ route('cart.removeItem') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            cart_key: key
        },
        success: function(response) {

            $('.cart_count').text(response.itemCount);
            $('#mini-cart-container').html(response.mini_cart_html);
        }
    });
});

// Update qty function
function updateCartQty(key, qty) {

    $.ajax({
        url: "{{ route('cart.updateQty') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            cart_key: key,
            qty: qty
        },
        success: function(response) {

            $('.cart_count').text(response.itemCount);
            $('#mini-cart-container').html(response.mini_cart_html);
        }
    });
}
</script>

<script>
        $(document).on('click', '.add-to-wishlist', function(e) {

            e.preventDefault();

            let button = $(this);
            let productId = button.data('id');

            $.ajax({
                url: "{{ route('addToWishlist') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId
                },
                success: function(response) {

                    $('.wishlist_count').text(response.wishlistCount);

                    if (response.added) {
                        button.addClass('active');
                    } else {
                        button.removeClass('active');
                    }

                    toastr.success(response.message);
                }
            });
        });
    </script>

@stack('scripts')
