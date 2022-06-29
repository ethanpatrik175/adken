@extends('layouts.frontend.master')

@section('page_title') {{ "Register" }} @endsection

@section('content')
<!-- banner start -->
<section class="inner_banner">
    <img src="assets/frontend/images/inner_banner.png" alt="INNER BANNER" class="img-responsive">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-12">
                <div class="inner_bnr_txt">
                    <div class="text-end">
                        <h4 class="bnr_grad_txt upper ani seven"><span class="txt_brwn">A</span><span
                                class="txt_brwn">w</span><span class="txt_brwn">a</span><span
                                class="txt_brwn">k</span><span class="txt_brwn">e</span><span class="txt_brwn">n</span>
                            <span class="txt_brwn">D</span><span class="txt_brwn">i</span><span
                                class="txt_brwn">v</span><span class="txt_brwn">i</span><span
                                class="txt_brwn">n</span><span class="txt_brwn">e</span>
                            <span>j</span><span>o</span><span>u</span><span>r</span><span>n</span><span>e</span><span>y</span>
                        </h4>
                    </div>
                    <h2>REGISTER</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- banner end -->

<!-- ACCOUNT SEC STRT -->
<section class="log-in-page-main">
    <div class="container">
        <div class="row">
            @if (Session::has('message'))
            <div class="col-sm-12">
                <ul>
                    <li class="text-{{ Session::get('type') }}">{{ __(Session::get('message')) }}</li>
                </ul>
            </div>
            @endif
            @if ($errors->any())
            <div class="col-sm-12">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li class="text-danger">{{ __($error) }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 wow fadeInLeft" data-wow-delay="0.4s">
                <h2>Register</h2>
                <div class="log-in-wrap">
                    <form method="POST" action="{{ route('register') }}" class="d-flex flex-column needs-validation"
                        novalidate>
                        @csrf
                        <div class="single-checkout-form-area">
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6 mb-1">
                                            <input type="text" placeholder="{{ __('First Name *') }}"
                                                class="form-control mb-0 @error('first_name') is-invalid @enderror" id="first_name"
                                                name="first_name" value="{{ old('first_name') }}" required autofocus />
                                            <div class="invalid-feedback mb-1">
                                                Please enter first name.
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-1">
                                            <input type="text" placeholder="{{ __('Last Name *') }}"
                                                class="form-control mb-0 @error('last_name') is-invalid @enderror" id="last_name"
                                                name="last_name" value="{{ old('last_name') }}" required autofocus />
                                            <div class="invalid-feedback mb-1">
                                                Please enter last name.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <input type="email" placeholder="{{ __('E-Mail Address *') }}"
                                        class="form-control mb-0 @error('email') is-invalid @enderror" id="email" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus />
                                    <div class="invalid-feedback mb-1">
                                        Please enter valid email address.
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <input type="phone" placeholder="{{ __('Phone *') }}"
                                        class="form-control mb-0 @error('phone') is-invalid @enderror" id="phone" name="phone"
                                        value="{{ old('phone') }}" required autofocus />
                                    <div class="invalid-feedback mb-1">
                                        Please enter valid phone.
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <input type="password" placeholder="{{ __('Password *') }}"
                                        class="form-control mb-0 @error('password') is-invalid @enderror" name="password" required
                                        autocomplete="current-password" />
                                    <div class="invalid-feedback">
                                        Please enter valid password.
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <input type="password" placeholder="{{ __('Confirm Password *') }}"
                                        class="form-control mb-0 @error('confirm_password') is-invalid @enderror"
                                        name="confirm_password" required autocomplete="current-password" />
                                    <div class="invalid-feedback">
                                        Please enter valid confirm password.
                                    </div>
                                </div>

                                <div class="col-sm-12 text-center mt-3">
                                    <button type="submit" class="btn_normal">{{ __('Register') }}</button>
                                </div>

                                <div class="col-sm-12 text-center">
                                    <a class="btn btn-link" href="{{ route('login') }}">
                                        {{ __('Have an account? Login here.') }}
                                    </a>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
</section>
<!-- ACCOUNT SEC END -->
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/libs/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/pages/form-validation.init.js') }}"></script>
@endsection
