@extends('layouts.frontend.master')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/style.css') }}">

    <style>
        .danger{
            background-color: #da0000;
            color: white;
            text-align: center;
            font-size: 25px;
            padding: 10px;
        }

        .success{
            background-color: #d4b14a;
            color: white;
            text-align: center;
            font-size: 25px;
            padding: 10px;
        }
    </style>
@endpush

@section('content')

    @if(Session::has('type'))
        <div class="{{Session::get('type')}}">
            <div class="container">
                <p>{{ Session::get('message') }}</p>
            </div>
        </div>
    @endif

    <div class="red-div">
        <div class="container">
            <p><b>WARNING:</b> Due to the increased demand for Adken, we cannot guarantee enough supply for the
                next coming weeks. Get yours today while <strong>stocks are still available</strong> and receive your
                order within 24 hours of purchase.</p>
        </div>
    </div>

    <div class="section-1">
        <div class="container">
            <div class="top_left">
                <div class="top_left_inner">
                    <img src="{{ asset('assets/frontend/images/product.png') }}" class="product-sec1" alt="product">
                    <div class="top_left1">
                        <span>Limited-Time Offer Exclusively<br>Available To U.S. Residents Only</span>
                        <img src="{{ asset('assets/frontend/images/logo_uk.png') }}" alt="" width="37"
                            height="28">
                    </div>
                    <div class="top_left2">
                        <img src="{{ asset('assets/frontend/images/logo.png') }}" alt="logo" class="sec1-logo">
                    </div>
                    <div class="top_left3">
                        <img src="{{ asset('assets/frontend/images/sec1-heading.png') }}" alt="">
                    </div>
                    <div class="top_left4">
                        <ul>
                            <li>
                                <span>Reduces Fine Lines And Wrinkles</span>
                                <p>
                                    <img src="{{ asset('assets/frontend/images/star.png') }}" alt=""
                                        width="17" height="15">
                                    <img src="{{ asset('assets/frontend/images/star.png') }}" alt=""
                                        width="17" height="15">
                                    <img src="{{ asset('assets/frontend/images/star.png') }}" alt=""
                                        width="17" height="15">
                                </p>
                            </li>
                            <li>
                                <span>Moisturizes And Rehydrates Your Skin</span>
                                <p>
                                    <img src="{{ asset('assets/frontend/images/star.png') }}" alt=""
                                        width="17" height="15">
                                    <img src="{{ asset('assets/frontend/images/star.png') }}" alt=""
                                        width="17" height="15">
                                    <img src="{{ asset('assets/frontend/images/star.png') }}" alt=""
                                        width="17" height="15">
                                    <img src="{{ asset('assets/frontend/images/star.png') }}" alt=""
                                        width="17" height="15">
                                </p>
                            </li>
                            <li>
                                <span>Restores And Revitalizes Your Youthful Glow</span>
                                <p>
                                    <img src="{{ asset('assets/frontend/images/star.png') }}" alt=""
                                        width="17" height="15">
                                    <img src="{{ asset('assets/frontend/images/star.png') }}" alt=""
                                        width="17" height="15">
                                    <img src="{{ asset('assets/frontend/images/star.png') }}" alt=""
                                        width="17" height="15">
                                    <img src="{{ asset('assets/frontend/images/star.png') }}" alt=""
                                        width="17" height="15">
                                    <img src="{{ asset('assets/frontend/images/star.png') }}" alt=""
                                        width="17" height="15">
                                </p>
                            </li>
                        </ul>
                    </div>
                    <div class="top_left5">
                        HURRY! GET YOUR BOTTLE TODAY
                        <div class="bnr-slider"></div>
                    </div>
                    <div id="reminder">
                        <p class="mb10">
                            <span class="bl">ONLY 1 ORDER PER CUSTOMER<br>ORDER WHILE SUPPLIES LAST!</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="top_right">
                <div id="side_arrow" class="side_arrow">
                    <img src="{{ asset('assets/frontend/images/sec1-arrow.png') }}">
                </div>
                <div class="form">
                    <div class="top_form" id="form-top">ONLY <span class="timer"><span>
                                2</span><span>5</span><span>0</span></span> ORDERS available now!</div>
                    <div class="form_bl">
                        <div class="form_header">Tell Us Where to send <span>Your bottle</span> </div>
                        <form method="POST" action="{{ route('index.process') }}" name="prospect_form1"
                            class="noexirpop custom-validation" id="form1" novalidate>
                            @csrf
                            <div class="text">
                                <label for="name">First Name:</label>
                                <input type="text" name="first_name" placeholder="First Name" id="name" data-parsley-required-message="Please enter first name" required>
                                
                            </div>
                            <div class="text">
                                <label for="shipLastName">Last Name:</label>
                                <input type="text" name="last_name" id="shipLastName" placeholder="Last Name" data-parsley-required-message="Please enter last name"
                                    required>
                            </div>
                            <div class="text">
                                <label for="address">Address:</label>
                                <input type="text" name="address" id="address" placeholder="Your Address" data-parsley-required-message="Please enter address" required>
                            </div>
                            <div class="text">
                                <label for="city">City:</label>
                                <input type="text" name="city" id="city" placeholder="Your City" data-parsley-required-message="Please enter city name" required>
                            </div>
                            <div class="text">
                                <label for="fields_state">State:</label>
                                <select name="shipState" class="required" id="fields_state" data-parsley-required-message="Please select state" required>
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
                            <div class="text">
                                <label for="zipcode">Zip:</label>
                                <input type="text" name="zipcode" id="zipcode" placeholder="Zip Code" data-parsley-required-message="Please enter zipcode" required>
                            </div>
                            <div class="text">
                                <label for="phone">Phone:</label>
                                <input type="text" name="phone" id="phone" placeholder="Phone" class="onlynumeric" data-parsley-required-message="Please enter phone" required>
                            </div>
                            <div class="text">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" placeholder="Email Address" data-parsley-required-message="Please enter email" required>
                            </div>
                            <div id="form-btm">
                                <div class="form-button">
                                    <button type="submit" class="btn pulse">RUSH MY ORDER</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="inner-sections">
        <div class="container">
            <div class="section2" style="background:#fff; width:100%; float:left;">
                <div class="heading">
                    <span>FEATURED</span> The New Anti-Aging Secret Behind Adken
                </div>
                <!--===/*Section FEATURED*/===-->
                <div class="featured_block">
                    <div class="featured_block_left">
                        <p>Collagen accounts for 75% of your skin's elasticity and suppleness. It's what makes you look
                            young in your teens. But as you reach your 20's, your collagen production starts to decrease
                            by over 1% annually. So by that time you're in your 70s, your body is receiving nearly 70%
                            less collagen than you were in your teens.</p>
                        <p>
                            While collagen creams can be helpful, most consumers don’t realize that the size of its
                            molecules are often too large to penetrate your skin effectively. This makes it almost
                            impossible to achieve the promises most brands try to sell to you. </p>
                        <p>
                            That’s why the secret to the amazing new Adken is its use of “hydrolyzed” marine
                            collagen peptides which are actually smaller than your pores! Plus this stunning new
                            ingredient has been shown to have superior "bioavailability" than other sources, which means
                            it can enter your skin quicker than other types of collagen. So it’s not a surprise that
                            Adken is considered one of the best sources of Marine Collagen to replenish your
                            depleted collagen stores, rejuvenate your skin, and add firmness to your skin with regular
                            use. </p>
                        <br>
                        <img src="{{ asset('assets/frontend/images/graph.jpg') }}" alt="" width="434"
                            height="287">
                    </div>
                    <div class="featured_block_right">
                        <img src="{{ asset('assets/frontend/images/doc_img.jpg') }}" alt="" width="388"
                            height="472">
                        <img src="{{ asset('assets/frontend/images/before_after.png') }}" alt=""
                            width="419" height="262" class="before_after">
                    </div>
                    <div class="clearall"></div>
                </div>
            </div>
            <div class="clearall"></div>
            <!--===/*Section SPOTLIGHT*/===-->
            <div class="spotlight">
                <div class="spotlight_heading_img">
                    <img src="{{ asset('assets/frontend/images/inspot_img.png') }}" alt="" width="312"
                        height="84">
                </div>
                <div class="spotlight_heading">
                    <span>THE BENEFITS OF Adken</span>All-Day Moisturizer
                </div>
                <div class="spotlight_list">
                    <ul>
                        <li>
                            <b>Reduces Visible Fine Lines And Wrinkles</b> Marine Collagen peptides in Adken go
                            underneath the skin to help retain moisture and improve texture while protecting your face
                            from further damage.
                        </li>
                        <li>
                            <b>Promotes Healing And Rejuvenation</b> Retinol in Adken helps speed up cellular renewal
                            by removing dead skin cells from your face. This allows newer skin to rise, helping you
                            attain a smoother,<br> more vibrant tone.
                        </li>
                        <li>
                            <b>24/7 Skin Protection You Can Feel</b> Enriched with Vitamin C to protect you against the
                            free radicals that are responsible for breakouts, irritation and sun damage.
                        </li>
                        <li>
                            <b>Youth-Boosting Formula Combats Skin Aging</b> The unique combination of nutrients allows
                            for deep-tissue moisturization to help reduce signs of aging like uneven skin tone, large
                            pores, age marks, and sagging skin.
                        </li>
                    </ul>
                </div>
            </div>

            <!--===/*Section CTA*/===-->
            <div class="btn_block">
                <span class="btn_block_txt">
                    <b>ENJOY RADIANT, YOUNGER-LOOKING SKIN IN JUST WEEKS!</b>
                    Adken All-Day Moisturizer Stocks Are Limited. Order Yours today!
                </span>
                <a href="javascript:bookmarkscroll.scrollTo('top')" class="rush_btn pulse"></a>
            </div>

            <!--===/*Section exclusive*/===-->
            <div class="exclusive">
                <div class="heading">
                    <span>EXCLUSIVE</span> Enjoy Naturally Younger, Healthier Skin
                </div>
                <div class="featured_block">
                    <div class="featured_block_left">
                        <ul>
                            <li>NO PAINFUL SURGERIES</li>
                            <li>NO EXPENSIVE LOTIONS</li>
                            <li>NO HARMFUL PILLS</li>
                        </ul>
                        <p>When you were young, your skin was supple, smooth, and full of glow. But as it was exposed to
                            harmful elements like wind, pollution, dust, free radicals, and sunlight, your skin lost its
                            elasticity and suppleness which leads to dryness, sagginess, and uneven tone.
                        </p>

                        <p>All of these factors result in your skin’s inability to retain its firmness and elasticity.
                            Worse, your advancing age is responsible for the further breakdown of your skin’s building
                            blocks: collagen. And with collagen continuing to dwindle, your face starts to show its true
                            age by way of enlarged pores, fine lines, saggy skin, and deep wrinkles.</p>

                        <p>Thankfully, you can reverse these signs of aging as early as today by choosing the perfect
                            marine-collagen skincare routine found in Adken!</p>
                    </div>
                    <div class="featured_block_right">
                        <img src="{{ asset('assets/frontend/images/product_silk.jpg') }}" alt=""
                            width="485" class="silk-jar">
                        <img src="{{ asset('assets/frontend/images/product.png') }}" alt=""
                            class="product-excl">
                        <p class="rgt-quote1">
                            Say ‘goodbye’ to expensive pills, creams, and surgeries. Stay beautiful naturally. Order
                            your exclusive bottle,<br>risk-free right now!
                        </p>
                    </div>
                    <div class="clearall"></div>
                </div>
            </div>

            <!--===/*Layer 6*/===-->
            <div class="layer-6-body">
                <div class="layer-6-body-left">
                    <img src="{{ asset('assets/frontend/images/layer-6-img.jpg') }}" alt="" width="506"
                        height="505">
                    <div class="circle-content">
                        <h2>#Adken</h2>
                        <p>its Unanimous!</p>
                    </div>
                    <img src="{{ asset('assets/frontend/images/product.png') }}" alt="" width="74"
                        height="80" class="lay-6-prod">

                </div>
                <div class="layer-6-body-right">
                    <div class="heading">
                        <span>SPOTLIGHT</span> What’s all the buzz about?
                    </div>
                    <div class="layer-6-txt1">
                        <p>The Latest Surgery-Free Breakthrough</p>
                    </div>
                    <div class="layer-6-txt2">
                        <p>Have you asked yourself why Hollywood celebrities can look so young, vibrant, and beautiful
                            well beyond their actual age? To achieve that smooth, Hollywood complexion, celebrities only
                            look for youth-boosting creams that offer protection, rejuvenation, and restoration for
                            smooth, supple, wrinkle-free skin.</p>
                    </div>
                    <div class="layer-6-txt3">
                        <p>
                            Adken gives you a similar type of “Hollywood skin treatment” so you can achieve
                            radiant, glowing skin. Now, you can get the skin you’ve been dreaming of without enduring
                            the physical pain and expense of costly procedures and surgeries. Adken naturally
                            hydrates your skin to replenish lost moisture, restore a youthful glow, and reduce the signs
                            of aging.</p>
                    </div>
                    <div class="layer-6-txt4">
                        <img src="{{ asset('assets/frontend/images/layer-6-right.jpg') }}" alt=""
                            width="392" height="121">
                    </div>
                    <div class="clearall"></div>
                </div>
                <div class="clearall"></div>
            </div>

            <div class="clearall"></div>
            <div class="btn_block">
                <span class="btn_block_txt">
                    <b>ENJOY RADIANT, YOUNGER-LOOKING SKIN IN JUST WEEKS!</b>
                    Adken All-Day Moisturizer Stocks Are Limited. Order Yours today!
                </span>
                <a href="javascript:bookmarkscroll.scrollTo('top')" class="rush_btn pulse"></a>
            </div>

            <!--===/*Layer 7*/===-->
            <div class="layer-7-imgs">
                <img src="{{ asset('assets/frontend/images/vitalize.jpg') }}" alt="" width="321"
                    height="304">
                <img src="{{ asset('assets/frontend/images/replenish.jpg') }}" alt="" width="321"
                    height="303">
                <img src="{{ asset('assets/frontend/images/moisturize-3.jpg') }}" alt="" width="321"
                    height="302">
            </div>

            <div class="clearall"></div>
            <div class="btn_block">
                <span class="btn_block_txt">
                    <b>ENJOY RADIANT, YOUNGER-LOOKING SKIN IN JUST WEEKS!</b>
                    Adken All-Day Moisturizer Stocks Are Limited. Order Yours today!
                </span>
                <a href="javascript:bookmarkscroll.scrollTo('top')" class="rush_btn pulse"></a>
            </div>

            <!--===/*Bottom part*/===-->
            <div class="foot-part-1">
                <div class="heading">
                    <span>Limited Time Offer</span> Special Offer Only Available to First Time Users
                </div>
                <div class="foot-part1-tag"><img src="{{ asset('assets/frontend/images/premium-tag.png') }}"
                        alt="" width="140" height="140"></div>
                <div class="foot-part1-bottle"><img src="{{ asset('assets/frontend/images/product.png') }}"
                        alt="" width="320"></div>
                <div class="foot-part1-logo"><img src="{{ asset('assets/frontend/images/logo.png') }}" alt=""
                        width="220"></div>
                <div class="foot-part1-achieve"><img src="{{ asset('assets/frontend/images/achieve-txt.png') }}"
                        alt=""></div>
                <div class="foot-part1-button">
                    <div class="" style="margin-left: 30px;">
                        <a href="javascript:bookmarkscroll.scrollTo('top')" class="rush_btn pulse"></a>
                    </div>
                </div>
                <div class="clearall"></div>
            </div>
        </div>

        <footer>
            <div class="container">
                <p>Disclaimer: This product has not been evaluated by the FDA. This product is not intended to diagnose,
                    treat, cure or prevent any disease. Results in description are illustrative and may not be typical
                    results and individual results may vary. The depictions on this page are fictitious and indicative
                    of potential results. Representations regarding the efficacy and safety of Adken have not
                    been scientifically substantiated or evaluated by the Food and Drug Administration.</p>
                <p>&nbsp;</p>
                @include('footer')
            </div>
        </footer>
    </div>

    <div class="cta viewing" id="viewing-lp" style="opacity:1;">
        <span class="close">x</span>
        <p class="f-size">13 others are viewing this offer right now - <span id="count-up"
                class="count-up bl">0:00</span> <br>
            <a href="javascript:bookmarkscroll.scrollTo('top')">Claim Your Free Botttle Now!</a>
        </p>
    </div>
