@extends('website.layouts.app')
@section('title', 'Home')
@section('page_id', 'home_page')
@section('website_content')
<main class="main__content_wrapper">


    {{-- <div id="preloader">
        <div id="ctn-preloader" class="ctn-preloader">
            <div class="animation-preloader">
                <div class="spinner"></div>
                <div class="txt-loading">
                    <span data-text-preloader="L" class="letters-loading"> L </span>

                    <span data-text-preloader="O" class="letters-loading"> O </span>

                    <span data-text-preloader="A" class="letters-loading"> A </span>

                    <span data-text-preloader="D" class="letters-loading"> D </span>

                    <span data-text-preloader="I" class="letters-loading"> I </span>

                    <span data-text-preloader="N" class="letters-loading"> N </span>

                    <span data-text-preloader="G" class="letters-loading"> G </span>
                </div>
            </div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
    </div> --}}
    <!-- Start slider section -->
    @include('website.layouts.pages.home.hero-slider')
    <!-- End slider section -->

    <!-- Start banner section -->
    @include('website.layouts.pages.home.category-section')
    <!-- End banner section -->

    <!-- Start product section -->
    @include('website.layouts.pages.home.featured-product')
    <!-- End product section -->

    <!-- Start product section -->
    @include('website.layouts.pages.home.product-section')
    <!-- End product section -->

    <!-- Start deals banner section -->
    @include('website.layouts.pages.home.deals-banner-section')
    <!-- End deals banner section -->

    <!-- Start product section -->
    @include('website.layouts.pages.home.flash-sale')
    <!-- End product section -->

    <!-- Start banner section -->
    @include('website.layouts.pages.home.offer-banner-section')
    <!-- End banner section -->

    <!-- Start testimonial section -->
    @include('website.layouts.pages.home.testimonial-section')
    <!-- End testimonial section -->

    <!-- Start banner section -->
    @include('website.layouts.pages.home.seasional-offer-banner')
    <!-- End banner section -->

    <!-- Start blog section -->
    @include('website.layouts.pages.home.blog-section')
    <!-- End blog section -->



</main>


 <!-- Start News letter popup -->
    <div class="newsletter__popup" data-animation="slideInUp">
        <div id="boxes" class="newsletter__popup--inner">
            <button class="newsletter__popup--close__btn" aria-label="search close button">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 512 512">
                    <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="32" d="M368 368L144 144M368 144L144 368"></path>
                </svg>
            </button>
            <div class="box newsletter__popup--box d-flex align-items-center">
                <div class="newsletter__popup--thumbnail">
                    <img class="newsletter__popup--thumbnail__img display-block"
                        src="assets/img/banner/newsletter-popup-thumb2.png" alt="newsletter-popup-thumb" />
                </div>
                <div class="newsletter__popup--box__right">
                    <h2 class="newsletter__popup--title">Join Our Newsletter</h2>
                    <div class="newsletter__popup--content">
                        <label class="newsletter__popup--content--desc">Enter your email address to subscribe our
                            notification of our
                            new post &amp; features by email.</label>
                        <div class="newsletter__popup--subscribe" id="frm_subscribe">
                            <form class="newsletter__popup--subscribe__form">
                                <input class="newsletter__popup--subscribe__input" type="text"
                                    placeholder="Enter you email address here..." />
                                <button class="newsletter__popup--subscribe__btn">
                                    Subscribe
                                </button>
                            </form>
                            <div class="newsletter__popup--footer">
                                <input type="checkbox" id="newsletter__dont--show" />
                                <label class="newsletter__popup--dontshow__again--text"
                                    for="newsletter__dont--show">Don't show this popup again</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End News letter popup -->
    
@endsection
