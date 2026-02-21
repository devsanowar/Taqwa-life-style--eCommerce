<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <a href="{{ route('home') }}" target="_blank">
                <img src="{{ asset($website_setting->website_header_logo ?? 'backend/assets/images/logo-icon.png') }}"
                class="logo-icon" alt="logo icon">
            </a>

        </div>

        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><i class='bx bxs-dashboard'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-home-alt"></i>
                </div>
                <div class="menu-title">Home</div>
            </a>
            <ul class="mm-collapse">
                <li> <a href="{{ route('admin.home.slider.index') }}"><i
                            class="bx bx-radio-circle"></i>Sliders</a>
                </li>

                {{-- <li> <a href="{{ route('admin.product.brand.index') }}"><i class="bx bx-radio-circle"></i>Brands</a>
                </li>

                <li> <a href="{{ route('admin.product.index') }}"><i class="bx bx-radio-circle"></i>Products</a>
                </li> --}}
            </ul>
        </li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-cart-alt"></i>
                </div>
                <div class="menu-title">Products</div>
            </a>
            <ul class="mm-collapse">
                <li> <a href="{{ route('admin.product.category.index') }}"><i
                            class="bx bx-radio-circle"></i>Categories</a>
                </li>

                <li> <a href="{{ route('admin.product.brand.index') }}"><i class="bx bx-radio-circle"></i>Brands</a>
                </li>

                <li> <a href="{{ route('admin.product.index') }}"><i class="bx bx-radio-circle"></i>Products</a>
                </li>
            </ul>
        </li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-layer"></i>
                </div>
                <div class="menu-title">Variants</div>
            </a>
            <ul class="mm-collapse">
                <li> <a href="{{ route('admin.product.attribute.index') }}"><i
                            class="bx bx-radio-circle"></i>Attributes</a>
                </li>

                <li> <a href="{{ route('admin.product.attribute_value.index') }}"><i
                            class="bx bx-radio-circle"></i>Attribute Values</a>
                </li>

                <li> <a href="{{ route('admin.product.variants.index') }}"><i
                            class="bx bx-radio-circle"></i>Variants</a>
                </li>

            </ul>
        </li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-tag-alt"></i>
                </div>
                <div class="menu-title">Flash Sales</div>
            </a>
            <ul class="mm-collapse">
                <li> <a href="{{ route('admin.flash_sales.index') }}"><i class="bx bx-radio-circle"></i>Flash Sales</a>
                </li>
                <li> <a href="{{ route('admin.flash_sale_items.index') }}"><i class="bx bx-radio-circle"></i>Flash Sale
                        Items</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="{{ route('admin.product.review.index') }}">
                <div class="parent-icon"><i class="bx bx-star"></i>
                </div>
                <div class="menu-title">Review</div>
            </a>
        </li>


        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-repeat"></i>
                </div>
                <div class="menu-title">Posts</div>
            </a>
            <ul class="mm-collapse">
                <li> <a href="{{ route('admin.post.category.index') }}"><i class="bx bx-radio-circle"></i>Categories</a>
                </li>
                <li> <a href="{{ route('admin.post.create') }}"><i class="bx bx-radio-circle"></i>Add Post</a>
                </li>

                <li> <a href="{{ route('admin.post.index') }}"><i class="bx bx-radio-circle"></i>All Post</a>
                </li>
            </ul>
        </li>


        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-cog'></i></div>
                <div class="menu-title">Theme Settings</div>
            </a>
            <ul class="mm-collapse">
                <li><a href="{{ route('admin.website.menu.index') }}"><i class='bx bx-radio-circle'></i>Website Menu</a>
                </li>
                <li><a href="{{ route('admin.website.setting.index') }}"><i class='bx bx-radio-circle'></i>Website
                        Settings</a></li>
                <li><a href="{{ route('admin.social.icon.index') }}"><i class='bx bx-radio-circle'></i>Social Icon
                        Settings</a></li>
                <li><a href="{{ route('admin.theme.customize.index') }}"><i class='bx bx-radio-circle'></i>Theme
                        Customize</a></li>
            </ul>
        </li>

        <li>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <div class="parent-icon"><i class='bx bx-log-out-circle'></i>
                </div>
                <div class="menu-title">Logout</div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>

    </ul>
    <!--end navigation-->
</div>
