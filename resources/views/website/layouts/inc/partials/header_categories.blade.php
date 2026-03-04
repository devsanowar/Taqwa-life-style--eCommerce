<li class="header__menu--items mega__menu--items style2">
    <a class="header__menu--link" href="#">Categories</a>

    <ul class="header__mega--menu d-flex">
        @foreach($categories as $parent)
            <li class="header__mega--menu__li">
                <span class="header__mega--subtitle">{{ $parent->name }}</span>

                @if($parent->childrenRecursive->isNotEmpty())
                    <ul class="header__mega--sub__menu">
                        @foreach($parent->childrenRecursive as $child)
                            <li class="header__mega--sub__menu_li">
                                <a class="header__mega--sub__menu--title" href="{{ route('shop.category', $child->slug) }}">
                                    {{ $child->name }}
                                </a>

                                @if($child->childrenRecursive->isNotEmpty())
                                    <ul class="header__mega--sub__menu">
                                        @foreach($child->childrenRecursive as $subchild)
                                            <li class="header__mega--sub__menu_li">
                                                <a class="header__mega--sub__menu--title" href="{{ route('shop.category', $subchild->slug) }}">
                                                    {{ $subchild->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                            </li>
                        @endforeach
                    </ul>
                @endif

            </li>
        @endforeach
    </ul>
</li>
