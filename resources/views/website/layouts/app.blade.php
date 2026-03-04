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
