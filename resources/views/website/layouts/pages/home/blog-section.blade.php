<section class="blog__section section--padding pt-0">
    <div class="container-fluid">
        <div class="section__heading text-center mb-40">
            <h2 class="section__heading--maintitle">From The Blog</h2>
        </div>
        <div class="blog__section--inner blog__swiper--activation swiper">
            <div class="swiper-wrapper">
                @foreach ($posts as $post)
                <div class="swiper-slide">
                    <div class="blog__items">
                        <div class="blog__thumbnail">
                            <a class="blog__thumbnail--link" href="blog-details.html"><img class="blog__thumbnail--img"
                                    src="{{ asset($post->thumbnail ? $post->thumbnail : 'frontend/assets/img/blog/blog2.png') }}"
                                    alt="blog-img" />
                            </a>
                        </div>
                        <div class="blog__content">
                            <span class="blog__content--meta">
                                {{ $post->created_at->format('F d, Y') }}
                            </span>
                            <h3 class="blog__content--title">
                                <a href="blog-details.html">{{ $post->title ?? '' }}
                                </a>
                            </h3>
                            <a class="blog__content--btn primary__btn" href="blog-details.html">Read more
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
            <div class="swiper__nav--btn swiper-button-next"></div>
            <div class="swiper__nav--btn swiper-button-prev"></div>
        </div>
    </div>
</section>
