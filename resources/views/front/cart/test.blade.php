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

    <!-- START: Test Script -->
    {{--    <script src="https://qnbalahli.test.gateway.mastercard.com/static/checkout/checkout.min.js"--}}
    {{--            data-error="errorCallback"--}}
    {{--            data-cancel="cancelCallback">--}}
    {{--    </script>--}}
    <!-- END: Test Script -->

    <!-- START: Production Script -->
    <script src="https://qnbalahli.gateway.mastercard.com/static/checkout/checkout.min.js"
            data-error="errorCallback"
            data-cancel="cancelCallback">
    </script>
    <!-- END: Production Script -->

    <script type="text/javascript">
        function errorCallback(error) {
            window.location.href="{{url('order-recpt-filed?id='. $order->id)}}";
            console.log(JSON.stringify(error));
        }
        function cancelCallback() {
            console.log('Payment cancelled');
            window.location.href="{{url('order-info?id='.$order->id.'&setting=1')}}";
        }
        Checkout.configure({
        session: {
            id: '{{ $result['session']['id'] }}',
            }
        });

    </script>
</head>

<body>
<div id="embed-target"></div>
{{--<input type="button" value="Pay with Embedded Page" onclick="Checkout.showEmbeddedPage('#embedtarget');"/>--}}
{{--<input type="button" value="Pay with Payment Page" onclick="Checkout.showPaymentPage();"/>--}}


<!-- START:: SECTION PRODUCTS -->
<script src="{{asset('dist/front/assets/js/jquery/jquery-3.4.1.min.js')}}"></script>
<!-- START:: BOOTSTRAP -->
<script src="{{asset('dist/front/assets/js/bootstrap/popper.min.js')}}"></script>
<script src="{{asset('dist/front/assets/js/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{asset('dist/front/assets/js/bootstrap/bootstrap-range.js')}}"></script>
<script src="{{asset('dist/js/my_code.js')}}"></script>

<script>
          $( document ).ready(function() {
            Checkout.showPaymentPage();
            // Checkout.showLightbox();
          });

</script>
</body>
</html>


{{--<!DOCTYPE html>--}}
{{--<html lang="en" dir="ltr">--}}

{{--<head>--}}
{{--    <!-- START:: UTF8 -->--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="HandheldFriendly" content="true">--}}
{{--    <!-- START:: DESCRIPTION -->--}}
{{--    <meta name="description" content="Lorem ipsum dolor sit amet, consectetur adipisicing elit">--}}
{{--    <!-- START:: KEYWORD -->--}}
{{--    <meta name="keyword"--}}
{{--          content="agency, business, corporate, creative, freelancer, minimal, modern, personal, portfolio, responsive, simple, cartoon">--}}
{{--    <!-- START:: THEME COLOR -->--}}
{{--    <meta name="theme-color" content="#212121">--}}
{{--    <!-- START:: THEME COLOR IN MOBILE -->--}}
{{--    <meta name="msapplication-navbutton-color" content="#15264B">--}}
{{--    <!-- START:: THEME COLOR IN MOBILE -->--}}
{{--    <meta name="apple-mobile-web-app-status-bar-style" content="#15264B">--}}
{{--    <!-- START:: TITLE -->--}}
{{--    <title>Gado Eg Store</title>--}}
{{--    <!-- START:: FAVICON -->--}}

{{--    --}}{{--    <script src="https://banquemisr.gateway.mastercard.com/checkout/version/62/checkout.js"--}}
{{--    data-error="errorCallback" data-cancel="cancelCallback" data-complete="completeCallback"></script>--}}

{{--    <script src="https://upgstaging.egyptianbanks.com:8006/js/Lightbox.js" data-error="errorCallback"--}}
{{--            data-cancel="cancelCallback" data-complete="completeCallback"></script>--}}


{{--    <script src="https://qnbalahli.test.gateway.mastercard.com/static/checkout/checkout.min.js"--}}
{{--            data-complete="completeCallback"--}}
{{--            data-error="errorCallback"--}}
{{--            data-cancel="cancelCallback">--}}
{{--    </script>--}}


