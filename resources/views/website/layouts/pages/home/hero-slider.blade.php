<section class="hero__slider--section">
        <div class="hero__slider--inner hero__slider--activation swiper">
            <div class="hero__slider--wrapper swiper-wrapper">
                @foreach($sliders as $slider)
                <div class="swiper-slide">
                    <div class="hero__slider--items home1__slider--bg">
                        <div class="container-fluid">
                            <div class="hero__slider--items__inner">
                                <div class="row row-cols-1">
                                    <div class="col">
                                        <div class="slider__content">
                                            <h2 class="slider__content--maintitle h1">
                                            @php
                                                $words = explode(' ', $slider->title);
                                                $chunks = array_chunk($words, 4);
                                                $lines = array_map(fn($chunk) => implode(' ', $chunk), $chunks);
                                            @endphp
                                            {!! implode('<br/>', $lines) !!}
                                            </h2>

                                            @php
                                                $words = explode(' ', $slider->sub_title);
                                                $chunks = array_chunk($words, 6);
                                                $subtitle = array_map(fn($chunk) => implode(' ', $chunk), $chunks);
                                            @endphp
                                            <p class="slider__content--desc desc2 d-sm-2-none mb-40">
                                                {!! implode('<br/>', $subtitle) !!}
                                            </p>
                                            <a class="slider__btn primary__btn" href="shop.html">Show Collection
                                                <svg class="primary__btn--arrow__icon"
                                                    xmlns="http://www.w3.org/2000/svg" width="20.2" height="12.2"
                                                    viewBox="0 0 6.2 6.2">
                                                    <path
                                                        d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z"
                                                        transform="translate(-4 -4)" fill="currentColor"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper__nav--btn swiper-button-next"></div>
            <div class="swiper__nav--btn swiper-button-prev"></div>
        </div>
    </section>
