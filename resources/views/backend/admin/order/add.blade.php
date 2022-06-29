@extends('layouts.backend.master')
@section('title') {{ 'Add Order' }} @endsection
@section('additional-css')
    <!-- DataTables -->
    <link href="{{asset('assets/backend/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/backend/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/backend/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/backend/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">ADD NEW ORDER</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Orders</a></li>
                                    <li class="breadcrumb-item active">Add New Order</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                    @if(Session::has('message'))
                        <div class="alert alert-{{Session::get('type')}} alert-dismissible fade show col-sm-12" role="alert">
                            {{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    </div>
                    <div class="col-12 message"></div>
                    <div class="col-12 mb-2">
                        <a href="{{route('admin.orders')}}" class="btn btn-sm btn-primary">ALL ORDERS</a>
                        <a href="{{route('admin.add.order')}}" class="btn btn-sm btn-success">ADD NEW</a>
                        <a href="#" class="btn btn-sm btn-danger">TRASH</a>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row mb-3">
                                    <div class="col-sm-3">
                                        <label for="brand_id" class="col-form-label">Brands</label>
                                        <select class="form-control select2 brands" name="brand_id" id="brand_id">
                                            <option value="" selected="selected" disabled="disabled">Select Brand</option>
                                            @forelse($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @empty
                                                <option value="">No Brand Found!</option>
                                            @endforelse
                                        </select>
                                        <label id="brand-error" class="text-danger"></label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="product_id" class="col-form-label">Products</label>
                                        <select name="product_id" id="product_id" data-placeholder="Select Product" class="form-control select2 products">
                                        </select>
                                        <label id="product-error" class="text-danger"></label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="quantity" class="col-form-label">Quantity</label>
                                        <input type="number" class="form-control" name="quantity" id="quantity" placeholder="Product Quantity" value=""/>
                                        <label id="quantity-error" class="text-danger"></label>
                                    </div>
                                    <div class="col-sm-3 justify-content-end pt-3 mt-3">
                                        <button type="button" class="btn btn-primary mt-1" id="add-to-cart">Add To Cart</button>
                                    </div>
                                </div>
                                <hr />
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered data-table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Price($)</th>
                                            <th>Qty:</th>
                                            <th>Total($)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th colspan="2">ORDER SUMMARY</th>
                                        </tr>
                                        <tr>
                                            <th>Sub Total:</th>
                                            <th class="sub_total">${{ number_format($cart->sub_total ?? 0, 2) }}</th>
                                        </tr>
                                        <tr>
                                            <th>Discount: </th>
                                            <th class="discount_amount">&minus; ${{number_format($cart->discount_amount ?? 0, 2)}}</th>
                                        </tr>
                                        <tr>
                                            <th>GRAND TOTAL:</th>
                                            <th class="grand_total">${{ number_format($cart->grand_total ?? 0, 2) }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form class="form-horizontal custom-validation" method="GET" action="{{route('admin.add.customer.detail')}}">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="customer_id" class="col-form-label">Customers</label>
                                            <select class="form-control select2 customers" name="customer_id" id="customer_id" required="required">
                                                <option value="" selected="selected" disabled="disabled">Select Customer</option>
                                                @forelse($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->first_name.' '.$customer->last_name }}</option>
                                                @empty
                                                    <option value="">No Customer Found!</option>
                                                @endforelse
                                            </select>
                                            <label id="brand-error" class="text-danger"></label>
                                        </div>
                                        <div class="col-sm-12 text-center">
                                            <a href="{{route('admin.add.customer.detail')}}" class="btn btn-primary">NEW CUSTOMER</a>
                                            <button type="submit" class="btn btn-success">PROCEED >> </button>
                                        </div>
                                    </div>
                                </form>
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
    <script type="text/javascript">
        $(function(){
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: route('admin.get.cart.items'),
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'image', name: 'image'},
                    {data: 'name', name: 'name'},
                    {data: 'price', name: 'price'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'total', name: 'total'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                'createdRow': function( row, data, dataIndex ) {
                    $(row).attr('id', data.id);
                },
                "order": [[ 0, "desc" ]],
                "bDestroy": true,
            });
        })
        $(document).on('change', '.brands', function(){
            $.ajax({
                url: route('admin.get.brand.products'),
                type: 'POST',
                data:{id:$(this).val()},
                beforeSend: function(){
                    $('body').addClass('loading');
                },
                success: function(response){
                    $('select.products').html(JSON.parse(response).products);
                    $('body').removeClass('loading');
                },
                error:function(response){
                    alert('error occured');
                    console.log(response);
                    $('body').removeClass('loading');
                }
            });
        });
        $(document).on('change', '.products', function(){
            $.ajax({
                url: route('admin.get.product.quantity'),
                type: 'POST',
                data:{id:$(this).val()},
                beforeSend: function(){
                    $('body').addClass('loading');
                },
                success: function(response){
                    let result = JSON.parse(response);
                    if(result.type == "error"){
                        $('.message').html('<div class="alert alert-danger alert-dismissible fade show col-sm-12" role="alert">'+result.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                    else if(result.type == "success"){
                        $('#quantity').val(result.product.min_order_quantity);
                        $('#quantity').attr('min', result.product.min_order_quantity);
                        $('#add-to-cart').attr('data-id', result.product.id);
                        $('#add-to-cart').attr('data-image', result.product.image);
                    }
                    $('body').removeClass('loading');
                    
                },
                error:function(response){
                    alert('error occured');
                    console.log(response);
                    $('body').removeClass('loading');
                }
            });
        });
        $(document).on('click', '.proceed-order', function(){
            $.ajax({
                url: route('admin.add.customer.detail'),
                type: "POST",
                beforeSend: function(){
                    $('body').addClass('loading');
                },
                success:function(response){
                    let result = JSON.parse(response);

                },
                error: function(response){
                    alert('Error Occured.');
                    console.log(response);
                }
            });
        });
    </script>
    <script type="text/javascript" src="{{asset('assets/backend/cart-ajax/cart-process.js')}}"></script>

    <!-- Bootrstrap touchspin -->
    <script src="{{asset('assets/backend/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/pages/ecommerce-cart.init.js')}}"></script>

    <script src="{{asset('assets/backend/libs/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/pages/form-advanced.init.js')}}"></script>
    <script src="{{asset('assets/backend/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/backend/datatable/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/backend/datatable/js/dataTables.bootstrap4.min.js')}}"></script>

    <script src="{{ asset('assets/backend/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/pages/form-validation.init.js') }}"></script>
@endsection