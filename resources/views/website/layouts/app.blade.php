<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Morden Bootstrap HTML5 Template" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @php
    $siteTitle = $website_setting->website_title ?? config('app.name');
    @endphp

    <title>
        @hasSection('title')
        @yield('title') | {{ $siteTitle }}
        @else
        {{ $siteTitle }}
        @endif
    </title>


    @include('website.layouts.inc.style')


</head>

<body id="@yield('page_id')">


    @include('website.layouts.inc.header')
    <!-- End header area -->

    @yield('website_content')

    @include('website.layouts.inc.footer')

    <!-- Quickview Wrapper -->
    @include('website.layouts.inc.quick-view')
    <!-- Quickview Wrapper End -->

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

    <!-- Scroll top bar -->
    <button id="scroll__top">
        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48"
                d="M112 244l144-144 144 144M256 120v292" />
        </svg>
    </button>



    @include('website.layouts.inc.script')
    

    @stack('frontend_scripts')
</body>

</html>
