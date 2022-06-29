@extends('layouts.backend.master')
@section('title') {{ 'Add Customer Detail' }} @endsection
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
                            <h4 class="mb-0 font-size-18">ADD CUSTOMER DETAIL</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Orders</a></li>
                                    <li class="breadcrumb-item active">Add Customer Detail</li>
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
                    <div class="col-9">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title mb-4">CUSTOMER DETAILS</h4>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link @if(!Session::has('customer_email')) {{ 'active' }} @endif" data-toggle="tab" href="#profile" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">Personal / Contact</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if(Session::has('customer_email')) {{ 'active' }} @endif" data-toggle="tab" href="#address" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">Shipping & Billing Address</span>    
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content p-3 text-muted">
                                    <div class="tab-pane @if(!Session::has('customer_email')) {{ 'active' }} @endif" id="profile" role="tabpanel">
                                        <div class="pt-4">
                                            @if(isset($editable) && ($editable == "yes"))
                                                <form class="form-horizontal custom-validation" role="form" id="profile-detail">
                                                    @csrf

                                                    <input type="hidden" name="id" id="userId" value="{{$customer->id ?? ''}}" class="customer-id"/>
                                                    <div class="form-group row mb-3">
                                                        <label for="company" class="col-sm-2 col-form-label">Company <span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="company" id="company" value="{{ $customer->company ?? '' }}" placeholder="Company" required />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <label for="name" class="col-sm-2 col-form-label">Name:</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-group row mb-3">
                                                                <label for="first_name" class="col-sm-2 col-form-label">First Name <span class="text-danger">*</span></label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $customer->first_name ?? '' }}" placeholder="First Name" required />
                                                                </div>
                                                                <label for="last_name" class="col-sm-2 col-form-label">Last Name <span class="text-danger">*</span></label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $customer->last_name ?? '' }}" placeholder="Last Name" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <label for="email" class="col-sm-2 col-form-label">E-Mail Address <span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="email" class="form-control" name="email" id="email" value="{{ $customer->email ?? '' }}" placeholder="E-Mail" required="required" />
                                                            <small class="text-primary">This email is unique so it could't be update later</small>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <label for="resale_number" class="col-sm-2 col-form-label">Resale Number <span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="resale_number" id="resale_number" value="{{ $customer->resale_number ?? '' }}" placeholder="Reslae Number" required />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <label for="phone" class="col-sm-2 col-form-label">Phone <span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="number" class="form-control" name="phone" id="phone" value="{{ $customer->phone ?? '' }}" placeholder="Phone" required min="0"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <label for="website" class="col-sm-2 col-form-label">Business Website <span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="website" id="website" value="{{ $customer->website ?? '' }}" placeholder="Business Website" required />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <label for="business_type" class="col-sm-2 col-form-label">How would you define your business? <span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <select name="business_type" id="business_type" class="form-control select2">
                                                                <option value="">Define your Business</option>
                                                                @if(isset($customer))
                                                                    <option value="Flower Store" @if($customer->business_type == "Flower Store") {{ 'selected' }} @endif>Flower Store</option>
                                                                    <option value="Gift Store" @if($customer->business_type == "Gift Store") {{ 'selected' }} @endif>Gift Store</option>
                                                                    <option value="Concept Store" @if($customer->business_type == "Concept Store") {{ 'selected' }} @endif>Concept Store</option>
                                                                    <option value="Travel Retail" @if($customer->business_type == "Travel Retail") {{ 'selected' }} @endif>Travel Retail</option>
                                                                    <option value="Stationery Speciality" @if($customer->business_type == "Stationery Speciality") {{ 'selected' }} @endif>Stationery Speciality</option>
                                                                    <option value="Card Store" @if($customer->business_type == "Card Store") {{ 'selected' }} @endif>Card Store</option>
                                                                    <option value="Museum and Art" @if($customer->business_type == "Museum and Art") {{ 'selected' }} @endif>Museum and Art</option>
                                                                    <option value="HomeGoods Store" @if($customer->business_type == "HomeGoods Store") {{ 'selected' }} @endif>HomeGoods Store</option>
                                                                    <option value="Department Store" @if($customer->business_type == "Department Store") {{ 'selected' }} @endif>Department Store</option>
                                                                    <option value="Clothing Shop" @if($customer->business_type == "Clothing Shop") {{ 'selected' }} @endif>Clothing Shop</option>
                                                                    <option value="Other" @if($customer->business_type == "Other") {{ 'selected' }} @endif>Other</option>
                                                                @else
                                                                    <option value="Flower Store">Flower Store</option>
                                                                    <option value="Gift Store">Gift Store</option>
                                                                    <option value="Concept Store">Concept Store</option>
                                                                    <option value="Travel Retail">Travel Retail</option>
                                                                    <option value="Stationery Speciality">Stationery Speciality</option>
                                                                    <option value="Card Store">Card Store</option>
                                                                    <option value="Museum and Art">Museum and Art</option>
                                                                    <option value="HomeGoods Store">HomeGoods Store</option>
                                                                    <option value="Department Store">Department Store</option>
                                                                    <option value="Clothing Shop">Clothing Shop</option>
                                                                    <option value="Other">Other</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12 offset-sm-2">
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light"> ADD PROFILE </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            @else
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <th>Company:</th>
                                                            <td>{{ $customer->first_name ?? '' }} {{ $customer->last_name ?? '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>E-mail:</th>
                                                            <td><a href="mailto:{{$customer->email ?? ''}}">{{ $customer->email ?? '' }}</a></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Resale Number:</th>
                                                            <td>{{ $customer->resale_number ?? '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Phone:</th>
                                                            <td><a href="tel:{{$customer->phone ?? ''}}">{{ $customer->phone ?? '' }}</a></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Website:</th>
                                                            <td><a href="{{$customer->website ?? '#'}}" target="_blank">{{ $customer->website ?? '#' }}</a></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Business Type:</th>
                                                            <td>{{ $customer->business_type ?? '' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane @if(Session::has('customer_email')) {{ 'active' }} @endif" id="address" role="tabpanel">
                                        <div class="pt-4">
                                            @if(isset($editable) && ($editable == "yes"))
                                                <form class="form-horizontal custom-validation" role="form" id="customer-address-detail">
                                                    <h4 class="card-title mb-1">BILLING ADDRESS</h4>
                                                    <hr />
                                                    @csrf
                                                    @if(Session::has('customer_email'))
                                                        <input type="hidden" name="id" value="{{$customer->id}}" class="customer-id"/>
                                                    @else
                                                        <input type="hidden" name="id" value="{{$customer->id ?? ''}}" class="customer-id"/>
                                                    @endif

                                                    <div class="form-group row mb-3">
                                                        <label for="name" class="col-sm-2 col-form-label">Name:</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-group row mb-3">
                                                                <label for="first_name" class="col-sm-2 col-form-label">First Name <span class="text-danger">*</span></label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control" name="billing[first_name]" id="first_name" value="{{ $billing->first_name ?? '' }}" placeholder="First Name" required />
                                                                </div>
                                                                <label for="last_name" class="col-sm-2 col-form-label">Last Name <span class="text-danger">*</span></label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control" name="billing[last_name]" id="last_name" value="{{ $billing->last_name ?? '' }}" placeholder="Last Name" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <label for="phone" class="col-sm-2 col-form-label">Phone <span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="number" class="form-control" name="billing[phone]" id="phone" value="{{ $billing->phone ?? '' }}" placeholder="Phone" required min="0"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row mb-3">
                                                        <label for="address_line_1" class="col-sm-2 col-form-label">Address:<span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="billing[address_line_1]" id="address_line_1" value="{{ $billing->address_line_1 ?? '' }}" placeholder="Address Line 1" required />
                                                        </div>
                                                        <label for="address_line_2" class="col-sm-2 col-form-label">&nbsp;</label>
                                                        <div class="col-sm-10 mt-2">
                                                            <input type="text" class="form-control" name="billing[address_line_2]" id="address_line_2" value="{{ $billing->address_line_2 ?? '' }}" placeholder="Address Line 2"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <label for="city" class="col-sm-2 col-form-label">City<span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="billing[city]" id="city" value="{{ $billing->city ?? '' }}" placeholder="City" required />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <label for="billing_country" class="col-sm-2 col-form-label">Country<span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <select name="billing[country]" id="billing_country" class="form-control billingCountry select2" required="required">
                                                                @if(isset($billing->country))
                                                                    <option value="" selected="selected" disabled="disabled">Select Country</option>
                                                                    @forelse($countries as $country)
                                                                        <option value="{{$country->id}}" @if($country->id == $billing->country) {{ 'selected' }} @endif>{{ $country->country ?? '' }}</option>
                                                                    @empty
                                                                        <option>No Country Found!</option>
                                                                    @endforelse
                                                                @else
                                                                    <option value="" selected="selected" disabled="disabled">Select Country</option>
                                                                    @forelse($countries as $country)
                                                                        <option value="{{$country->id}}">{{ $country->country ?? '' }}</option>
                                                                    @empty
                                                                        <option>No Country Found!</option>
                                                                    @endforelse
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <label for="billing_state" class="col-sm-2 col-form-label">State / Province<span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <select name="billing[state]" id="billing_state" class="form-control select2" required="required">
                                                                @if(isset($billing->state))
                                                                    <option value="" selected="selected" disabled="disabled">Select State</option>
                                                                    @forelse($states as $state)
                                                                        <option value="{{$state->name}}" @if($state->name == $billing->state) {{ 'selected' }} @endif>{{ $state->name ?? '' }}</option>
                                                                    @empty
                                                                        <option>No State Found!</option>
                                                                    @endforelse
                                                                @else
                                                                    <option value="" selected="selected" disabled="disabled">Select State</option>
                                                                    @forelse($states as $state)
                                                                        <option value="{{$state->name}}">{{ $state->name ?? '' }}</option>
                                                                    @empty
                                                                        <option>No State Found!</option>
                                                                    @endforelse
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <label for="zipcode" class="col-sm-2 col-form-label">Zipcode<span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="zipcode" class="form-control" name="billing[zipcode]" id="zipcode" value="{{$billing->zipcode ?? ''}}" placeholder="Zipcode" required />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-1">
                                                        <label class="col-sm-2 col-form-label" for="shipping_address_same_yes">Are shipping and billing addresses the same? </label>
                                                        <div class="col-sm-10">
                                                            @if(isset($shipping) && (count((array)$shipping) > 0))
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="shipping_address_same_yes" name="shipping_address_same_yes" class="custom-control-input" value="yes"/>
                                                                <label class="custom-control-label" for="shipping_address_same_yes">Yes</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="shipping_address_same_no" name="shipping_address_same_yes" class="custom-control-input" value="no" checked/>
                                                                <label class="custom-control-label" for="shipping_address_same_no">No</label>
                                                            </div>
                                                            @else
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="shipping_address_same_yes" name="shipping_address_same_yes" class="custom-control-input" value="yes" checked/>
                                                                <label class="custom-control-label" for="shipping_address_same_yes">Yes</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="shipping_address_same_no" name="shipping_address_same_yes" class="custom-control-input" value="no"/>
                                                                <label class="custom-control-label" for="shipping_address_same_no">No</label>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div id="shipping-fields">
                                                    @if(isset($shipping) && (count((array)$shipping) > 0))
                                                        <h4 class="card-title mb-1 mt-2">SHIPPING ADDRESS</h4>
                                                        <hr />
                                                        <div class="form-group row mb-3">
                                                            <label for="name" class="col-sm-2 col-form-label">Name:</label>
                                                            <div class="col-sm-10">
                                                                <div class="form-group row mb-3">
                                                                    <label for="shipping_first_name" class="col-sm-2 col-form-label">First Name <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control" name="shipping[first_name]" id="shipping_first_name" value="{{ $shipping->first_name ?? '' }}" placeholder="First Name" required />
                                                                    </div>
                                                                    <label for="shipping_last_name" class="col-sm-2 col-form-label">Last Name <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control" name="shipping[last_name]" id="shipping_last_name" value="{{ $shipping->last_name ?? '' }}" placeholder="Last Name" required />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="shipping_phone" class="col-sm-2 col-form-label">Phone <span class="text-danger">*</span></label>
                                                            <div class="col-sm-10">
                                                                <input type="number" class="form-control" name="shipping[phone]" id="shipping_phone" value="{{ $shipping->phone ?? '' }}" placeholder="Phone" required min="0"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="shipping_address_line_1" class="col-sm-2 col-form-label">Address:<span class="text-danger">*</span></label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="shipping[address_line_1]" id="shipping_address_line_1" value="{{ $shipping->address_line_1 ?? '' }}" placeholder="Address Line 1" required />
                                                            </div>
                                                            <label for="shipping_address_line_2" class="col-sm-2 col-form-label">&nbsp;</label>
                                                            <div class="col-sm-10 mt-2">
                                                                <input type="text" class="form-control" name="shipping[address_line_2]" id="shipping_address_line_2" value="{{ $shipping->address_line_2 ?? '' }}" placeholder="Address Line 2"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="shipping_city" class="col-sm-2 col-form-label">City<span class="text-danger">*</span></label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="shipping[city]" id="shipping_city" value="{{ $shipping->city ?? '' }}" placeholder="City" required />
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="shipping_country" class="col-sm-2 col-form-label">Country<span class="text-danger">*</span></label>
                                                            <div class="col-sm-10">
                                                                <select name="shipping[country]" id="shipping_country" class="form-control select2 shippingCountry" required="required">
                                                                    @if(isset($billing->state))
                                                                        <option value="" selected="selected" disabled="disabled">Select Country</option>
                                                                        @forelse($countries as $country)
                                                                            <option value="{{$country->id}}" @if($country->id == $shipping->country) {{ 'selected' }} @endif>{{ $country->country ?? '' }}</option>
                                                                        @empty
                                                                            <option>No Country Found!</option>
                                                                        @endforelse
                                                                    @else
                                                                        <option value="" selected="selected" disabled="disabled">Select Country</option>
                                                                        @forelse($countries as $country)
                                                                            <option value="{{$country->id}}">{{ $country->country ?? '' }}</option>
                                                                        @empty
                                                                            <option>No Country Found!</option>
                                                                        @endforelse
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="shipping_state" class="col-sm-2 col-form-label">State / Province<span class="text-danger">*</span></label>
                                                            <div class="col-sm-10">
                                                                <select name="shipping[state]" id="shipping_state" class="form-control select2" required="required">
                                                                    @if(isset($shipping->state))
                                                                        <option value="" selected="selected" disabled="disabled">Select State</option>
                                                                        @forelse($states as $state)
                                                                            <option value="{{$state->name}}" @if($state->name == $shipping->state) {{ 'selected' }} @endif>{{ $state->name ?? '' }}</option>
                                                                        @empty
                                                                            <option>No State Found!</option>
                                                                        @endforelse
                                                                    @else
                                                                        <option value="" selected="selected" disabled="disabled">Select State</option>
                                                                        @forelse($states as $state)
                                                                            <option value="{{$state->name}}">{{ $state->name ?? '' }}</option>
                                                                        @empty
                                                                            <option>No State Found!</option>
                                                                        @endforelse
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="shipping_zipcode" class="col-sm-2 col-form-label">Zipcode<span class="text-danger">*</span></label>
                                                            <div class="col-sm-10">
                                                                <input type="number" class="form-control" name="shipping[zipcode]" id="shipping_zipcode" value="{{ $shipping->zipcode ?? '' }}" placeholder="Zipcode" required />
                                                            </div>
                                                        </div>
                                                    @endif
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12 offset-sm-2">
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                                UPDATE ADDRESS
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            @else
                                                <h4 class="card-title mb-1">BILLING ADDRESS</h4>
                                                <hr />
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <th>Name:</th>
                                                            <td>{{ $billing->first_name ?? '' }} {{ $billing->last_name ?? '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Phone:</th>
                                                            <td><a href="tel:{{$billing->phone ?? ''}}">{{ $billing->phone ?? '' }}</a></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Address:</th>
                                                            <td>{{ $billing->address_line_1 ?? '' }}, {{ $billing->address_line_2 ?? '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>City:</th>
                                                            <td>{{ $billing->city ?? '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Country:</th>
                                                            <td>{{ $billing_country->country ?? '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>State:</th>
                                                            <td>{{ $billing->state ?? '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Zipcode:</th>
                                                            <td>{{ $billing->zipcode ?? '' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <h4 class="card-title mb-1">SHIPPING ADDRESS</h4>
                                                <hr />
                                                @if(isset($shipping) && (count((array)$shipping) > 0))
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <th>Name:</th>
                                                                <td>{{ $shipping->first_name ?? '' }} {{ $shipping->last_name ?? '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Phone:</th>
                                                                <td><a href="tel:{{$billing->phone ?? ''}}">{{ $shipping->phone ?? '' }}</a></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Address:</th>
                                                                <td>{{ $shipping->address_line_1 ?? '' }}, {{ $shipping->address_line_2 ?? '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>City:</th>
                                                                <td>{{ $shipping->city ?? '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Country:</th>
                                                                <td>{{ $shipping_country->country ?? '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>State:</th>
                                                                <td>{{ $shipping->state ?? '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Zipcode:</th>
                                                                <td>{{ $shipping->zipcode ?? '' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <th colspan="2">Shipping & Billing Address are same.</th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
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
                            <div class="card-body text-center">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <a href="{{route('admin.add.order')}}" class="btn btn-danger"> << BACK </a>
                                    </div>
                                    <div class="col-sm-7">
                                        @if(isset($customer))
                                        <div id="finish-order">
                                            <form method="POST" action="{{route('admin.finish.order.process')}}">
                                                @csrf
                                                <input type="hidden" name="customerId" value="{{$customer->id ?? ''}}" />
                                                <button type="submit" class="btn btn-success">FINISH ORDER >> </button>
                                            </form>
                                        </div>
                                        @else
                                        <div id="finish-order">
                                            <button type="button" class="btn btn-success">FINISH ORDER >> </button>
                                        </div>
                                        @endif
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
    <script src="{{asset('assets/backend/libs/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/pages/form-advanced.init.js')}}"></script>
    <script src="{{asset('assets/backend/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/backend/datatable/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/backend/datatable/js/dataTables.bootstrap4.min.js')}}"></script>

    <script type="text/javascript">
        $(document).on('change', '.billingCountry', function(){
            $.ajax({
                url: route('get.billing.states'),
                data:{country_id:this.value},
                type:"POST",
                beforeSend:function(){
                    $('body').addClass('loading');
                },
                success:function(data){
                    $('body').removeClass('loading');
                    $('#billing_state').html(data);
                },
                error:function(response){
                    $('body').removeClass('loading');
                    alert('Error Occured');
                    console.log(response);
                }
            });
        });
        
        $(document).on('change', '.shippingCountry', function(){
            $.ajax({
                url: route('get.shipping.states'),
                data:{country_id:this.value},
                type:"POST",
                beforeSend:function(){
                    $('body').addClass('loading');
                },
                success:function(data){
                    $('#shipping_state').html(data);
                    $('body').removeClass('loading');
                },
                error:function(response){
                    $('body').removeClass('loading');
                    alert('Error Occured');
                    console.log(response);
                }
            });
        });
        $(document).on('click', '#shipping_address_same_no', function(){
            $.ajax({
                url: route('get.shipping.fields'),
                data:{panel:'admin'},
                type:"GET",
                beforeSend:function(){
                    $('body').addClass('loading');
                },
                success:function(data){
                    $('#shipping-fields').html(data);
                    $('body').removeClass('loading');
                },
                error:function(response){
                    $('body').removeClass('loading');
                    alert('Error Occured');
                    console.log(response);
                }
            });
        });
        $(document).on('click', '#shipping_address_same_yes', function(){
            $('#shipping-fields').html('');
        });

        $('form#profile-detail').submit(function(event){
            event.preventDefault();
            $.ajax({
                url: route('admin.add.profile.detail.process'),
                type: 'POST',
                data: $(this).serialize(),
                beforeSend:function(){
                    $('body').addClass('loading');
                },
                success: function(response){
                    let result = JSON.parse(response);
                    if(result.type == "success"){
                        $('.message').html('<div class="alert alert-'+result.type+' alert-dismissible fade show col-sm-12" role="alert">'+result.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        $(document).find('input#userId').val(result.id);
                        $(document).find('input.customer-id').val(result.id);
                        $('a[href="#profile"]').removeClass('active');
                        $('div#profile').removeClass('active');

                        $('a[href="#address"]').addClass('active');
                        $('div#address').addClass('active');
                    }
                    else{
                        $('.message').html('<div class="alert alert-'+result.type+' alert-dismissible fade show col-sm-12" role="alert">'+result.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                    $('body').removeClass('loading');
                },
                error: function(response){
                    $('body').removeClass('loading');
                    $.each(response.responseJSON.errors, function(index, item){
                        $('.message').append('<div class="alert alert-danger alert-dismissible fade show col-sm-12" role="alert">'+item+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    });
                }
            });
        });

        $('form#customer-address-detail').submit(function(event){
            event.preventDefault();
            $.ajax({
                url: route('admin.update.customer.address.process'),
                type: 'POST',
                data: $(this).serialize(),
                beforeSend:function(){
                    $('body').addClass('loading');
                },
                success: function(response){
                    let result = JSON.parse(response);
                    if(result.type == "success"){
                        $('.message').html('<div class="alert alert-'+result.type+' alert-dismissible fade show col-sm-12" role="alert">'+result.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        $('div#finish-order').html('<form method="POST" action="'+route('admin.finish.order.process')+'"><input type="hidden" name="_token" value="{{csrf_token()}}"/><input type="hidden" name="customerId" value="'+result.id+'"/><button type="submit" class="btn btn-success">FINISH ORDER >> </button></form>');
                        // $('a.finish-order').attr('href', route('admin.finish.order.process'));
                        // $('a.finish-order').attr('data-user-id', result.id);
                        // $('a.finish-order').removeAttr('disabled');
                        $('input.customer-id').val(result.id);
                    }
                    else{
                        $('.message').html('<div class="alert alert-'+result.type+' alert-dismissible fade show col-sm-12" role="alert">'+result.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                    $('body').removeClass('loading');
                },
                error: function(response){
                    $('body').removeClass('loading');
                    $.each(response.responseJSON.errors, function(index, item){
                        $('.message').append('<div class="alert alert-danger alert-dismissible fade show col-sm-12" role="alert">'+item+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    });
                }
            });
        });
    </script>

    <script src="{{ asset('assets/backend/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/pages/form-validation.init.js') }}"></script>
@endsection