@endsection

@push('scripts')
    {{-- <script type="text/javascript" src="{{ asset('assets/frontend/js/scripts.js') }}"></script> --}}
    <script src="{{ asset('assets/backend/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/pages/form-validation.init.js') }}"></script>
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/frontend/js/scripting.js') }}"></script>
    <script type="text/javascript">
        $(document).scroll(function() {
            if (window.scrollY > 100) {
                $('#side_arrow').removeClass('side_arrow_up');
                $('#side_arrow').addClass('side_arrow');

            } else {
                $('#side_arrow').removeClass('side_arrow');
                $('#side_arrow').addClass('side_arrow_up');
            }
        })

        $(document).ready(function(e) {
            $('#reminder').delay(5350).animate({
                'bottom': 24
            });
            $('#reminder p').delay(3800).animate({
                'opacity': 1
            });

            $('#side_arrow').removeClass('side_arrow');
            $('#side_arrow').addClass('side_arrow_up');

            $('.fancybox').fancybox();

            //INDEX PAGE TIMER BOX
            $(window).on("load", function() {
                $('#viewing').delay(1000).animate({
                    'opacity': 1
                });
            });

            var min = 0;
            var second = 00;
            var zeroPlaceholder = 0;
            var counterId = setInterval(function() {
                countUp();
            }, 1000);

            function countUp() {
                second++;
                if (second == 59) {
                    second = 00;
                    min = min + 1;
                }
                if (second == 10) {
                    zeroPlaceholder = '';
                } else
                if (second == 00) {
                    zeroPlaceholder = 0;
                }

                $('.count-up').html(min + ':' + zeroPlaceholder + second);
            }

            $('.close').click(function() {
                $('#viewing-lp').hide();
            });

        });

        (function() {
            var idDisplayOnScroll = document.getElementById('viewing-lp');

            function showOnScroll() {
                if (window.scrollY > 100) {
                    idDisplayOnScroll.style.opacity = 1;
                } else {
                    idDisplayOnScroll.style.opacity = 0;
                }
            }
            window.addEventListener("scroll", showOnScroll);

            $('.close').click(function() {
                $('#viewing-lp').hide();
            });
        })();

        // LP  FORM COUNTER = 599;
        var one = 0;
        var ten = 0;
        var hundered = 6;
        var intervalId = setInterval(function() {
            time();
        }, .7);

        function time() {
            one--;
            if (one == -1) {
                ten = ten - 1;
                one = 0 + 9;
            }
            if (ten == -1) {
                hundered = hundered - 1;
                ten = 0 + 9;
            }
            var wholeNum = hundered + '' + ten + '' + one;
            if (wholeNum == 250) {
                clearInterval(intervalId);
            }
            $('.timer').html('<span>' + hundered + '</span><span>' + ten + '</span><span>' + one + '</span>');
        }
    </script>
@endpush
