@php
    // Ensure variables are always defined
    $hasChildren = $category->children->count() > 0;
    $hasProducts = $category->products->count() > 0;

    // level parameter for recursion, default 0
    $level = $level ?? 0;
@endphp


<li class="list-group-item p-1 {{ $hasChildren ? 'has-children' : '' }}">
    <div class="d-flex align-items-center justify-content-between category-item parant-category-class-sn" style="cursor: pointer;">
        <div class="d-flex align-items-center">
            <img src="{{ $category->image ? asset($category->image) : asset('frontend/assets/img/product/default.png') }}"
                 alt="{{ $category->name }}" class="me-2 rounded-circle" style="width: 35px; height:35px; object-fit:cover;">
            @if($hasProducts)
                <a href="#" class="text-decoration-none">{{ $category->name }}</a>
            @else
                <span>{{ $category->name }}</span>
            @endif
        </div>

        @if($hasChildren)
            <span class="toggle-icon">&#9662;</span>
        @endif
    </div>

    @if($hasChildren)
        <ul class="list-group list-group-flush submenu ms-4 mt-1">
            @foreach($category->children as $child)
                @include('website.layouts.pages.product-details.partials.category-recursive', [
                    'category' => $child,
                    'level' => $level + 1
                ])
            @endforeach
        </ul>
    @endif
</li>
