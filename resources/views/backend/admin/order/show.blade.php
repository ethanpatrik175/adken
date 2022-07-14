@extends('layouts.backend.master')
@section('title')
    {{ __('All Products') }}
@endsection
@section('styles')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
@endsection
@section('page-content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ __('Order') }}</h4>
                        {{-- <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('Order') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('Order') }}</li>
                            </ol>
                        </div> --}}
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php
            // dd($shipping_detail);
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-0">Order detail of the #{{ $orders->order_number }}</h4>

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="mt-4">
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                        aria-expanded="true" aria-controls="collapseOne">
                                                        Order Detail
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse show"
                                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <table class="table">
                                                            <tr>
                                                                <th>
                                                                    Order Number
                                                                </th>
                                                                <td>
                                                                    {{ $orders->order_number }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Quantity
                                                                </th>
                                                                <td>
                                                                    {{ $orders->quantity }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Sub Total
                                                                </th>
                                                                <td>
                                                                    ${{ $orders->sub_total }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Shipping Charges
                                                                </th>
                                                                <td>
                                                                    ${{ $orders->shipping_charges }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Total Amount
                                                                </th>
                                                                <td>
                                                                    ${{ $orders->total }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Description
                                                                </th>
                                                                <td>
                                                                    {{ $orders->description }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingfour">
                                                    <button class="accordion-button fw-medium collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapsefour"
                                                        aria-expanded="false" aria-controls="collapsefour">
                                                        Product Detail
                                                    </button>
                                                </h2>
                                                <div id="collapsefour" class="accordion-collapse collapse"
                                                    aria-labelledby="headingfour" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <table class="table">
                                                            <tr>
                                                                <th>
                                                                    Name
                                                                </th>
                                                                <td>
                                                                    {{ $product->name }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Sale Price
                                                                </th>
                                                                <td>
                                                                    ${{ $product->sale_price }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Shipping Charges
                                                                </th>
                                                                <td>
                                                                    ${{ $product->shipping_charges }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Image
                                                                </th>
                                                                <td>
                                                                    <img
                                                                        src="{{ asset('assets/frontend/images/products/' . $product->image) }}">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingTwo">
                                                    <button class="accordion-button fw-medium collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                        aria-expanded="false" aria-controls="collapseTwo">
                                                        Payment Detail
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse"
                                                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <table class="table">
                                                            <tr>
                                                                <th>
                                                                    Brand
                                                                </th>
                                                                <td>
                                                                    {{ $payment_method_detail->brand }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Country
                                                                </th>
                                                                <td>
                                                                    {{ $payment_method_detail->country }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Card last digit
                                                                </th>
                                                                <td>
                                                                    {{ $payment_method_detail->last4 }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Card Network
                                                                </th>
                                                                <td>
                                                                    {{ $payment_method_detail->network }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingThree">
                                                    <button class="accordion-button fw-medium collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                        aria-expanded="false" aria-controls="collapseThree">
                                                        Shiping Detail
                                                    </button>
                                                </h2>
                                                <div id="collapseThree" class="accordion-collapse collapse"
                                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <table class="table">
                                                            <tr>
                                                                <th>
                                                                    First Name
                                                                </th>
                                                                <td>
                                                                    {{ $shipping_detail->first_name }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Last Name
                                                                </th>
                                                                <td>
                                                                    {{ $shipping_detail->last_name }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Address
                                                                </th>
                                                                <td>
                                                                    {{ $shipping_detail->address }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    City
                                                                </th>
                                                                <td>
                                                                    {{ $shipping_detail->city }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Shipper State
                                                                </th>
                                                                <td>
                                                                    {{ $shipping_detail->shipState }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    ZipCode
                                                                </th>
                                                                <td>
                                                                    {{ $shipping_detail->zipcode }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Phone
                                                                </th>
                                                                <td>
                                                                    {{ $shipping_detail->phone }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Email
                                                                </th>
                                                                <td>
                                                                    {{ $shipping_detail->email }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- billing Detail -->
                                            <?php
                                            // dd($Billings_details);
                                            ?>


                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingfive">
                                                    <button class="accordion-button fw-medium collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapsefive"
                                                        aria-expanded="false" aria-controls="collapsefive">
                                                        Billing Detail
                                                    </button>
                                                </h2>
                                                <div id="collapsefive" class="accordion-collapse collapse"
                                                    aria-labelledby="headingfive" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        @if ($Billings_details == null)
                                                            <p>Billings Detail And Shipping Detail are Same </p>
                                                        @else<table class="table">
                                                                <tr>
                                                                    <th>
                                                                        Address
                                                                    </th>
                                                                    <td>
                                                                        {{ $Billings_details->address1 }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        City
                                                                    </th>
                                                                    <td>
                                                                        {{ $Billings_details->city }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        Billing Zip
                                                                    </th>
                                                                    <td>
                                                                        {{ $Billings_details->billingZip }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        Billing State
                                                                    </th>
                                                                    <td>
                                                                        {{ $Billings_details->billingState }}
                                                                    </td>
                                                                </tr>

                                                            </table>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <!-- end accordion -->
                                    </div>
                                </div>
                                <!-- end col -->


                            </div>
                            <!-- end row -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/backend/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/pages/form-validation.init.js') }}"></script>
    <!-- form mask -->
    <script src="{{ asset('assets/backend/libs/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
    <!-- form mask init -->
    <script src="{{ asset('assets/backend/js/pages/form-mask.init.js') }}"></script>
    <script src="{{ asset('assets/backend/ckeditor/ckeditor.js') }}"></script>
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }
    </script>
@endsection
