@extends('layouts.backend.master')
@section('title')
    {{ 'Edit & Update Order' }}
@endsection
@section('additional-css')
    <!-- DataTables -->
    <link href="{{ asset('assets/backend/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">EDIT & UPDATE ORDER</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Orders</a></li>
                                    <li class="breadcrumb-item active">Edit & Update Order</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        @if (Session::has('message'))
                            <div class="alert alert-{{ Session::get('type') }} alert-dismissible fade show col-sm-12"
                                role="alert">
                                {{ Session::get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="col-12 message"></div>
                    <div class="col-12 mb-2">
                        <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-primary">ALL ORDERS</a>
                        <a href="{{ route('admin.add.order') }}" class="btn btn-sm btn-success">ADD NEW</a>
                        <a href="#" class="btn btn-sm btn-danger">TRASH</a>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">ORDER DETAIL</h4>
                                <p class="card-title-desc"></p>

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                            <span class="d-block d-sm-none"><i class="bx bx-home"></i></span>
                                            <span class="d-none d-sm-block">ORDER DETAILS</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                                            <span class="d-block d-sm-none"><i class="bx bxl-product-hunt"></i></span>
                                            <span class="d-none d-sm-block">ORDER ITEMS</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#settings" role="tab">
                                            <span class="d-block d-sm-none"><i class="bx bx-history"></i></span>
                                            <span class="d-none d-sm-block">ORDER HISTORY</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#payment" role="tab">
                                            <span class="d-block d-sm-none"><i class="bx bx-history"></i></span>
                                            <span class="d-none d-sm-block">Charge Payment</span>
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content p-3 text-muted">
                                    <div class="tab-pane active" id="home" role="tabpanel">
                                        <div class="invoice-title">
                                            <h4 class="float-right font-size-16">Order # {{ $order->order_number }}</h4>
                                            <div class="mb-4">
                                                <h4 class="font-size-16">Customer:
                                                    {{ $order->customer_first_name . ' ' . $order->customer_last_name }}</h4>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <address>
                                                    <strong>Billing Address:</strong><br>
                                                    {!! $billing_address !!}
                                                </address>
                                            </div>
                                            <div class="col-sm-6 text-sm-right">
                                                <address class="mt-2 mt-sm-0">
                                                    <strong>Shipping Address:</strong><br>
                                                    {!! $shipping_address !!}
                                                </address>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 mt-3">
                                                <table style="width:100%;">
                                                    <tr>
                                                        <td>
                                                            <address>
                                                                <strong>Payment Method:</strong><br>
                                                                @if ($order->payment_method == 'card')
                                                                    {{ 'Credit Card' }}
                                                                @elseif($order->payment_method == 'n_terms')
                                                                    {{ 'N Terms' }}
                                                                @elseif($order->payment_method == 'ach')
                                                                    {{ 'ACH Transfer' }}
                                                                @else
                                                                    {{ 'Not Found!' }}
                                                                @endif
                                                            </address>
                                                        </td>
                                                        <td>
                                                            <address>
                                                                <strong>Payment Status:</strong><br>
                                                                {{-- @dd(json_decode($order->payment_details, true)) --}}
                                                                @if (isset($order->payment_status))
                                                                    {{ Str::upper($order->payment_status) }}
                                                                @else
                                                                    {{ 'Not Found!' }}
                                                                @endif

                                                            </address>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                            <div class="col-sm-6 mt-3 text-sm-right">
                                                <address>
                                                    <strong>Order Date:</strong><br>
                                                    {{ date('Y-m-d h:i:s A', strtotime($order->created_at)) }}<br><br>
                                                </address>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <address>
                                                    <strong>Current Order Status:</strong><br>
                                                    @if ($order->status == 'new')
                                                        {{ Str::of('Pending')->upper() }}
                                                    @else
                                                        {{ Str::of($order->status)->upper() }}
                                                    @endif
                                                </address>
                                            </div>
                                            <div class="col-sm-6 text-sm-right">
                                                <address>
                                                    <strong>Order Instruction:</strong><br>
                                                    @if (isset($order->instructions))
                                                        {{ $order->instructions }}
                                                    @else
                                                        {{ 'No Instructions' }}
                                                    @endif
                                                </address>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 mt-3">
                                                <div class="form-group row mb-3">
                                                    <div class="col-sm-10">
                                                        <label for="start_date">ORDER STATUS</label>
                                                        <div class="input-group">
                                                            @if ($order->status == 'removed')
                                                            @else
                                                                @if ($order->status == 'completed')
                                                                    <select name="order_status" id="order_status"
                                                                        class="form-control select2 order_status">
                                                                        <option value="" selected="selected"
                                                                            disabled="disabled">Select Status</option>
                                                                        <option value="refund">Refund</option>
                                                                        <option value="return">Return</option>
                                                                    </select>
                                                                @else
                                                                    <select name="order_status" id="order_status"
                                                                        class="form-control select2 order_status">
                                                                        <option value="" selected="selected"
                                                                            disabled="disabled">Select Status</option>
                                                                        <option value="processing">Processing</option>
                                                                        <option value="shipped">Shipped</option>
                                                                        <option value="cancelled">Cancelled</option>
                                                                        <option value="removed">Removed</option>
                                                                        <option value="completed">Completed</option>
                                                                    </select>
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <label class="text-danger order-status-error"
                                                            style="display:none;"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <div class="col-sm-10">
                                                        <label for="start_date">DESCRIPTION NOTE</label>
                                                        <div class="input-group">
                                                            <textarea name="description_note" id="description_note" placeholder="Write The Descriptive Note Here"
                                                                class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-10 justify-content-end pt-3 mt-2">
                                                        <button type="button" class="btn btn-primary"
                                                            id="update-order-status" data-id="{{ $order->id }}">Update
                                                            Status</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($order->payment_method == 'n_terms')
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <hr />
                                                    <label class="text-danger n-terms-error" style="display:none;"></label>
                                                    <div class="n-terms-message"></div>
                                                    <div class="form-group row mb-3">
                                                        <div class="col-sm-10">
                                                            <label for="start_date">N-TERMS TTILE</label>
                                                            <div class="input-group">
                                                                <input type="text" name="n_terms_title" id="n_terms_title"
                                                                    class="form-control"
                                                                    placeholder="Enter N-Terms Title eg. n10 terms, n30 terms etc."
                                                                    value="{{ $orderNTerms->n_terms_title ?? '' }}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <div class="col-sm-10">
                                                            <label for="n_terms_description">N-TERMS DESCRIPTION</label>
                                                            <div class="input-group">
                                                                <textarea name="n_terms_description" id="n_terms_description" class="form-control"
                                                                    placeholder="N Terms Description">{!! $orderNTerms->n_terms_description ?? '' !!}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-10">
                                                            <button type="button" class="btn btn-primary"
                                                                id="update-n-terms" data-id="{{ $order->id }}">Update
                                                                N-Terms</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                        @endif
                                        <div class="row">
                                            <div class="col-sm-12 mt-3">
                                                <hr />
                                                <div class="payment-status-message"></div>
                                                <div class="form-group row mb-3">
                                                    <div class="col-sm-3">
                                                        <label for="payment_status">PAYMENT STATUS</label>
                                                        <div class="input-group">
                                                            @if (isset($order->payment_status) && $order->payment_status == 'paid')
                                                                <select name="payment_status" id="payment_status"
                                                                    class="form-control select2 payment_status">
                                                                    <option value="paid" selected="selected"
                                                                        disabled="disabled">PAID</option>
                                                                </select>
                                                            @else
                                                                <select name="payment_status" id="payment_status"
                                                                    class="form-control select2 payment_status">
                                                                    <option value="" selected="selected"
                                                                        disabled="disabled">Select Status</option>
                                                                    <option value="due"
                                                                        @if ($order->payment_status == 'due') {{ 'selected' }} @endif>
                                                                        DUE</option>
                                                                    <option value="paid"
                                                                        @if ($order->payment_status == 'paid') {{ 'selected' }} @endif>
                                                                        PAID</option>
                                                                </select>
                                                            @endif
                                                        </div>
                                                        <label class="text-danger payment-status-error"
                                                            style="display:none;"></label>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="payment_method">PAYMENT METHOD</label>
                                                        <select class="form-control select2" name="payment_method"
                                                            id="payment_method" required="required">
                                                            <option value="" selected="selected" disabled>Select Payment
                                                                Method</option>
                                                            <option value="card"
                                                                @if ($order->payment_method == 'card') {{ 'selected' }} @endif>
                                                                Credit Card</option>
                                                            <option value="ach"
                                                                @if ($order->payment_method == 'ach') {{ 'selected' }} @endif>
                                                                ACH</option>
                                                            <option value="n_terms"
                                                                @if ($order->payment_method == 'n_terms') {{ 'selected' }} @endif>
                                                                N Terms</option>
                                                        </select>
                                                        <label class="text-danger payment-method-error"
                                                            style="display:none;"></label>
                                                    </div>
                                                    <div class="col-sm-12 justify-content-end pt-3 mt-2">
                                                        @if (isset($order->payment_status) && $order->payment_status == 'paid')
                                                            <button type="button" class="btn btn-primary" disabled>Update
                                                                Payment Status</button>
                                                        @else
                                                            <button type="button" class="btn btn-primary"
                                                                id="update-payment-status"
                                                                data-id="{{ $order->id }}">Update Payment
                                                                Status</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="messages" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 70px;">No.</th>
                                                        <th>Item</th>
                                                        <th class="text-right">Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $counter = 1; ?>
                                                    @forelse($orderItems as $item)
                                                        <tr>
                                                            <td>{{ $counter++ }}</td>
                                                            <td>{{ $item->brand . ' - ' . $item->name . ' (' . $item->sku . ')' . ' x' . $item->quantity }}
                                                            </td>
                                                            <td class="text-right">
                                                                ${{ number_format($item->total_amount, 2) }}</td>
                                                        </tr>
                                                    @empty
                                                    @endforelse
                                                    <tr>
                                                        <td colspan="2" class="text-right">Sub Total</td>
                                                        <td class="text-right">
                                                            ${{ number_format($order->sub_total, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="border-0 text-right">
                                                            <strong>Discount</strong>
                                                        </td>
                                                        <td class="border-0 text-right">&minus;
                                                            ${{ number_format($order->discount_amount, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="border-0 text-right">
                                                            <strong>Total</strong>
                                                        </td>
                                                        <td class="border-0 text-right">
                                                            <h4 class="m-0">
                                                                ${{ number_format($order->grand_total, 2) }}</h4>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="settings" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 70px;">Id.</th>
                                                        <th>Status</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $counter = 1; ?>
                                                    @forelse($orderHistory as $history)
                                                        <tr>
                                                            <td>{{ $counter++ }}</td>
                                                            <td>{{ Str::upper($history->status) }}</td>
                                                            <td>{!! $history->description ?? 'Not Found!' !!}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3">No History Found!</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="payment" role="tabpanel">
                                        <div class="table-responsive">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="paymentMsg"></div>
                                                </div>
                                            </div>
                                            <form class="needs-validation" id="chargePayment"
                                                action="{{ route('admin.charge.payment') }}" method="POST" novalidate>
                                                @csrf
                                                <input type="hidden" name="orderId" id="orderId"
                                                    value="{{ $order->id }}" />
                                                <table class="table table-nowrap">
                                                    <tbody>
                                                        <tr>
                                                            <td>Sub Total</td>
                                                            <td>
                                                                ${{ number_format($order->sub_total, 2) }}
                                                                <input type="hidden" id="sub_total"
                                                                    value="{{ number_format($order->sub_total, 2) }}" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Shipping Charges($)</td>
                                                            <td>
                                                                <input type="number" min="0" step="0.1"
                                                                    class="form-control" name="shipping_charges"
                                                                    id="shipping_charges" placeholder="Shipping Charges"
                                                                    required />
                                                                <div class="invalid-feedback">
                                                                    Please enter valid Shipping Charges
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total Amount</td>
                                                            <td id="total_amount">-</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Shipping Description</td>
                                                            <td>
                                                                <textarea name="description" id="description" cols="30" rows="3" class="form-control"
                                                                    placeholder="Shipping Description"></textarea>
                                                                <div class="invalid-feedback">
                                                                    Please enter valid shipping description
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Payment Description</td>
                                                            <td>
                                                                <textarea name="payment_description" id="payment_description" cols="30" rows="3" class="form-control"
                                                                    placeholder="Payment Description"
                                                                    required></textarea>
                                                                <div class="invalid-feedback">
                                                                    Please enter valid payment description
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="text-align: end;">
                                                                <button type="submit" class="btn btn-primary">Charge
                                                                    Payment</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('backend.footer')
    </div>
@endsection

@section('additional-js')
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>
    <script type="text/javascript">
        $(document).on('click', '#update-order-status', function() {
            let status = $('#order_status').val();
            if (status == null) {
                $('.order-status-error').removeAttr('style');
                $('.order-status-error').html('Select Status First and Try again.');
            } else {
                $('.order-status-error').attr('style', 'display:none;');
                $('.order-status-error').html('');

                let url = route('admin.order.update.status');
                let id = $(this).data('id');
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        id: id,
                        status: status,
                        description: $('#description_note').val()
                    },
                    beforeSend: function() {
                        $('body').addClass('loading');
                    },
                    success: function(response) {
                        let result = JSON.parse(response);
                        if (result.type == 'error') {
                            $('.message').html(
                                '<div class="alert alert-danger alert-dismissible fade show col-sm-12" role="alert">' +
                                result.message +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                                );
                        } else if (result.type == 'success') {
                            $('.message').html(
                                '<div class="alert alert-success alert-dismissible fade show col-sm-12" role="alert">' +
                                result.message +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                                );

                            setTimeout(function() {
                                window.location.href = route('admin.edit.order', id);
                            }, 3000);
                        }
                        $('body').removeClass('loading');
                    },
                    error: function(response) {
                        console.log(response);
                        alert('Error Occured');
                    }
                });
            }
        });
        $(document).on('click', '#update-n-terms', function() {
            let title = $('#n_terms_title').val();
            let description = CKEDITOR.instances.n_terms_description.getData();

            if ((title == '')) {
                $('.n-terms-error').removeAttr('style');
                $('.n-terms-error').html('Enter Terms Title');
            } else {
                $('.n-terms-error').attr('style', 'display:none;');
                $('.n-terms-error').html('');

                let url = route('admin.update.order.n.terms');
                let id = $(this).data('id');
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        id: id,
                        title: title,
                        description: description
                    },
                    beforeSend: function() {
                        $('body').addClass('loading');
                    },
                    success: function(response) {
                        let result = JSON.parse(response);
                        $('body').removeClass('loading');
                        $('.n-terms-message').html('<div class="alert alert-' + result.type +
                            ' alert-dismissible fade show col-sm-12" role="alert">' + result
                            .message +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                            );
                    },
                    error: function(response) {

                    }
                });
            }
        });
        $(document).on('click', '#update-payment-status', function() {
            let status = $('#payment_status').val();
            let payment_method = $('#payment_method').val();
            if ((status == null)) {
                $('.payment-status-error').removeAttr('style');
                $('.payment-status-error').html('Please select payment status');
            } else if ((payment_method == null)) {
                $('.payment-method-error').removeAttr('style');
                $('.payment-method-error').html('Please select payment method');

                $('.payment-status-error').attr('style', 'display:none;');
                $('.payment-status-error').html('');
            } else {

                $('.payment-method-error').attr('style', 'display:none;');
                $('.payment-method-error').html('');

                let url = route('admin.update.payment.status');
                let id = $(this).data('id');
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        id: id,
                        status: status,
                        payment_method: payment_method
                    },
                    beforeSend: function() {
                        $('body').addClass('loading');
                    },
                    success: function(response) {
                        let result = JSON.parse(response);
                        $('body').removeClass('loading');
                        $('.payment-status-message').html('<div class="alert alert-' + result.type +
                            ' alert-dismissible fade show col-sm-12" role="alert">' + result
                            .message +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                            );
                    },
                    error: function(response) {
                        console.log(response);
                        alert('Error Occured!');
                    }
                });
            }
        });
        $(document).on('keyup', '#shipping_charges', function() {
            if ($(this).val() !== '' && $('input#sub_total').val() !== '') {
                let total = (parseFloat($(this).val()) + parseFloat($('input#sub_total').val()));
                $(document).find('td#total_amount').html(total.toFixed(2) + '$');
            } else {
                $(document).find('td#total_amount').html(0 + '$');
            }
        });
        $(document).on('submit', 'form#chargePayment', function(e) {
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: $(this).serialize(),
                beforeSend: function() {
                    $.LoadingOverlay("show");
                },
                success: function(response) {
                    $.LoadingOverlay("hide");
                    let result = JSON.parse(response);

                    if (result.link !== '') {
                        window.open(result.link, "Verify Payment", "width=500,height=500");
                    }

                    $('div.paymentMsg').html(
                        '<div class="col-sm-12"> <div class="alert alert-info alert-dismissible fade show" role="alert">' +
                        result.message +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div></div>'
                    );
                },
                error: function(response) {
                    $.LoadingOverlay("hide");
                    $.each(response.responseJSON.errors, function(index, val) {
                        $('div.paymentMsg').html(
                            '<div class="col-sm-12"> <div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            val +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div></div>'
                        );
                    });

                }
            });
            e.preventDefault();
        });
    </script>
    <script src="{{ asset('assets/backend/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ asset('assets/backend/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/backend/datatable/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/backend/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/backend/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/backend/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/pages/form-validation.init.js') }}"></script>

    <script>
        CKEDITOR.replace('n_terms_description');
        /*tinymce.init({
              selector: 'textarea.ckeditor',
              plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
          toolbar_mode: 'floating',
           })*/
    </script>
@endsection
