<!-- Custom Categories Section -->
<section class="cat-hero-section">
    <div class="cat-container">
        <!-- Section Header -->
        <div class="section__heading text-center mb-35">
            <h2 class="section__heading--maintitle">Categories</h2>
        </div>

        <!-- Categories Grid -->
        <div class="cat-grid">

            @foreach($homeCategories as $key => $category)

           <a href="{{ route('category.page', ['slug' => $category->slug]) }}" class="cat-card">
                <div class="cat-icon-wrap">
                    <img src="{{ $category->image ? asset($category->image) : asset('frontend/assets/img/categories/fashion.png') }}"
                        alt="{{ $category->name }}" class="cat-icon" />
                </div>
                <span class="cat-label">{{ $category->name ?? '' }}</span>
            </a>

            @endforeach
        </div>
    </div>
</section>
