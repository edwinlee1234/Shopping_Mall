<div id="navBar">
    <ul class="nav justify-content-end">
        <li class="nav-item">
            <a class="nav-link" href="#">
                Hello!

                @if(session()->has('user_info'))
                    {{ session()->get('user_info')['name'] }}
                @else
                    Guest
                @endif
            </a>
        </li>
        <li class="nav-item">
            @if(session()->has('user_info'))
                <a class="nav-link" href="/cart">{{ trans('shop.main.cart') }}</a>
                <p id="cartNum">{{ session()->get('user_info')['cart_num'] }}</p>
            @endif
        </li>
        <li class="nav-item">
            @if(session()->has('user_info'))
                <a class="nav-link" href="#">{{ trans('shop.auth.center') }}</a>
            @else
                <a class="nav-link" href="/user/auth/sign-up">{{ trans('shop.auth.sign-up') }}</a>
            @endif
        </li>
        <li class="nav-item">
            @if(session()->has('user_info'))
                <a class="nav-link" href="/user/auth/sign-out">{{ trans('shop.auth.sign-out') }}</a>
            @else
                <a class="nav-link" href="/user/auth/sign-in">{{ trans('shop.auth.sign-in') }}</a>
            @endif
        </li>
    </ul>
</div>
