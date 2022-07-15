@extends('layouts.backend.master')
@section('title')
    {{ __('All Products') }}
@endsection
@section('styles')
    <!-- Filepond stylesheet -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
@endsection
@section('page-content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ __('All Products') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('Products') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('Add Product') }}</li>
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
                            @if (Session::get('type') == 'danger')
                                <i class="mdi mdi-block-helper me-2"></i>
                            @else
                                <i class="mdi mdi-check-all me-2"></i>
                            @endif
                            {{ __(Session::get('message')) }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="col-sm-12">
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-block-helper me-2"></i>
                                {{ __($error) }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="col-sm-12 message"></div>
                <div class="col-sm-12 mb-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary">ALL PRODUCTS</a>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-success">ADD NEW PRODUCT</a>
                    {{-- <a href="{{ route('admin.trash.products') }}" class="btn btn-sm btn-danger">TRASH</a> --}}
                </div>
                <form class="needs-validation" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" novalidate>
                    <div class="row">
                        @csrf
                        <div class="col-sm-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                    placeholder="Name here" value="{{ old('name') }}" required>
                                                <div class="invalid-feedback">
                                                    Please enter valid name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Slug</label>
                                                <input type="text" class="form-control" name="slug" id="slug"
                                                    placeholder="Slug" value="{{ old('slug') }}" required>
                                                <div class="invalid-feedback">
                                                    Please enter valid slug.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea rows="4" class="form-control" name="description" id="description" placeholder="Description here">{{ old('description') }}</textarea>
                                                <div class="invalid-feedback">
                                                    Please enter valid description.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="sku" class="form-label">SKU</label>
                                                <input type="text" class="form-control text-start"
                                                    value="{{ old('sku') }}" name="sku" placeholder="Product SKU" id="sku" required>
                                                <div class="invalid-feedback">
                                                    Please enter valid sku.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label for="retail_price" class="form-label">Retail Price (USD)</label>
                                                <input type="text" class="form-control input-mask text-start"
                                                    value="{{ old('retail_price') }}" name="retail_price"
                                                    id="retail_price"
                                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"
                                                    required>
                                                <div class="invalid-feedback">
                                                    Please enter valid retail price.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label for="sale_price" class="form-label">Sale Price (USD)</label>
                                                <input type="text" class="form-control input-mask text-start"
                                                    value="{{ old('sale_price') }}" name="sale_price" id="sale_price"
                                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'">
                                                <div class="invalid-feedback">
                                                    Please enter valid sale price.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label for="shipping_charges" class="form-label">Shipping Charges (USD)</label>
                                                <input type="text" class="form-control input-mask text-start"
                                                    value="{{ old('shipping_charges') }}" name="shipping_charges" id="shipping_charges"
                                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'">
                                                <div class="invalid-feedback">
                                                    Please enter valid shipping charges.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="quantity" class="form-label">Product Offer Quantity</label>
                                                <input type="text" class="form-control input-mask text-start"
                                                    value="{{ old('quantity') }}" name="quantity" id="quantity" required
                                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'">
                                                <div class="invalid-feedback">
                                                    Please enter valid quantity.
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="stock_alert_quantity" class="form-label">Stock Alert Quantity</label>
                                                <input type="text" class="form-control input-mask text-start"
                                                    value="{{ old('stock_alert_quantity') }}" name="stock_alert_quantity" id="stock_alert_quantity"
                                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'">
                                                <div class="invalid-feedback">
                                                    Please enter valid alert quantity.
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="packing_type" class="form-label">Packing Type</label>
                                                <input type="text" class="form-control input-mask text-start"
                                                    value="{{ old('packing_type') }}" name="packing_type" id="packing_type" placeholder="Jar / Bottle / Packet" required/>
                                                <div class="invalid-feedback">
                                                    Please enter valid packing type
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="is_sample" class="form-label">Is Sample ? </label>
                                                <select name="is_sample" id="is_sample" class="form-select">
                                                    <option value="" selected disabled>Select Yes / No</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no" selected>No</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please enter valid option
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div> <!-- end col -->
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <div class="form-group">
                                                <label for="image" class="control-label">Icon image</label>
                                                <input type="file" class="form-control" name="image" id="image"
                                                    required />
                                                <div class="invalid-feedback">
                                                    Please upload icon image.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <div class="form-group">
                                                <label for="summary_image" class="control-label">Summary image</label>
                                                <input type="file" class="form-control" name="summary_image" id="summary_image"
                                                    required />
                                                <div class="invalid-feedback">
                                                    Please upload summary image.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-1">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <div class="form-group">
                                                <label for="meta_title" class="control-label">Meta Title</label>
                                                <input type="text" class="form-control" name="meta_title"
                                                    id="meta_title" placeholder="Meta Title"
                                                    value="{{ old('meta_title') }}" />
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <div class="form-group">
                                                <label for="meta_description" class="control-label">Meta
                                                    Description</label>
                                                <textarea class="form-control" rows="4" name="meta_description" id="meta_description"
                                                    placeholder="Meta Description">{{ old('meta_description') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="meta_keywords" class="control-label">Meta Keywords</label>
                                                <textarea class="form-control" rows="4" name="meta_keywords" id="meta_keywords" placeholder="Meta Keywords">{{ old('meta_keywords') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-5">
                            <button type="submit" class="btn btn-primary">ADD PRODUCT</button>
                        </div>
                    </div>
                </form>
            </div>
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
        $(document).on('keyup', '#name', function() {
            $.ajax({
                url: route('create.slug'),
                type: 'POST',
                data: {
                    'name': $(this).val()
                },
                success: function(response) {
                    $('#slug').val(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    </script>
@endsection
