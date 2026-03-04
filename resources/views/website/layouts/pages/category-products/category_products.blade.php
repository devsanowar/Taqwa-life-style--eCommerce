@extends('website.layouts.app')
@section('title', 'Category Products')
@section('page_id', 'category_products_page')
@push('styles')
    <style>
        #category_products_page .shop__sidebar--widget.widget__area .product__items--img {
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
                                <li class="breadcrumb__content--menu__items"><a class="text-white"
                                        href="{{ route('home') }}">Home</a>
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
                    {{-- @include('website.layouts.pages.shop.partials.shop_header') --}}
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-4">
                        <div class="shop__sidebar--widget widget__area d-none d-lg-block">
                            <div class="single__widget widget__bg">
                                <h2 class="widget__title h3">Categories</h2>

                                <ul class="widget__categories--menu">
                                    @foreach ($categories as $category)
                                        @if (is_null($category->parent_id))
                                            @include('website.layouts.pages.category-products.partials.category_item', [
                                                'category' => $category,
                                            ])
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
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
                                                {{ $products->links('website.layouts.pages.category-products.partials.pagination') }}
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End shop section -->

    </main>
@endsection

@push('scripts')
<script>
(function() {
    const DURATION = 250;

    const wrapper = document.getElementById('product-wrapper');
    const productList = document.getElementById('product-list');
    const paginationWrapper = document.getElementById('pagination-wrapper');

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

    function load(url) {
        fetch(url, { headers: { "X-Requested-With": "XMLHttpRequest" } })
            .then(res => res.json())
            .then(data => {
                productList.innerHTML = data.products;
                paginationWrapper.innerHTML = data.pagination;

                if (wrapper) {
                    window.scrollTo({ top: wrapper.offsetTop - 100, behavior: 'smooth' });
                }

                // URL should become /products?category=slug...
                if (data.canonical_url) {
                    history.pushState({}, '', data.canonical_url + (url.includes('page=') ? '&' + url.split('?')[1].split('&').filter(p=>p.startsWith('page=')).join('&') : ''));
                } else {
                    history.pushState({}, '', url);
                }
            });
    }

    // Toggle arrow click
    document.addEventListener('click', function(e) {
        const toggle = e.target.closest('.js-cat-toggle');
        if (!toggle) return;

        e.preventDefault();
        e.stopPropagation();

        const li = toggle.closest('li');
        if (!li) return;

        const submenu = li.querySelector(':scope > ul.widget__categories--sub__menu');
        if (!submenu) return;

        const isOpen = window.getComputedStyle(submenu).display !== 'none';
        if (isOpen) slideUp(submenu);
        else slideDown(submenu);
    }, true);

    // Category click + Pagination click (AJAX)
    document.addEventListener('click', function(e) {
        if (e.target.closest('.js-cat-toggle')) return;

        const cat = e.target.closest('.js-category-filter');
        const page = e.target.closest('#pagination-wrapper a');
        if (!cat && !page) return;

        e.preventDefault();

        const href = cat ? cat.getAttribute('href') : page.getAttribute('href');
        load(href);
    });

    // Back/forward: just reload current URL normally (simple)
    window.addEventListener('popstate', function() {
        window.location.href = window.location.href;
    });
})();
</script>
@endpush

