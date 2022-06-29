@extends('layouts.backend.master')
@section('title') {{ 'Orders' }} @endsection
@section('styles')
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{asset('assets/backend/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/backend/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('page-content')

        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Orders</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Orders</a></li>
                                    <li class="breadcrumb-item active">All</li>
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
                        <a href="{{route('admin.orders.index')}}" class="btn btn-sm btn-primary">ALL ORDERS</a>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered data-table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Order Number</th>
                                            <th>Customer</th>
                                            <th>Billing Address</th>
                                            <th>Shipping Address</th>
                                            <th>Total</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('backend.footer')
        <div class="modal fade" id="view-order-reciept" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Order Reciept</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 text-center business-info">
                                <img src="{{asset('assets/frontend/template/images/logo.png')}}" class="mb-3"/>
                            </div>
                            <div class="col-sm-12 customer mb-3"></div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Qty.</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody class="reciept-items">
                                
                            </tbody>
                        </table>
                        <div class="calculation"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function () {
            
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: route('admin.orders.index'),
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'order_number', name: 'order_number'},
                    {data: 'customer', name: 'customer'},
                    {data: 'billing_address', name: 'billing_address'},
                    {data: 'shipping_address', name: 'shipping_method'},
                    {data: 'total', name: 'total'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                'createdRow': function( row, data, dataIndex ) {
                    $(row).attr('id', data.id);
                },
                "order": [[ 0, "desc" ]],
                "bDestroy": true,
            });

            $(document).on("click", ".view-reciept", function(event){
                let url = route('admin.orders.show');
                let formData = {id:$(this).data('id')};
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: formData,
                    beforeSend:function(){
                        $('.reciept-items').html('<tr><td class="text-center" colspan="5">Loading...</td></tr>');
                        $('body').addClass('loading');
                    },
                    success:function(response){
                        $('body').removeClass('loading');
                        $('.modal-footer button.print-modal').attr('data-id', response.id);
                        $('.customer').html(response.customer);
                        $('.reciept-items').html(response.invoiceItems);
                        $('.calculation').html(response.calculation);
                    }
                });
            });

            $(document).on("click", ".print", function(event){
                let url = route('admin.print.order');
                let formData = {id:$(this).data('id')};
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: formData,
                    beforeSend:function(){
                        $('body').addClass('loading');
                    },
                    success:function(response){
                        $('body').removeClass('loading');
                        $(response).printThis();
                    }
                });
            });
        });
        
    </script>
    <script src="{{asset('assets/backend/printPage/printThis.js')}}"></script>
    <script src="{{ asset('assets/backend/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/backend/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/pages/form-advanced.init.js') }}"></script>
@endsection