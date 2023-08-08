<ul>
    <li>
        <a class="active" href="{{ route('dealer.profile') }}">
            <img src="{{asset('dist/front/assets/images/icons/setting.svg')}}" alt="" width="" height="" />
            {{ __('messages.Profile') }} 
        </a>
    </li>
    <li>
        <a href="{{ route('front_my_orders',['div'=>'1']) }}">
            <img src="{{asset('dist/front/assets/images/icons/cart_p.svg')}}" alt="" width="" height="" />
            {{ __('messages.My_Orders') }}        </a>
    </li>
    <li>
        <a href="{{ route('dealer.logout') }}">
            <img src="{{asset('dist/front/assets/images/icons/logout.svg')}}" alt="" width="" height="" />
            {{ __('messages.log_out') }}
        </a>
    </li>
</ul>