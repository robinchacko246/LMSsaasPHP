@extends('storefront.user.user')
@section('page-title')
    {{__('Checkout')}} - {{($store->tagline) ?  $store->tagline : config('APP_NAME', ucfirst($store->name))}}
@endsection
@push('css-page')
@endpush
@push('script-page')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ isset($store_payments['stripe_key'])?$store_payments['stripe_key']:'' }}');
        var elements1 = stripe.elements();
        // Custom styling can be passed to options when creating an Element.
        var style = {
            base: {
                // Add your base input styles here. For example:
                fontSize: '14px',
                color: '#32325d',
            },
        };
        // Create an instance of the card Element.
        var card = elements1.create('card', {style: style});
        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');
        // Create a token or display an error when the form is submitted.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    $("#card-errors").html(result.error.message);
                    show_toastr('Error', result.error.message, 'error');
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    </script>
    {{--APPLY COUPON--}}
    <script>
        // Apply Coupon
        $(document).on('click', '.apply-coupon', function (e) {
            e.preventDefault();
            var ele = $(this);
            var coupon = ele.closest('.row').find('.coupon').val();
            var hidden_field = $('.hidden_coupon').val();
            var price = $('#total_value').attr('data-value');

            if (coupon == hidden_field) {
                show_toastr('Error', 'Coupon Already Used', 'error');
            } else {
                if (coupon != '') {
                    $.ajax({
                        url: '{{route('apply.productcoupon')}}',
                        datType: 'json',
                        data: {
                            price: price,
                            store_id: {{$store->id}},
                            coupon: coupon
                        },
                        success: function (data) {
                            $('#stripe_coupon, #paypal_coupon').val(coupon);
                            if (data.is_success) {
                                $('.hidden_coupon').val(coupon);
                                $('.hidden_coupon').attr(data);

                                $('.dicount_price').html(data.discount_price);

                                var html = '';
                                html += '<span class="text-sm font-weight-bold total_price" data-value="' + data.final_price_data_value + '">' + data.final_price + '</span>'
                                $('#total_value').html(html);

                                show_toastr('Success', data.message, 'success');
                            } else {
                                show_toastr('Error', data.message, 'error');
                            }
                        }
                    })
                } else {
                    show_toastr('Error', '{{__('Invalid Coupon Code.')}}', 'error');
                }
            }

        });
    </script>
    {{--BANK TRANSFER--}}
    <script>
        $(document).on('click', '#bank_transfer', function () {
            var product_array = '{{$encode_product}}';
            var product = JSON.parse(product_array.replace(/&quot;/g, '"'));
            var order_id = '{{$order_id = '#'.time()}}';
            var total_price = $('#total_value .total_price').attr('data-value');
            var coupon_id = $('.hidden_coupon').attr('data_id');
            var dicount_price = $('.dicount_price').html();


            var data = {
                coupon_id: coupon_id,
                dicount_price: dicount_price,
                total_price: total_price,
                product: product,
                order_id: order_id,
            }

            $.ajax({
                url: '{{ route('user.bank_transfer',$store->slug) }}',
                method: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.status == 'success') {

                        show_toastr(data["success"], '{!! session('+data["status"]+') !!}', data["status"]);

                        setTimeout(function () {
                            var url = '{{ route('store-complete.complete', [$store->slug, ":id"]) }}';
                            url = url.replace(':id', data.order_id);

                            window.location.href = url;
                        }, 1000);

                    } else {
                        show_toastr("Error", data.success, data["status"]);
                    }
                }
            });
        });
    </script>
@endpush
@section('head-title')
    {{__('Checkout')}}
