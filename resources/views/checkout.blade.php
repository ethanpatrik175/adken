@extends('layouts.frontend.master')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/checkout.css') }}">
    <style type="text/css">
        .fancybox-margin {
            margin-right: 17px;
        }

        .danger{
            background-color: #da0000;
            color: white;
            text-align: center;
            font-size: 20px;
            padding: 10px;
            display: none;
        }

    </style>
@endpush

@section('title')
    <title>{{ config('app.name') }} | Checkout</title>
@endsection

@section('content')
    <div class="chk-bg">
        <div class="container">

            <div class="danger">
                <div class="container">
                    <p class="error-messages">Plesae Correct These Errors</p>
                </div>
            </div>

            <div class="cp-box">
                <div class="chk-header-top">
                    <img src="{{ asset('assets/frontend/images/logo.png') }}" alt="" class="chk-logo">
                    <img src="{{ asset('assets/frontend/images/chk-steps-img.png') }}" alt="" class="chk-steps">
                    <div class="chk-ex-offer">
                        <img src="{{ asset('assets/frontend/images/logo_uk.png') }}" alt="">
                        <p>Internet Exclusive Offer<br> Available to US Residents Only</p>
                    </div>
                </div>
                <div class="chk-cont-bg">
                    <form role="form" action="{{ route('stripe.checkout.process') }}" method="POST" class="require-validation needs-validation"
                        data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                        @csrf
                        <div class="lft-box">
                            <h2 class="cp-leftHeading"><span>Select Your Package</span></h2>
                            <?php $counter = 1; ?>
                            @forelse ($products as $product)
                                <?php
                                $productPrice = $product->sale_price > 0 && $product->retail_price > $product->sale_price ? number_format($product->sale_price, 2) : number_format($product->retail_price, 2);
                                $subTotal = number_format($productPrice * $product->quantity, 2);
                                $total = number_format($subTotal + $product->shipping_charges, 2);
                                ?>
                                <div class="box box{{ $counter }} {{ $counter == 1 ? 'selected' : '' }}"
                                    data-products="{{ $totalProducts }}" data-sub-total="{{ $subTotal }}"
                                    data-total="{{ $total }}"
                                    data-summary-image="{{ asset('assets/frontend/images/products/' . $product->summary_image) }}"
                                    data-offer-qty="{{ $product->quantity ?? 0 }}"
                                    data-shipping-charges="{{ $product->shipping_charges ?? 0 }}"
                                    onclick='selectProduct("box{{ $counter }}")'>
                                    <?php $productName = Str::of($product->name)->explode('+'); ?>
                                    <input type="hidden" name="id" value="{{ $product->id }}" />
                                    <p class="hdg-txt">
                                        {{ $productName[0] }}
                                        @foreach ($productName as $index => $pName)
                                            @if ($index == 0)
                                                @continue
                                            @endif
                                            <span> + {{ $pName }}</span>
                                        @endforeach
                                    </p>
                                    <div class="lft-cont">
                                        <p class="pack-price">
                                            ${{ $product->sale_price > 0 && $product->retail_price > $product->sale_price ? number_format($product->sale_price, 2) : number_format($product->retail_price, 2) }}<span>/{{ $product->type ?? '-' }}</span>
                                        </p>
                                        <p class="chk-p1">Retail
                                            Price:<span>${{ number_format($product->retail_price, 2) }}</span></p>
                                        <img src="{{ asset('assets/frontend/images/products/' . Str::replace(' ', '%20', $product->image)) }}"
                                            alt="" class="chk-prd">
                                    </div>
                                    @if ($product->is_sample == 1)
                                        <img src="{{ asset('assets/frontend/images/sample.png') }}" alt=""
                                            class="quality_val" />
                                    @else
                                        <img src="{{ asset('assets/frontend/images/bst-val.png') }}" alt=""
                                            class="quality_val" />
                                    @endif

                                </div>
                                <?php $counter++; ?>
                            @empty
                            @endforelse

                            <div class="left1">
                                <div class="left11">
                                    <p class="para1">ORDER SUMMARY</p>
                                    <div id="sum-btl"><img
                                            src="{{ asset('assets/frontend/images/products/Bundle-of-three-products.png') }}"
                                            alt="" class="bottle-chk">
                                    </div>
                                    <img src="{{ asset('assets/frontend/images/united.png') }}" class="united">
                                </div>
                                <div class="rgt-prc-box">
                                    <p class="prd-name"><span>Adkin</span> <br>Bundle of Products</p>
                                    <div class="sum-prd-prc">
                                        <div class="sum-prd-lft">
                                            <p id="prd-btl">-</p>
                                        </div>
                                        <div class="sum-prd-rgt">
                                            <p id="prd-prc">-</p>
                                        </div>
                                    </div>
                                    <div class="sum-prd-prc sh">
                                        <div class="sum-prd-lft">
                                            <p>Shipping &amp; Handling:</p>
                                        </div>
                                        <div class="sum-prd-rgt">
                                            <p id="sh-prc">-</p>
                                        </div>
                                    </div>
                                    <div class="sum-prd-prc" style="padding-top:10px;">
                                        <div class="sum-prd-lft">
                                            <p>Total:</p>
                                        </div>
                                        <div class="sum-prd-rgt">
                                            <p id="tot-prd-prc">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chk-rgt-box">
                            <div class="frm-container">
                                <div class="frm-top">
                                    <center><img src="{{ asset('assets/frontend/images/chk-frm-top.png') }}"
                                            alt="" class="chk-frm-top"></center>

                                    <div class="bill-info">
                                        <div id="billing-info">
                                            <center>
                                                <p style="float:none;">We Accept:</p>
                                            </center> <br>
                                            <img src="{{ asset('assets/frontend/images/cards.png') }}"
                                                alt="Visa MasterCard">
                                            <div class="clearall"></div>
                                            <p>&nbsp;</p>
                                            <p>Billing address is the same as shipping</p>
                                            <div id="billing-btn">
                                                <input checked="checked" class="billingSameAsShipping billing_address_same"
                                                    name="billShipSame" id="billingSameAsShipping" value="1"
                                                    type="radio">
                                                Yes &nbsp;
                                                <input class="billingSameAsShipping billing_address_notsame"
                                                    name="billShipSame" id="billingDiffAsShipping" value="0"
                                                    type="radio">
                                                No
                                            </div>
                                        </div>
                                    </div>
                                    <div class="frm-box-btm" style=" float:left; display:none;" id="billingDiv">
                                        @if (Session::has('shipping_details'))
                                            <?php $shipping = Session::get('shipping_details'); ?>
                                            <input type="hidden" id="shipState"
                                                value="{{ $shipping['shipState'] ?? '' }}" />
                                            <div class="frm-element">
                                                <label for="">Address</label>
                                                <input type="text" name="address1"
                                                    value="{{ $shipping['address'] ?? '' }}" required="">
                                            </div>
                                            <div class="frm-element">
                                                <label for="">City</label>
                                                <input type="text" name="city"
                                                    value="{{ $shipping['city'] ?? '' }}" required="">
                                            </div>
                                            <div class="frm-element">
                                                <label for="">Zip Code</label>
                                                <input type="text" name="billingZip"
                                                    value="{{ $shipping['zipcode'] ?? '' }}" required="">
                                            </div>
                                            <div class="frm-element">
                                                <label for="">State</label>
                                                <select name="billingState" id="billingState" class="required"
                                                    required="">
                                                    <option value="">Select State</option>
                                                    <option value="AL">Alabama</option>
                                                    <option value="AK">Alaska</option>
                                                    <option value="AS">American Samoa</option>
                                                    <option value="AZ">Arizona</option>
                                                    <option value="AR">Arkansas</option>
                                                    <option value="AE-A">Armed Forces Africa</option>
                                                    <option value="AA">Armed Forces Americas</option>
                                                    <option value="AE-C">Armed Forces Canada</option>
                                                    <option value="AE-E">Armed Forces Europe</option>
                                                    <option value="AE-M">Armed Forces Middle East</option>
                                                    <option value="AP">Armed Forces Pacific</option>
                                                    <option value="CA">California</option>
                                                    <option value="CO">Colorado</option>
                                                    <option value="CT">Connecticut</option>
                                                    <option value="DE">Delaware</option>
                                                    <option value="DC">District of Columbia</option>
                                                    <option value="FM">Federated States of Micronesia</option>
                                                    <option value="FL">Florida</option>
                                                    <option value="GA">Georgia</option>
                                                    <option value="GU">Guam</option>
                                                    <option value="HI">Hawaii</option>
                                                    <option value="ID">Idaho</option>
                                                    <option value="IL">Illinois</option>
                                                    <option value="IN">Indiana</option>
                                                    <option value="IA">Iowa</option>
                                                    <option value="KS">Kansas</option>
                                                    <option value="KY">Kentucky</option>
                                                    <option value="LA">Louisiana</option>
                                                    <option value="ME">Maine</option>
                                                    <option value="MD">Maryland</option>
                                                    <option value="MA">Massachusetts</option>
                                                    <option value="MI">Michigan</option>
                                                    <option value="MN">Minnesota</option>
                                                    <option value="MS">Mississippi</option>
                                                    <option value="MO">Missouri</option>
                                                    <option value="MT">Montana</option>
                                                    <option value="NE">Nebraska</option>
                                                    <option value="NV">Nevada</option>
                                                    <option value="NH">New Hampshire</option>
                                                    <option value="NJ">New Jersey</option>
                                                    <option value="NM">New Mexico</option>
                                                    <option value="NY">New York</option>
                                                    <option value="NC">North Carolina</option>
                                                    <option value="ND">North Dakota</option>
                                                    <option value="MP">Northern Mariana Islands</option>
                                                    <option value="OH">Ohio</option>
                                                    <option value="OK">Oklahoma</option>
                                                    <option value="OR">Oregon</option>
                                                    <option value="PA">Pennsylvania</option>
                                                    <option value="PR">Puerto Rico</option>
                                                    <option value="MH">Republic of Marshall Islands</option>
                                                    <option value="RI">Rhode Island</option>
                                                    <option value="SC">South Carolina</option>
                                                    <option value="SD">South Dakota</option>
                                                    <option value="TN">Tennessee</option>
                                                    <option value="TX">Texas</option>
                                                    <option value="UT">Utah</option>
                                                    <option value="VT">Vermont</option>
                                                    <option value="VI">Virgin Islands of the U.S.</option>
                                                    <option value="VA">Virginia</option>
                                                    <option value="WA">Washington</option>
                                                    <option value="WV">West Virginia</option>
                                                    <option value="WI">Wisconsin</option>
                                                    <option value="WY">Wyoming</option>
                                                </select>
                                            </div>
                                        @else
                                            <div class="frm-element">
                                                <label for="">Address</label>
                                                <input type="text" name="address1" value="" required="">
                                            </div>
                                            <div class="frm-element">
                                                <label for="">City</label>
                                                <input type="text" name="city" value="" required="">
                                            </div>
                                            <div class="frm-element">
                                                <label for="">Zip Code</label>
                                                <input type="text" name="billingZip" value="" required="">
                                            </div>
                                            <div class="frm-element">
                                                <label for="">State</label>
                                                <select name="billingState" class="required" required="">
                                                    <option value="CO">Select State</option>
                                                    <option value="AL">Alabama</option>
                                                    <option value="AK">Alaska</option>
                                                    <option value="AS">American Samoa</option>
                                                    <option value="AZ">Arizona</option>
                                                    <option value="AR">Arkansas</option>
                                                    <option value="AE-A">Armed Forces Africa</option>
                                                    <option value="AA">Armed Forces Americas</option>
                                                    <option value="AE-C">Armed Forces Canada</option>
                                                    <option value="AE-E">Armed Forces Europe</option>
                                                    <option value="AE-M">Armed Forces Middle East</option>
                                                    <option value="AP">Armed Forces Pacific</option>
                                                    <option value="CA">California</option>
                                                    <option value="CO">Colorado</option>
                                                    <option value="CT">Connecticut</option>
                                                    <option value="DE">Delaware</option>
                                                    <option value="DC">District of Columbia</option>
                                                    <option value="FM">Federated States of Micronesia
                                                    </option>
                                                    <option value="FL">Florida</option>
                                                    <option value="GA">Georgia</option>
                                                    <option value="GU">Guam</option>
                                                    <option value="HI">Hawaii</option>
                                                    <option value="ID">Idaho</option>
                                                    <option value="IL">Illinois</option>
                                                    <option value="IN">Indiana</option>
                                                    <option value="IA">Iowa</option>
                                                    <option value="KS">Kansas</option>
                                                    <option value="KY">Kentucky</option>
                                                    <option value="LA">Louisiana</option>
                                                    <option value="ME">Maine</option>
                                                    <option value="MD">Maryland</option>
                                                    <option value="MA">Massachusetts</option>
                                                    <option value="MI">Michigan</option>
                                                    <option value="MN">Minnesota</option>
                                                    <option value="MS">Mississippi</option>
                                                    <option value="MO">Missouri</option>
                                                    <option value="MT">Montana</option>
                                                    <option value="NE">Nebraska</option>
                                                    <option value="NV">Nevada</option>
                                                    <option value="NH">New Hampshire</option>
                                                    <option value="NJ">New Jersey</option>
                                                    <option value="NM">New Mexico</option>
                                                    <option value="NY">New York</option>
                                                    <option value="NC">North Carolina</option>
                                                    <option value="ND">North Dakota</option>
                                                    <option value="MP">Northern Mariana Islands
                                                    </option>
                                                    <option value="OH">Ohio</option>
                                                    <option value="OK">Oklahoma</option>
                                                    <option value="OR">Oregon</option>
                                                    <option value="PA">Pennsylvania</option>
                                                    <option value="PR">Puerto Rico</option>
                                                    <option value="MH">Republic of Marshall Islands
                                                    </option>
                                                    <option value="RI">Rhode Island</option>
                                                    <option value="SC">South Carolina</option>
                                                    <option value="SD">South Dakota</option>
                                                    <option value="TN">Tennessee</option>
                                                    <option value="TX">Texas</option>
                                                    <option value="UT">Utah</option>
                                                    <option value="VT">Vermont</option>
                                                    <option value="VI">Virgin Islands of the U.S.
                                                    </option>
                                                    <option value="VA">Virginia</option>
                                                    <option value="WA">Washington</option>
                                                    <option value="WV">West Virginia</option>
                                                    <option value="WI">Wisconsin</option>
                                                    <option value="WY">Wyoming</option>
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="frm-box-top">

                                        <div class="frm-element">
                                            <label for="">Credit Card #:</label>
                                            <input type="text" name="cardNumber" id="ccard" class="card-number"
                                                required="" maxlength="20">
                                        </div>
                                        <div class="frm-element expiration required">
                                            <label for="">Exp. Date:</label>
                                            <select name="cardYear" id="years" class="exp card-expiry-year"
                                                required="">
                                                <option value="">Year</option>
                                                @for ($y = 22; $y <= 32; $y++)
                                                    <option value="{{ $y }}">{{ $y }}</option>
                                                @endfor
                                            </select>
                                            <select name="cardMonth" id="months" style="margin-right:10px;"
                                                class="exp card-expiry-month" required="">
                                                <option selected="" value="">Month</option>
                                                <option value="01">(01) January</option>
                                                <option value="02">(02) February</option>
                                                <option value="03">(03) March</option>
                                                <option value="04">(04) April</option>
                                                <option value="05">(05) May</option>
                                                <option value="06">(06) June</option>
                                                <option value="07">(07) July</option>
                                                <option value="08">(08) August</option>
                                                <option value="09">(09) September</option>
                                                <option value="10">(10) October</option>
                                                <option value="11">(11) November</option>
                                                <option value="12">(12) December</option>
                                            </select>
                                        </div>
                                        <div class="frm-element" style="float:right;">
                                            <a href="{{ route('about.cvv') }}"
                                                class="cvv green fancybox fancybox.iframe">What is
                                                this?</a>
                                            <label for="">CVV:</label>
                                            <input type="text" name="cardSecurityCode" id="CVV"
                                                class="cvv card-cvc" required="" maxlength="4">
                                        </div>
                                        <center><img src="{{ asset('assets/frontend/images/sec1-frm-lock-img.png') }}"
                                                alt="" class="sec1-frm-lock-img"></center>
                                        <input type="submit" class="submit-bt pulse" value=""
                                            onclick="noexit();">
                                        <center><img src="{{ asset('assets/frontend/images/chk-frm-scr-logo.png') }}"
                                                alt="" class="sec1-security-seal-img"></center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer>
            <div class="container">
                @include('footer')
            </div>
        </footer>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('assets/frontend/js/jquery.creditCardValidator.js') }}"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
        $(document).ready(function(e) {

            $('.fancybox').fancybox();

            $('#billingSameAsShipping').click(function(e) {
                $('#billingDiv').slideUp();
            });
            $('#billingDiffAsShipping').click(function(e) {
                $('#billingDiv').slideDown();
            });
        });

        function selectProduct(box) {
            $('.' + box).addClass('selected');

            for (let i = 0; i <= $('.' + box).data('products'); i++) {
                if ('.box' + i == '.' + box) {
                    continue;
                } else {
                    $('.box' + i).removeClass('selected');
                }
            }

            $('#sum-btl').html('<img src="' + $('.' + box).data('summary-image') + '" alt="" class="bottle-chk" />');
            $('#prd-btl').html($('.' + box).data('offer-qty') + ' Months Supply');
            $('#sh-prc').html('$' + $('.' + box).data('shipping-charges'));
            $('#prd-prc').html('$' + $('.' + box).data('sub-total'));
            $('#tot-prd-prc').html('$' + $('.' + box).data('total'));
        }

        // selectProduct("box4");

        $(document).ready(function() {
            $(".box1").trigger("click");
        });

        $(function() {
            var $form = $(".require-validation");
            $('form.require-validation').bind('submit', function(e) {
                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'
                    ].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('hide');
                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });
                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }
            });

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.danger')
                        .attr('style', 'display:block;')
                        .find('.error-messages')
                        .text(response.error.message);
                } else {
                    /* token contains id, last4, and card type */
                    var token = response['id'];
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }
        });

        function selectState(state, dropDown) {
            $('#' + dropDown + ' option').each(function(key, val) {
                if (key > 0) {
                    if (state == $(this).val()) {
                        $(this).attr('selected', 'selected');
                    }
                }
            });
        }
        selectState($('#shipState').val(), 'billingState');
    </script>
@endpush
