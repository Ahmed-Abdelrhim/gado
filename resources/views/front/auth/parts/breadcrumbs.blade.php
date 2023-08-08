<div class="breadcrumbs">
    <div class="container">
        <h1>{{ $page_name }}</h1>
        <ul>
            <li>
                <a href="{{ url('/') }}">
                    <img src="{{asset('dist/front/assets/images/icons/home.svg')}}" alt="" height="" width="" />
                    {{ __('messages.Home') }}                </a>
            </li>
            <li>/</li>
            <li class="active">{{ $page_name }}</li>
        </ul>
    </div>
</div>