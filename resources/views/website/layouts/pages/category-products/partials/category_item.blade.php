@php
    $level = $level ?? 0;

    $children = $category->childrenRecursive ?? $category->children;
    $hasChildren = $children && $children->count() > 0;

    $raw = $category->image ?? '';
    $imgPath = ltrim(preg_replace('#^public/#', '', $raw), '/');
    $imgUrl = $imgPath ? asset($imgPath) : asset('frontend/assets/img/product/default.png');
@endphp

@if ($level === 0)
    <li class="widget__categories--menu__list">

        {{-- ROOT: click = filter --}}
        <a class="widget__categories--menu__label d-flex align-items-center js-category-filter"
            href="{{ route('category.page', ['slug' => $category->slug]) }}" data-slug="{{ $category->slug }}">

            <img class="widget__categories--menu__img" src="{{ $imgUrl }}" alt="categories-img">
            <span class="widget__categories--menu__text">{{ $category->name }}</span>

            {{-- ROOT: arrow click = only toggle (stopPropagation in JS) --}}
            @if ($hasChildren)
                <span class="js-cat-toggle widget__categories--menu__arrowdown--icon" role="button"
                    aria-label="Toggle sub categories">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394" viewBox="0 0 12.355 8.394">
                        <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                            transform="translate(-6 -8.59)" fill="currentColor"></path>
                    </svg>
                </span>
            @endif
        </a>

        @if ($hasChildren)
            <ul class="widget__categories--sub__menu">
                @foreach ($children as $child)
                    @include('website.layouts.pages.shop.partials.category_item', [
                        'category' => $child,
                        'level' => $level + 1,
                    ])
                @endforeach
            </ul>
        @endif
    </li>
@else
    <li class="widget__categories--sub__menu--list">
        @php $hasChildren = $children && $children->count() > 0; @endphp

        @if ($hasChildren)
            {{-- CHILD with subchild: name click = filter, arrow click = toggle --}}
            <a class="widget__categories--sub__menu--link d-flex align-items-center justify-content-between js-category-filter"
                href="{{ route('category.page', ['slug' => $category->slug]) }}" data-slug="{{ $category->slug }}">

                <span class="d-flex align-items-center">
                    <img class="widget__categories--sub__menu--img" src="{{ $imgUrl }}" alt="categories-img">
                    <span class="widget__categories--sub__menu--text">{{ $category->name }}</span>
                </span>

                <span class="js-cat-toggle" role="button" aria-label="Toggle sub categories">
                    <i class="fa-solid fa-angle-down"></i>
                </span>
            </a>
        @else
            {{-- LEAF: click = filter --}}
            <a class="widget__categories--sub__menu--link d-flex align-items-center js-category-filter"
                href="{{ route('category.page', ['slug' => $category->slug]) }}" data-slug="{{ $category->slug }}">
                <img class="widget__categories--sub__menu--img" src="{{ $imgUrl }}" alt="categories-img">
                <span class="widget__categories--sub__menu--text">{{ $category->name }}</span>
            </a>
        @endif

        @if ($hasChildren)
            <ul class="widget__categories--sub__menu" style="display:none;">
                @foreach ($children as $child)
                    @include('website.layouts.pages.shop.partials.category_item', [
                        'category' => $child,
                        'level' => $level + 1,
                    ])
                @endforeach
            </ul>
        @endif
    </li>
@endif