@endsection
@section('content')
    <input type="hidden" id="return_url">
    <input type="hidden" id="return_order_id">
    <div class="course-page hero-section tutor-page cart-page">
        <div class="container-lg">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="course-page-text pt-100">
                        <div class="course-category">
                            <div class="course-back">
                                <a href="#">
                                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                                    {{__('Back to home')}}
                                </a>
                            </div>
                        </div>
                        <div class="category-heading">
                            <h2>{{__('Payment')}}</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cart-second">
        <div class="container-lg">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-12">
                    <div class="pay-section">
                        <!-- Add money using Stripe -->
                        @if(isset($store_payments['is_stripe_enabled']) && $store_payments['is_stripe_enabled'] == 'on')
                            <div class="pay-main d-flex w-100 align-items-start justify-content-between mt-0 mx-0 mb-30">
                                <form role="form" action="{{ route('stripe.post',$store->slug) }}" method="post" class="require-validation" id="payment-form">
                                    @csrf
                                    <div class="strip-card">
                                        <div class="col-lg-2 pay-name" style="width: auto;">
                                            <h4>{{__('Stripe')}}</h4>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-12">
                                            <p class="text-muted mt-2 mb-0 text-12">{{__('Safe money transfer using your bank account. We support Mastercard, Visa, Maestro and Skrill.')}}</p>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12 text-right strip-card-img p-0">
                                            <img alt="Image placeholder" src="{{asset('assets/img/mastercard.png')}}" width="40" class="mr-2">
                                            <img alt="Image placeholder" src="{{asset('assets/img/visa.png')}}" width="40" class="mr-2">
                                            <img alt="Image placeholder" src="{{asset('assets/img/skrill.png')}}" width="40">
                                        </div>
                                    </div>
                                    <div class="strip-card-input align-items-center">
                                        <div class="form-group">
                                            <label for="card-name-on" class="form-control-label t-gray font-600">{{__('Name on card')}}</label>
                                            <input type="text" name="name" id="card-name-on" class="form-control required" placeholder="Enter Your Name">
                                        </div>
                                        <div id="card-element"></div>
                                        <div id="card-errors" role="alert"></div>
                                        <div class="col-md-10">
                                            <br>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="error" style="display: none;">
                                                <div class='alert-danger alert text_sm'>{{__('Please correct the errors and try again.')}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 text-right p-0">
                                        <div class="pay-type-strip form-group">
                                            <input type="hidden" name="plan_id">
                                            <button class="pay-btn" type="submit">
                                                <i class="mdi mdi-cash-multiple mr-1"></i> {{__('Pay Now')}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    <!-- Add money using Bank Transfer -->
                        @if($store['enable_bank'] == 'on')
                            <div class="pay-main d-flex w-100 align-items-start justify-content-between mt-0 mx-0 mb-30">
                                <div class="pay-name">
                                    <h4>{{__('Bank Transfer')}}</h4>
                                    <p style="width: 360px;">{{ $store->bank_number }}</p>
                                </div>
                                <div class="pay-type">
                                    <div class="pay-type-img">
                                        <img src="{{asset('assets/img/bank.png')}}" alt="paypal" class="img-fluid">
                                    </div>
                                    <input type="hidden" name="product_id">
                                    <button type="submit" class="pay-btn" id="bank_transfer">
                                        {{__('Pay Now')}}
                                    </button>
                                </div>
                            </div>
                        @endif
                    <!-- Add money using Paystack -->
                        @if(isset($store_payments['is_paystack_enabled']) && $store_payments['is_paystack_enabled']=='on')
                            <div class="pay-main d-flex w-100 align-items-start justify-content-between mt-0 mx-0 mb-30">
                                <script src="https://js.paystack.co/v1/inline.js"></script>
                                {{--PAYSTACK JAVASCRIPT FUNCTION--}}
                                <script>
                                    function payWithPaystack() {
                                        var paystack_callback = "{{ url('/paystack') }}";
                                        var order_id = '{{$order_id = str_pad(!empty($order->id) ? $order->id + 1 : 0 + 1, 4, "100", STR_PAD_LEFT)}}';
                                        var slug = '{{$store->slug}}';
                                        var discount_price = '{{$store->slug}}';
                                            console.log($('.total_price').attr('data-value') * 100);
                                        var handler = PaystackPop.setup({
                                            key: '{{ $store_payments['paystack_public_key']  }}',
                                            email: '{{\Illuminate\Support\Facades\Auth::guard('students')->user()->email}}',
                                            amount: $('.total_price').attr('data-value') * 100,
                                            currency: '{{$store['currency_code']}}',
                                            ref: 'pay_ref_id' + Math.floor((Math.random() * 1000000000) +
                                                1
                                            ),
                                            // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                                            metadata: {
                                                custom_fields: [{
                                                    display_name: "Mobile Number",
                                                    variable_name: "mobile_number",
                                                }]
                                            },

                                            callback: function (response) {

                                                window.location.href = paystack_callback + '/' + slug + '/' + response.reference + '/' + {{$order_id}};
                                            },
                                            onClose: function () {
                                                alert('window closed');
                                            }
                                        });
                                        handler.openIframe();
                                    }

                                </script>
                                {{--PAYSTACK JAVASCRIPT FUNCTION--}}
                                <div class="pay-name">
                                    <h4>{{__('Paystack')}}</h4>
                                    <p>Pay your order using the most known and secure platform for online money transfers. You will be redirected to PayPal to finish complete your purchase.</p>
                                </div>
                                <div class="pay-type">
                                    <div class="pay-type-img">
                                        <img src="{{asset('assets/img/paystack-logo.jpg')}}" alt="paypal" class="img-fluid">
                                    </div>
                                    <input type="hidden" name="product_id">
                                    <button type="submit" class="pay-btn" onclick="payWithPaystack()">
                                        Pay Now
                                    </button>
                                </div>
                            </div>
                        @endif
                    <!-- Add money using PayPal -->
                        @if(isset($store_payments['is_paypal_enabled']) && $store_payments['is_paypal_enabled'] == 'on')
                            <div class="pay-main d-flex w-100 align-items-start justify-content-between mt-0 mx-0 mb-30">
                                <div class="pay-name">
                                    <h4>{{__('PayPal')}}</h4>
                                    <p>Pay your order using the most known and secure platform for online money transfers. You will be redirected to PayPal to finish complete your purchase.</p>
                                </div>
                                <div class="pay-type">
                                    <div class="pay-type-img">
                                        <img src="{{asset('assets/img/paypal.png')}}" alt="paypal" class="img-fluid">
                                    </div>
                                    <form method="POST" action="{{ route('pay.with.paypal',$store->slug) }}">
                                        @csrf
                                        <input type="hidden" name="product_id">
                                        <button class="pay-btn" type="submit">
                                            <i class="mdi mdi-cash-multiple mr-1"></i> {{__('Pay Now')}}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    <!-- Add money using Flutterwave -->
                        @if(isset($store_payments['is_flutterwave_enabled']) && $store_payments['is_flutterwave_enabled']=='on')
                            <div class="pay-main d-flex w-100 align-items-start justify-content-between mt-0 mx-0 mb-30">
                                <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                                <!--Flutterwave JAVASCRIPT FUNCTION -->
                                <script>
                                    function payWithRave() {
                                        var API_publicKey = '{{ $store_payments['flutterwave_public_key']  }}';
                                        var nowTim = "{{ date('d-m-Y-h-i-a') }}";
                                        var flutter_callback = "{{ url('/flutterwave') }}";
                                        var x = getpaidSetup({
                                            PBFPubKey: API_publicKey,
                                            customer_email: '{{\Illuminate\Support\Facades\Auth::guard('students')->user()->email}}',
                                            amount: $('.total_price').attr('data-value'),
                                            currency: '{{$store['currency_code']}}',
                                            txref: nowTim + '__' + Math.floor((Math.random() * 1000000000)) + 'fluttpay_online-' + {{ date('Y-m-d') }},
                                            meta: [{
                                                metaname: "payment_id",
                                                metavalue: "id"
                                            }],
                                            onclose: function () {
                                            },
                                            callback: function (response) {

                                                var txref = response.tx.txRef;

                                                if (
                                                    response.tx.chargeResponseCode == "00" ||
                                                    response.tx.chargeResponseCode == "0"
                                                ) {
                                                    window.location.href = flutter_callback + '/{{$store->slug}}/' + txref + '/' + {{$order_id}};
                                                } else {
                                                    // redirect to a failure page.
                                                }
                                                x.close(); // use this to close the modal immediately after payment.
                                            }
                                        });
                                    }
                                </script>
                                <!--/PAYSTACK JAVASCRIPT FUNCTION -->
                                <div class="pay-name">
                                    <h4>{{__('Flutterwave')}}</h4>
                                    <p>{{__('Pay your order using the most known and secure platform for online money transfers. You will be redirected to PayPal to finish complete your purchase')}}.</p>
                                </div>
                                <div class="pay-type">
                                    <div class="pay-type-img">
                                        <img src="{{asset('assets/img/flutterwave_logo.png')}}" alt="paypal" class="img-fluid">
                                    </div>
                                    <input type="hidden" name="product_id">
                                    <button type="submit" class="pay-btn" onclick="payWithRave()">
                                        {{__('Pay Now')}}
                                    </button>
                                </div>
                            </div>
                        @endif
                    <!-- Add money using Razorpay -->
                        @if(isset($store_payments['is_razorpay_enabled']) && $store_payments['is_razorpay_enabled'] == 'on')
                            <div class="pay-main d-flex w-100 align-items-start justify-content-between mt-0 mx-0 mb-30">
                                @php
                                    $logo         =asset(Storage::url('uploads/logo/'));
                                    $company_logo = Utility::getValByName('company_logo');
                                @endphp
                                <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                                {{--Flutterwave JAVASCRIPT FUNCTION--}}
                                <script>
                                    function payRazorPay() {

                                        var getAmount = $('.total_price').data('value');
                                        var product_id = '{{$order_id}}';
                                        var razorPay_callback = '{{url('razorpay')}}';
                                        var totalAmount = getAmount * 100;
                                        var product_array = '{{$encode_product}}';
                                        var product = JSON.parse(product_array.replace(/&quot;/g, '"'));
                                        var order_id = '{{$order_id = time()}}';

                                        var coupon_id = $('.hidden_coupon').attr('data_id');
                                        var dicount_price = $('.dicount_price').html();

                                        var options = {
                                            "key": "{{ $store_payments['razorpay_public_key']  }}", // your Razorpay Key Id
                                            "amount": totalAmount,
                                            "name": product,
                                            "currency": '{{$store['currency_code']}}',
                                            "description": "Order Id : " + order_id,
                                            "image": "{{$logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')}}",
                                            "handler": function (response) {
                                                window.location.href = '{{route('razorpay',[$store->slug,'payment_id','order_id'])}}'.replace('payment_id', response.razorpay_payment_id).replace('order_id', order_id);
                                                window.location.href = razorPay_callback + '/{{$store->slug}}/' + response.razorpay_payment_id + '/' + order_id;
                                            },
                                            "theme": {
                                                "color": "#528FF0"
                                            }
                                        };

                                        var rzp1 = new Razorpay(options);
                                        rzp1.open();
                                    }
                                </script>
                                {{--Razerpay JAVASCRIPT FUNCTION--}}
                                <div class="pay-name">
                                    <h4>{{__('Razorpay')}}</h4>
                                    <p>{{__('Pay your order using the most known and secure platform for online money transfers. You will be redirected to PayPal to finish complete your purchase')}}.</p>
                                </div>
                                <div class="pay-type">
                                    <div class="pay-type-img">
                                        <img src="{{asset('assets/img/razorpay.png')}}" alt="paypal" class="img-fluid">
                                    </div>
                                    <input type="hidden" name="product_id">
                                    <button type="submit" class="pay-btn" onclick="payRazorPay()">
                                        {{__('Pay Now')}}
                                    </button>
                                </div>
                            </div>
                        @endif
                    <!-- Add money using Paytm -->
                        @if(isset($store_payments['is_paytm_enabled']) && $store_payments['is_paytm_enabled'] == 'on')
                            <div class="pay-main d-flex w-100 align-items-start justify-content-between mt-0 mx-0 mb-30">
                                <div class="pay-name">
                                    <h4>{{__('Paytm')}}</h4>
                                    <p>{{__('Pay your order using the most known and secure platform for online money transfers. You will be redirected to PayPal to finish complete your purchase')}}.</p>
                                </div>
                                <div class="pay-type">
                                    <div class="pay-type-img">
                                        <img src="{{asset('assets/img/Paytm.png')}}" alt="paypal" class="img-fluid">
                                    </div>
                                    <form method="POST" action="{{ route('paytm.prepare.payments',$store->slug) }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ date('Y-m-d') }}-{{ strtotime(date('Y-m-d H:i:s')) }}-payatm">
                                        <input type="hidden" name="order_id" value="{{str_pad(!empty($order->id) ? $order->id + 1 : 0 + 1, 4, "100", STR_PAD_LEFT)}}">
                                        @php
                                            $skrill_data = [
                                                'transaction_id' => md5(date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id'),
                                                'user_id' => 'user_id',
                                                'amount' => 'amount',
                                                'currency' => 'currency',
                                            ];
                                            session()->put('skrill_data', $skrill_data);

                                        @endphp
                                        <button type="submit" class="pay-btn">{{__('Pay Now')}}</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    <!-- Add money using Mercado Pago -->
                        @if(isset($store_payments['is_mercado_enabled']) && $store_payments['is_mercado_enabled'] == 'on')
                            <div class="pay-main d-flex w-100 align-items-start justify-content-between mt-0 mx-0 mb-30">
                                <script>
                                    function payMercado() {

                                        var product_array = '{{$encode_product}}';
                                        var product = JSON.parse(product_array.replace(/&quot;/g, '"'));
                                        var order_id = '{{$order_id = time()}}';

                                        var total_price = $('#total_value .total_price').attr('data-value');
                                        var coupon_id = $('.hidden_coupon').attr('data_id');
                                        var dicount_price = $('.dicount_price').html();

                                        var data = {
                                            coupon_id: coupon_id,
                                            dicount_price: dicount_price,
                                            total_price: total_price,
                                            product: product,
                                            order_id: order_id,
                                        }
                                        $.ajax({
                                            url: '{{ route('mercadopago.prepare',$store->slug) }}',
                                            method: 'POST',
                                            data: data,
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            success: function (data) {
                                                if (data.status == 'success') {
                                                    window.location.href = data.url;
                                                } else {
                                                    show_toastr("Error", data.success, data["status"]);
                                                }
                                            }
                                        });
                                    }
                                </script>
                                <div class="pay-name">
                                    <h4>{{__('Mercado Pago')}}</h4>
                                    <p>{{__('Pay your order using the most known and secure platform for online money transfers. You will be redirected to PayPal to finish complete your purchase')}}.</p>
                                </div>
                                <div class="pay-type">
                                    <div class="pay-type-img">
                                        <img src="{{asset('assets/img/mercadopago.png')}}" alt="paypal" class="img-fluid">
                                    </div>
                                    <button type="submit" class="pay-btn" onclick="payMercado()">{{__('Pay Now')}}</button>
                                </div>
                            </div>
                        @endif
                    <!-- Add money using Mollie -->
                        @if(isset($store_payments['is_mollie_enabled']) && $store_payments['is_mollie_enabled'] == 'on')
                            <div class="pay-main d-flex w-100 align-items-start justify-content-between mt-0 mx-0 mb-30">
                                <div class="pay-name">
                                    <h4>{{__('Mollie')}}</h4>
                                    <p>{{__('Pay your order using the most known and secure platform for online money transfers. You will be redirected to PayPal to finish complete your purchase')}}.</p>
                                </div>
                                <div class="pay-type">
                                    <div class="pay-type-img">
                                        <img src="{{asset('assets/img/mollie.png')}}" alt="paypal" class="img-fluid">
                                    </div>
                                    <form method="POST" action="{{ route('mollie.prepare.payments',$store->slug) }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ date('Y-m-d') }}-{{ strtotime(date('Y-m-d H:i:s')) }}-payatm">
                                        <input type="hidden" name="desc" value="{{time()}}">
                                        <button type="submit" class="pay-btn">{{__('Pay Now')}}</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    <!-- Add money using Skrill -->
                        @if(isset($store_payments['is_skrill_enabled']) && $store_payments['is_skrill_enabled'] == 'on')
                            <div class="pay-main d-flex w-100 align-items-start justify-content-between mt-0 mx-0 mb-30">
                                <div class="pay-name">
                                    <h4>{{__('Skrill')}}</h4>
                                    <p>{{__('Pay your order using the most known and secure platform for online money transfers. You will be redirected to PayPal to finish complete your purchase')}}.</p>
                                </div>
                                <div class="pay-type">
                                    <div class="pay-type-img">
                                        <img src="{{asset('assets/img/skrill.png')}}" alt="paypal" class="img-fluid">
                                    </div>
                                    <form method="POST" action="{{ route('skrill.prepare.payments',$store->slug) }}">
                                        @csrf
                                        <input type="hidden" name="transaction_id" value="{{ date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id' }}">
                                        <input type="hidden" name="desc" value="{{time()}}">
                                        <button type="submit" class="pay-btn">{{__('Pay Now')}}</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    <!-- Add money using Coingate -->
                        @if(isset($store_payments['is_coingate_enabled']) && $store_payments['is_coingate_enabled'] == 'on')
                            <div class="pay-main d-flex w-100 align-items-start justify-content-between mt-0 mx-0 mb-30">
                                <div class="pay-name">
                                    <h4>{{__('CoinGate')}}</h4>
                                    <p>{{__('Pay your order using the most known and secure platform for online money transfers. You will be redirected to PayPal to finish complete your purchase')}}.</p>
                                </div>
                                <div class="pay-type">
                                    <div class="pay-type-img">
                                        <img src="{{asset('assets/img/coingate.png')}}" alt="paypal" class="img-fluid">
                                    </div>
                                    <form method="POST" action="{{ route('coingate.prepare',$store->slug) }}">
                                        @csrf
                                        <input type="hidden" name="transaction_id" value="{{ date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id' }}">
                                        <input type="hidden" name="desc" value="{{time()}}">
                                        <button type="submit" class="pay-btn">{{__('Pay Now')}}</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    <!-- Add money using Paymentwall -->
                        @if(isset($store_payments['is_paymentwall_enabled']) && $store_payments['is_paymentwall_enabled'] == 'on')
                            <script src="https://checkout.paymentwall.com/v1/checkout.js"></script>
                    
                            <div class="pay-main d-flex w-100 align-items-start justify-content-between mt-0 mx-0 mb-30">
                                <div class="pay-name">
                                    <h4>{{__('PaymentWall')}}</h4>
                                    <p>{{__('Pay your order using the most known and secure platform for online money transfers. You will be redirected to PayPal to finish complete your purchase')}}.</p>
                                </div>
                                <div class="pay-type">
                                    <div class="pay-type-img" style="width:100%">
                                        <img src="{{asset('assets/img/paymentwall.png')}}" alt="Paymentwall" class="img-fluid">
                                    </div>
                                    <form method="POST" action="{{ route('paymentwall.session.store',$store->slug) }}">
                                        @csrf
                                        <input type="hidden" name="transaction_id" class="customer_product" value="{{ date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id' }}">
                                        <input type="hidden" name="desc" value="{{time()}}">
                                        <button type="submit" class="pay-btn">{{__('Pay Now')}}</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-12">
                    @php
                        $cart = session()->get($store->slug);
                    @endphp
                    <div class="custom-position-sticky">
                        <div class="featured-courses course-cart mt-0 mb-4">
                            <div class="course-cart-head px-5">
                                <h3 class="m-0">{{__('Coupon')}}</h3>
                            </div>
                            <hr>
                            <div class="cart-section px-5">
                                <input type="text" id="stripe_coupon" name="coupon" class="form-control coupon mb-4" placeholder="{{ __('Enter Coupon Code') }}">
                                <input type="hidden" name="coupon" class="form-control hidden_coupon" value="">
                            </div>
                            <div class="cart-section px-5 form-group apply-stripe-btn-coupon float-right">
                                <a href="#" class="pay-btn apply-coupon">{{ __('Apply') }}</a>
                            </div>
                        </div>
                        <div class="featured-courses course-cart m-0">
                            <div class="course-cart-head px-5">
                                <h3 class="m-0">{{__('My Cart')}}</h3>
                            </div>
                            <hr>
                            <div class="cart-section px-5">
                                <div class="cart">
                                    <div class="cart-main">
                                        @php
                                            $total = 0;
                                            $sub_total = 0;
                                        @endphp
                                        @if(!empty($cart['products']))
                                            @foreach($cart['products'] as $k => $value)
                                                @php
                                                    $total += $value['price'];
                                                    $sub_total += $value['price'];
                                                @endphp
                                                <p class="d-flex align-items-center justify-content-between m-0">
                                                    @if(!empty($value['image']))
                                                        <img alt="Image placeholder" class="mr-2" src="{{asset($value['image'])}}" style="width: 42px;">
                                                    @else
                                                        <img alt="Image placeholder" class="mr-2" src="{{asset('assets/img/user.png')}}" style="width: 42px;">
                                                    @endif
                                                    {{$value['product_name']}}
                                                    <span class="fw-bold">{{ Utility::priceFormat($value['price'])}}</span>
                                                </p>
                                                <p class="d-flex align-items-center justify-content-between mt-4">
                                                    {{__('Coupon')}}
                                                    <span class="fw-bold dicount_price">0.00</span>
                                                </p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="proceed_to_checkout">
                                <div class="summary d-flex align-items-center justify-content-between p-5">
                                    <p class="m-0">
                                        {{__('Total')}}
                                    </p>
                                    <p class="m-0" id="total_value" data-value="{{$total}}">
                                        <span class="total_price" data-value="{{$total}}"> {{ Utility::priceFormat($total)}}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

