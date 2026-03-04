@extends('website.layouts.app')
@section('title', 'Shop Page')
@section('page_id', 'shop_page')
@push('styles')
    <style>
        #shop_page .shop__sidebar--widget.widget__area .product__items--img {
            display: block;
            width: 100%;
            height: 100%;
        }

        .widget__categories--sub__menu {
            display: none;
            overflow: hidden;
            transition: height .25s ease;
            will-change: height;
        }
    </style>
@endpush
@section('website_content')
    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Shop Page</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Shop</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Start shop section -->
        <section class="shop__section section--padding">
            <div class="container-fluid">
                <div class="shop__header bg__gray--color d-flex align-items-center justify-content-between mb-30">
                    @include('website.layouts.pages.shop.partials.shop_header')
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-4">
                        @include('website.layouts.pages.shop.partials.shop_sidebar')
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        <div class="shop__product--wrapper">
                            <div class="tab_content">
                                <div id="product_grid" class="tab_pane active show">
                                    <div class="product__section--inner product__grid--inner">
                                        <div id="product-wrapper">

                                            <div id="product-list"
                                                class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-2 mb--n30">
                                                @include('website.layouts.pages.shop.partials.product_grid')
                                            </div>

                                            <div id="pagination-wrapper">
                                                @include('website.layouts.pages.shop.partials.pagination', [
                                                    'paginator' => $products,
                                                ])
                                            </div>

                                        </div>
                                    </div>
                                </div>



                                {{-- {{ $products->links('website.layouts.pages.shop.partials.pagination') }} --}}



                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End shop section -->

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
@endsection

@push('scripts')
    <script>
(function() {
    const DURATION = 250;

    const wrapper = document.getElementById('product-wrapper');
    const productList = document.getElementById('product-list');
    const paginationWrapper = document.getElementById('pagination-wrapper');
    const priceForm = document.getElementById('priceFilterForm'); // optional

    function slideDown(el) {
        el.style.removeProperty('display');
        let display = window.getComputedStyle(el).display;
        if (display === 'none') display = 'block';
        el.style.display = display;

        const height = el.scrollHeight;

        el.style.overflow = 'hidden';
        el.style.height = '0px';
        el.offsetHeight;
        el.style.transition = `height ${DURATION}ms ease`;
        el.style.height = height + 'px';

        window.setTimeout(() => {
            el.style.height = 'auto';
            el.style.overflow = '';
            el.style.transition = '';
        }, DURATION);
    }

    function slideUp(el) {
        el.style.height = el.scrollHeight + 'px';
        el.style.overflow = 'hidden';
        el.offsetHeight;
        el.style.transition = `height ${DURATION}ms ease`;
        el.style.height = '0px';

        window.setTimeout(() => {
            el.style.display = 'none';
            el.style.height = '';
            el.style.overflow = '';
            el.style.transition = '';
        }, DURATION);
    }

    function buildUrl(baseUrl) {
        const url = new URL(baseUrl, window.location.origin);

        const merged = new URLSearchParams(window.location.search);

        // keep page param from baseUrl (e.g. pagination links)
        const baseParams = new URLSearchParams(url.search);
        for (const [k, v] of baseParams.entries()) merged.set(k, v);

        // merge price form inputs
        if (priceForm) {
            const fd = new FormData(priceForm);
            for (const [k, v] of fd.entries()) {
                if (String(v).trim() !== '') merged.set(k, v);
                else merged.delete(k);
            }
        }

        url.search = merged.toString();
        return url.toString();
    }

    function load(url, push = true) {
        fetch(url, { headers: { "X-Requested-With": "XMLHttpRequest" } })
            .then(res => res.json())
            .then(data => {
                productList.innerHTML = data.products;
                paginationWrapper.innerHTML = data.pagination;

                if (wrapper) {
                    window.scrollTo({ top: wrapper.offsetTop - 100, behavior: 'smooth' });
                }

                if (push) history.pushState({}, '', url);
            });
    }

    // Toggle handler (capture)
    document.addEventListener('click', function(e) {
        const toggle = e.target.closest('.js-cat-toggle');
        if (!toggle) return;

        e.preventDefault();
        e.stopPropagation();
        // IMPORTANT: stopImmediatePropagation দিবেন না, এটা filter listener ব্লক করে [web:66][web:63]

        const li = toggle.closest('li');
        if (!li) return;

        const submenu = li.querySelector(':scope > ul.widget__categories--sub__menu');
        if (!submenu) return;

        const isOpen = window.getComputedStyle(submenu).display !== 'none';
        if (isOpen) slideUp(submenu);
        else slideDown(submenu);

    }, true);

    // Filter + Pagination handler (bubble)
    document.addEventListener('click', function(e) {
        if (e.target.closest('.js-cat-toggle')) return;

        const cat = e.target.closest('.js-category-filter');
        const page = e.target.closest('#pagination-wrapper a');

        if (!cat && !page) return;

        e.preventDefault();

        const href = cat ? cat.getAttribute('href') : page.getAttribute('href');
        const targetUrl = buildUrl(href);

        load(targetUrl, true);
    });

    // Price form submit (optional)
    if (priceForm) {
        priceForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const targetUrl = buildUrl("{{ route('shop.page') }}");
            load(targetUrl, true);
        });
    }

    // Back/forward
    window.addEventListener('popstate', function() {
        load(window.location.href, false);
    });

})();
</script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const form = document.getElementById("priceFilterForm");
            const wrapper = document.getElementById("product-wrapper");
            const paginationWrapper = document.getElementById("pagination-wrapper");

            form.addEventListener("submit", function(e) {
                e.preventDefault();

                let formData = new FormData(form);
                let params = new URLSearchParams(formData).toString();

                fetch("{{ route('shop.page') }}?" + params, {
                        headers: {
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        // Wrap products in row div to keep grid layout
                        wrapper.innerHTML = `<div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-2 mb--n30">
                ${data.products}
            </div>`;

                        paginationWrapper.innerHTML = data.pagination;

                        window.scrollTo({
                            top: wrapper.offsetTop - 100,
                            behavior: 'smooth'
                        });
                    });
            });

        });
    </script>

    <script>
        $(document).on('click', '#filter-button, #pagination-wrapper a', function(e) {
            e.preventDefault();

            let url = $(this).attr('href') || $('#filter-form').attr('action');
            let data = $('#filter-form').serialize();

            $.ajax({
                url: url,
                type: 'GET',
                data: data,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#product-list').html(response.products);
                    $('#pagination-wrapper').html(response.pagination);

                    $('html, body').animate({
                        scrollTop: $('#product-wrapper').offset().top - 100
                    }, 300);
                }
            });
        });
    </script>
@endpush
