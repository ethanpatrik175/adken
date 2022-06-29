@extends('layouts.backend.master')
@section('title') {{ __('Trash Products') }} @endsection
@section('styles')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        .avatar-sm {
            width: auto !important;
        }
    </style>
@endsection
@section('page-content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ __('Trash Products') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('Products') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('Trash Products') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                @if (Session::has('message'))
                    <div class="col-sm-12">
                        <div class="alert alert-{{ Session::get('type') }} alert-dismissible fade show" role="alert">
                            @if (Session::get('type') == 'danger') <i class="mdi mdi-block-helper me-2"></i> @else <i class="mdi mdi-check-all me-2"></i> @endif
                            {{ __(Session::get('message')) }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    </div>
                @endif
                <div class="col-sm-12 message"></div>
                <div class="col-sm-12 mb-2">
                    <a href="{{ route('admin.all.products') }}" class="btn btn-sm btn-primary">ALL PRODUCTS</a>
                    <a href="{{ route('admin.add.product') }}" class="btn btn-sm btn-success">ADD NEW PRODUCT</a>
                    <a href="{{ route('admin.trash.products') }}" class="btn btn-sm btn-danger">TRASH</a>
                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered data-table wrap">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Service</th>
                                        <th>Short Description</th>
                                        <th>Created At</th>
                                        <th>Added By</th>
                                        <th>Updated By</th>
                                        <th>Status(is active?)</th>
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
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: route('admin.trash.products'),
                columns: [{
                    data: 'id',
                    name: 'id'
                }, {
                    data: 'image',
                    name: 'image'
                }, {
                    data: 'name',
                    name: 'name'
                }, {
                    data: 'serviceName',
                    name: 'serviceName'
                }, {
                    data: 'short_description',
                    name: 'short_description'
                }, {
                    data: 'created_at',
                    name: 'created_at'
                }, {
                    data: 'added_by',
                    name: 'added_by'
                }, {
                    data: 'updated_by',
                    name: 'updated_by'
                }, {
                    data: 'status',
                    name: 'status'
                }, {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }, ],
                responsive: true,
                'createdRow': function(row, data, dataIndex) {
                    $(row).attr('id', data.id);
                },
                "order": [
                    [0, "desc"]
                ],
                "bDestroy": true,
            });
        });

        $(document).on("click", ".restore", function(event) {
            var id = $(this).data('id');
            $.ajax({
                url: route('admin.restore.product'),
                type: 'POST',
                data: {
                    id: id
                },
                success: function(data) {
                    let result = JSON.parse(data);
                    $('.message').html('<div class="alert alert-' + result.type +
                        ' alert-dismissible fade show" role="alert"><i class="mdi ' + result.icon +
                        ' me-2"></i>' + result.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>'
                    );

                    let table = $('.data-table').DataTable();
                    table.row('#' + id).remove().draw(false);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    </script>
@endsection
