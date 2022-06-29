@extends('layouts.frontend.master')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/checkout.css') }}">
    <style type="text/css">
        .fancybox-margin {
            margin-right: 17px;
        }

        .danger {
            background-color: #da0000;
            color: white;
            text-align: center;
            font-size: 25px;
            padding: 10px;
        }

        .success {
            background-color: #00ad00;
            color: white;
            text-align: center;
            font-size: 25px;
            padding: 10px;
        }
    </style>
@endpush

@section('title')
    <title>{{ config('app.name') }} | Summary</title>
@endsection

@section('content')
    <div class="chk-bg">
        <div class="container">

            @if (Session::has('type'))
                <div class="{{ Session::get('type') }}">
                    <div class="container">
                        <p>{{ Session::get('message') }}</p>
                    </div>
                </div>
            @endif

            <div class="cp-box">
                <div class="chk-header-top">
                    <img src="{{ asset('assets/frontend/images/logo.png') }}" alt="" class="chk-logo">
                    <img src="{{ asset('assets/frontend/images/chk-last-img.png') }}" alt="" class="chk-steps">
                    <div class="chk-ex-offer">
                        <img src="{{ asset('assets/frontend/images/logo_uk.png') }}" alt="">
                        <p>Internet Exclusive Offer<br> Available to US Residents Only</p>
                    </div>
                </div>
                <div class="chk-cont-bg">
                    @csrf
                    <div class="lft-box">
                        <h2 class="cp-leftHeading"><span>Selected Package</span></h2>
                        <?php $counter = 1; ?>
                        @forelse ($products as $product)
                            <?php
                            $productPrice = $product->sale_price > 0 && $product->retail_price > $product->sale_price ? number_format($product->sale_price, 2) : number_format($product->retail_price, 2);
                            $subTotal = number_format($productPrice * $product->quantity, 2);
                            $total = number_format($subTotal + $product->shipping_charges, 2);
                            ?>
                            <div class="box{{ $product->id }} {{ $counter == 1 ? 'selected' : '' }}"
                                data-sub-total="{{ $subTotal }}" data-total="{{ $total }}"
                                data-summary-image="{{ asset('assets/frontend/images/products/' . $product->summary_image) }}"
                                data-offer-qty="{{ $product->quantity ?? 0 }}"
                                data-shipping-charges="{{ $product->shipping_charges ?? 0 }}"
                                onclick='selectProduct("box{{ $product->id }}")'>
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
                                        src="{{ asset('assets/frontend/images/' . $products[0]->summary_image) }}"
                                        alt="" class="bottle-chk">
                                </div>
                                <img src="{{ asset('assets/frontend/images/united.png') }}" class="united">
                            </div>
                            <div class="rgt-prc-box">
                                <p class="prd-name"><span>Adkin</span> <br>Collagen Retinol Cream</p>
                                <div class="sum-prd-prc">
                                    <div class="sum-prd-lft">
                                        <p id="prd-btl">{{ $order->quantity }} Months Supply</p>
                                    </div>
                                    <div class="sum-prd-rgt">
                                        <p id="prd-prc">${{ $order->sub_total / $order->quantity }}</p>
                                    </div>
                                </div>
                                <div class="sum-prd-prc sh">
                                    <div class="sum-prd-lft">
                                        <p>Shipping &amp; Handling:</p>
                                    </div>
                                    <div class="sum-prd-rgt">
                                        <p id="sh-prc">${{ $order->shipping_charges }}</p>
                                    </div>
                                </div>
                                <div class="sum-prd-prc" style="padding-top:10px;">
                                    <div class="sum-prd-lft">
                                        <p>Total:</p>
                                    </div>
                                    <div class="sum-prd-rgt">
                                        <p id="tot-prd-prc">${{ $order->total }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chk-rgt-box">
                        <div class="rgt-prc-box">
                            <p class="prd-name"><span>Shipping Address</span>
                                <hr />
                            </p>
                            <?php $shipping = json_decode($order->shipping_details, true); ?>
                            <div class="sum-prd-prc">
                                <div class="sum-prd-lft">
                                    <p id="prd-btl"> <strong>Name:
                                        </strong>{{ $shipping['first_name'] . ' ' . $shipping['last_name'] ?? '' }}</p>
                                </div>
                            </div>
                            <div class="sum-prd-prc">
                                <div class="sum-prd-lft">
                                    <p id="prd-btl"> <strong>Address: </strong>{{ $shipping['address'] ?? '' }}</p>
                                </div>
                            </div>
                            <div class="sum-prd-prc">
                                <div class="sum-prd-lft">
                                    <p id="prd-btl"> <strong>City: </strong>{{ $shipping['city'] ?? '' }}</p>
                                </div>
                            </div>
                            <div class="sum-prd-prc">
                                <div class="sum-prd-lft">
                                    <p id="prd-btl"> <strong>Zipcode: </strong>{{ $shipping['zipcode'] ?? '' }}</p>
                                </div>
                            </div>
                            <div class="sum-prd-prc">
                                <div class="sum-prd-lft">
                                    <p id="prd-btl"> <strong>Phone: </strong>{{ $shipping['phone'] ?? '' }}</p>
                                </div>
                            </div>
                            <div class="sum-prd-prc">
                                <div class="sum-prd-lft">
                                    <p id="prd-btl"> <strong>Email: </strong>{{ $shipping['email'] ?? '' }}</p>
                                </div>
                            </div>
                            <hr />
                            <p class="prd-name"><span>Order Status</span>
                                <hr />
                            </p>
                            <div class="sum-prd-prc">
                                <div class="sum-prd-lft">
                                    <p id="prd-btl"> <strong>Status: </strong>{{ $order->status ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
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