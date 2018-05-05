<div id="navBar">
    <ul class="nav justify-content-end">
        <li class="nav-item">
            <a class="nav-link">
                Hello!

                @if(!empty(session()->get('user_info')['id']))
                    {{ session()->get('user_info')['name'] }}
                @else
                    Guest
                @endif
            </a>
        </li>
        <li class="nav-item">
            @if(!empty(session()->get('user_info')['id']))
                <a class="nav-link" href="/cart">{{ trans('shop.main.cart') }}</a>
                <p id="cartNum">{{ session()->get('cart_num')}}</p>
            @endif
        </li>
        <li class="nav-item">
            @if(!empty(session()->get('user_info')['id']))
                <a class="nav-link" href="/center">{{ trans('shop.auth.center') }}</a>
            @else
                <a class="nav-link" href="/user/auth/sign-up">{{ trans('shop.auth.sign-up') }}</a>
            @endif
        </li>
        <li class="nav-item">
            @if(!empty(session()->get('user_info')['id']))
                <a class="nav-link" href="/user/auth/sign-out">{{ trans('shop.auth.sign-out') }}</a>
            @else
                <a class="nav-link" href="/user/auth/sign-in">{{ trans('shop.auth.sign-in') }}</a>
            @endif
        </li>
        <li class="nav-item">
            <a class="nav-link changLangBtn" data-toggle="modal" data-target="#changeLang">
                @if(app()->getLocale() === 'tw')
                    繁中
                @elseif(app()->getLocale() === 'cn')
                    简中
                @else
                    en
                @endif
            </a>
        </li>
    </ul>
    <!-- Modal -->
    <div class="modal fade" id="changeLang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        {{ trans('shop.lang.intro') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="set_language" data-language="tw">
                        中文
                    </h3>
                    <h3 class="set_language" data-language="en">
                        English
                    </h3>
                    <h3 class="set_language" data-language="cn">
                        简体中文
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
