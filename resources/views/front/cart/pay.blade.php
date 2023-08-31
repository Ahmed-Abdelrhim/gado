<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <!-- START:: UTF8 -->
    <meta charset="UTF-8">
    <meta name="HandheldFriendly" content="true">
    <!-- START:: DESCRIPTION -->
    <meta name="description" content="Lorem ipsum dolor sit amet, consectetur adipisicing elit">
    <!-- START:: KEYWORD -->
    <meta name="keyword"
        content="agency, business, corporate, creative, freelancer, minimal, modern, personal, portfolio, responsive, simple, cartoon">
    <!-- START:: THEME COLOR -->
    <meta name="theme-color" content="#212121">
    <!-- START:: THEME COLOR IN MOBILE -->
    <meta name="msapplication-navbutton-color" content="#15264B">
    <!-- START:: THEME COLOR IN MOBILE -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#15264B">
    <!-- START:: TITLE -->
    <title>Gado Eg Store</title>
    <!-- START:: FAVICON -->

    <script src="https://banquemisr.gateway.mastercard.com/checkout/version/62/checkout.js" data-error="errorCallback" data-cancel="cancelCallback" data-complete="completeCallback"></script>
        <script type="text/javascript">

            function errorCallback(error) {
                // alert('filed');
                window.location.href="{{url('order-recpt-filed?id='. $order->id)}}";
                  console.log(JSON.stringify(error));
            }
            function cancelCallback() {
                  console.log('Payment cancelled');
                   window.location.href="{{url('order-info?id='.$order->id.'&setting=1')}}";
            }

            function completeCallback(resultIndicator, sessionVersion) {
                window.location.href="{{url('order-recpt-finish?id='. $order->id)}}&payment-type=success-payment";
                console.log(resultIndicator);
            }
            Checkout.configure({
                session: {
            	id: '{{$result->session->id}}',

       		},
            merchant: '{{$result->merchant}}',
            order: {
                {{-- amount: '{{ ($order->total + \App\Governorate::find($order->Order_info()->first()->governorate_id)->shipping_fee)}}', --}}
                amount: '{{ $order->total + $order['shipping'] }}',
                currency: 'EGP',
                description: '#{{$order->id}}',
               id: Math.random()
            },
            interaction: {
                merchant: {
                    name: '{{$result->merchant}}',
                    address: {
                                line1: '200 Sample St',
                                line2: '1234 Example Town'
                        }
                },
                operation: "PURCHASE",
              }
        });
        </script>
</head>




<body class="
@if(request()->segment(count(request()->segments())) == 1 || request()->segment(count(request()->segments()) -1 ) == 1) home_one @endif">
    <!-- START:: INFO SITE SECTION -->
    <main>
        <!-- END:: BREADCRUMBS -->
        <!-- START:: CONTENT PAGE -->
        <div class="content_single_page">
            <div class="container mt-5">
                <div class="row"></div>
            </div>
        </div>
        <!-- END:: CONTENT PAGE -->
    </main>
    <!-- START:: SECTION PRODUCTS -->
    <script src="{{asset('dist/front/assets/js/jquery/jquery-3.4.1.min.js')}}"></script>
    <!-- START:: BOOTSTRAP -->
    <script src="{{asset('dist/front/assets/js/bootstrap/popper.min.js')}}"></script>
    <script src="{{asset('dist/front/assets/js/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{asset('dist/front/assets/js/bootstrap/bootstrap-range.js')}}"></script>
    <script src="{{asset('dist/js/my_code.js')}}"></script>

    <!-- START::  -->
    <script>
      $( document ).ready(function() {
        Checkout.showLightbox();
});
    </script>
</body>
</html>