{{--    <script type="text/javascript">--}}
{{--            function callLightbox(‘LightBox’) {--}}
{{--                 var orderId = '';--}}
{{--                 var paymentMethodFromLightBox = null;--}}
{{--                 var amount = 100;--}}
{{--                 var mID = 40357;--}}
{{--                 var tID = 80050602;--}}
{{--                 var secureHash = “64373939653761352D343730352D343666632D623264312D34363235323463616166336”;--}}
{{--                 var trxDateTime = “20190807032800”;--}}
{{--                 var expirationDateTime = “20190801032800”;--}}

{{--                 Lightbox.Checkout.configure = {--}}
{{--                     OrderId: orderId,--}}
{{--                     paymentMethodFromLightBox: paymentMethodFromLightBox,--}}
{{--                     MID: mID,--}}
{{--                     TID: tID,--}}
{{--                     SecureHash : secureHash,--}}
{{--                     TrxDateTime : trxDateTime,--}}
{{--                     ExpirationDateTime : expirationDateTime,--}}
{{--                     AmountTrxn: amount,--}}
{{--                     MerchantReference: "",--}}

{{--                     completeCallback: function (data) {--}}
{{--                     //your code here--}}
{{--                     },--}}

{{--                     errorCallback: function (data) {--}}
{{--                     //your code here--}}
{{--                     },--}}

{{--                     cancelCallback:function () {--}}
{{--                     //your code here--}}
{{--                     }--}}
{{--                 };--}}
{{--                 Lightbox.Checkout.showLightbox();--}}
{{--            }--}}

{{--            function errorCallback(error) {--}}
{{--                // alert('filed');--}}
{{--                window.location.href="{{url('order-recpt-filed?id='. $order->id)}}";--}}
{{--                  console.log(JSON.stringify(error));--}}
{{--            }--}}
{{--            function cancelCallback() {--}}
{{--                  console.log('Payment cancelled');--}}
{{--                   window.location.href="{{url('order-info?id='.$order->id.'&setting=1')}}";--}}
{{--            }--}}

{{--            function completeCallback(resultIndicator, sessionVersion) {--}}
{{--                window.location.href="{{url('order-recpt-finish?id='. $order->id)}}&payment-type=success-payment";--}}
{{--                console.log(resultIndicator);--}}
{{--            }--}}
{{--            Checkout.configure({--}}
{{--                session: {--}}
{{--            	id: '{{$result->session->id}}',--}}

{{--       		},--}}
{{--            merchant: '{{$result->merchant}}',--}}
{{--            order: {--}}
{{--                --}}{{-- amount: '{{ ($order->total + \App\Governorate::find($order->Order_info()->first()->governorate_id)->shipping_fee)}}', --}}
{{--        amount: '{{ $order->total + $order['shipping'] }}',--}}
{{--                currency: 'EGP',--}}
{{--                description: '#{{$order->id}}',--}}
{{--               id: Math.random()--}}
{{--            },--}}
{{--            interaction: {--}}
{{--                merchant: {--}}
{{--                    name: '{{$result->merchant}}',--}}
{{--                    address: {--}}
{{--                                line1: '200 Sample St',--}}
{{--                                line2: '1234 Example Town'--}}
{{--                        }--}}
{{--                },--}}
{{--                operation: "PURCHASE",--}}
{{--              }--}}
{{--        });--}}


{{--    </script>--}}
{{--</head>--}}


{{--<body class="--}}
{{--@if(request()->segment(count(request()->segments())) == 1 || request()->segment(count(request()->segments()) -1 ) == 1) home_one @endif">--}}
{{--<!-- START:: INFO SITE SECTION -->--}}
{{--<main>--}}
{{--    <!-- END:: BREADCRUMBS -->--}}
{{--    <!-- START:: CONTENT PAGE -->--}}
{{--    <div class="content_single_page">--}}
{{--        <div class="container mt-5">--}}
{{--            <div class="row"></div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!-- END:: CONTENT PAGE -->--}}
{{--</main>--}}
{{--<!-- START:: SECTION PRODUCTS -->--}}
{{--<script src="{{asset('dist/front/assets/js/jquery/jquery-3.4.1.min.js')}}"></script>--}}
{{--<!-- START:: BOOTSTRAP -->--}}
{{--<script src="{{asset('dist/front/assets/js/bootstrap/popper.min.js')}}"></script>--}}
{{--<script src="{{asset('dist/front/assets/js/bootstrap/bootstrap.min.js')}}"></script>--}}
{{--<script src="{{asset('dist/front/assets/js/bootstrap/bootstrap-range.js')}}"></script>--}}
{{--<script src="{{asset('dist/js/my_code.js')}}"></script>--}}
{{--<!-- START::  -->--}}
{{--<script>--}}
{{--      $( document ).ready(function() {--}}
{{--          // Checkout.showLightbox();\--}}
{{--          Lightbox.Checkout.showLightbox();--}}
{{--      });--}}

{{--</script>--}}
{{--</body>--}}
{{--</html>--}}


{{--<!DOCTYPE html>--}}
{{--<html lang="en" dir="ltr">--}}
{{--<head>--}}
{{--    <!-- START:: UTF8 -->--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="HandheldFriendly" content="true">--}}
{{--    <!-- START:: DESCRIPTION -->--}}
{{--    <meta name="description" content="Lorem ipsum dolor sit amet, consectetur adipisicing elit">--}}
{{--    <!-- START:: KEYWORD -->--}}
{{--    <meta name="keyword"--}}
{{--          content="agency, business, corporate, creative, freelancer, minimal, modern, personal, portfolio, responsive, simple, cartoon">--}}
{{--    <!-- START:: THEME COLOR -->--}}
{{--    <meta name="theme-color" content="#212121">--}}
{{--    <!-- START:: THEME COLOR IN MOBILE -->--}}
{{--    <meta name="msapplication-navbutton-color" content="#15264B">--}}
{{--    <!-- START:: THEME COLOR IN MOBILE -->--}}
{{--    <meta name="apple-mobile-web-app-status-bar-style" content="#15264B">--}}
{{--    <!-- START:: TITLE -->--}}
{{--    <title>Gado Eg Store</title>--}}
{{--</head>--}}

{{--<body>--}}
{{--    <button class="payBtn btn btn-primary" onclick=" callLightbox (‘Lightbox’)"> PAY LightBox</button>--}}

{{--    <script src="https://upgstaging.egyptianbanks.com:8006/js/Lightbox.js"></script>--}}

{{--    <script type="text/javascript">--}}
{{--             function callLightbox(‘LightBox’) {--}}
{{--             var orderId = '';--}}
{{--             var paymentMethodFromLightBox = null;--}}
{{--             var amount = 100;--}}
{{--             var mID = 40357;--}}
{{--             var tID = 80050602;--}}
{{--             var secureHash =--}}
{{--            “64373939653761352D343730352D343666632D623264312D34363235323463616166336”;--}}
{{--             var trxDateTime = “20190807032800”;--}}
{{--            var expirationDateTime = “20190801032800”;--}}
{{--             var returnUrl = “”;--}}
{{--            Lightbox.Checkout.configure = {--}}
{{--             OrderId: orderId,--}}
{{--             paymentMethodFromLightBox: paymentMethodFromLightBox,--}}
{{--             MID: mID,--}}
{{--             TID: tID,--}}
{{--             SecureHash : secureHash,--}}
{{--             TrxDateTime : trxDateTime,--}}
{{--             ExpirationDateTime : expirationDateTime,--}}
{{--             AmountTrxn: amount,--}}
{{--             MerchantReference: "",--}}
{{--             ReturnUrl:returnUrl,--}}
{{--             completeCallback: function (data) {--}}
{{--             //your code here--}}
{{--             },--}}
{{--             errorCallback: function (data) {--}}
{{--             //your code here--}}
{{--             },--}}
{{--             cancelCallback:function () {--}}
{{--             //your code here--}}
{{--             }--}}
{{--             };--}}
{{--             Lightbox.Checkout.showPaymentPage();--}}
{{--             }--}}


{{--    </script>--}}

{{--</body>--}}
{{--</HTML>--}}