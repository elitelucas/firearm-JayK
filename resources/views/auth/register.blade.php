@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.Register')
@endsection

@section('body')

    <body>
    @endsection

    @section('content')

        <div class="home-btn d-none d-sm-block">
            <a href="{{ url('index') }}" class="text-dark"><i class="fas fa-home h2"></i></a>
        </div>
        <div class="account-pages my-5 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-soft-primary">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Free Register</h5>
                                            <p>Get your free Partner account now.</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div>
                                    <a href="{{ url('index') }}">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="assets/images/logo.svg" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2">

                                    @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                    </button>
                                                <i class="fa fa-check margin-separator"></i> {{$error}}
                                            </div>
                                        @endforeach
                                    @endif
                                    <form method="POST" class="form-horizontal mt-4" action="{{ route('register') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="fullname">Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" id="fullname" name="name" required
                                                placeholder="Enter your name">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="company">Company Name</label>
                                            <input type="text" class="form-control"
                                                value="{{ old('company') }}" id="company" name="company"
                                                placeholder="Enter the company name">
                                        </div>

                                        <div class="form-group">
                                            <label for="phone">Cell phone</label>
                                            <input type="tel" class="form-control"
                                                value="{{ old('phone') }}" id="phone" name="phone"
                                                placeholder="Enter your cell phone number" required onkeypress = "check_format(this)">
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                value="{{old('email')}}" id="email" name="email" required
                                                placeholder="Enter email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control"
                                                value="{{old('address')}}" id="address" name="address" required
                                                placeholder="Enter your address">
                                        </div>

                                        <div class="form-group">
                                            <label for="paypal_payout_email">Paypal Payout Email</label>
                                            <input type="email" class="form-control"
                                                value="{{old('paypal_payout_email')}}" id="paypal_payout_email" name="paypal_payout_email" required
                                                placeholder="Enter your paypal payout email">
                                        </div>

                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control"
                                                value="{{ old('username') }}" required name="username" id="username"
                                                placeholder="Enter username">
                                        </div>

                                        <div class="form-group">
                                            <label for="userpassword">Password</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                required id="userpassword" placeholder="Enter password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="userpassword">Confirm Password</label>
                                            <input id="password-confirm" type="password" name="password_confirmation"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                required placeholder="Enter Confirm password">
                                        </div>

                                        <!-- <div class="form-group">
                                            <label for="userdob">Date of Birth</label>
                                            <input type="date" max="17-07-2020"
                                                class="form-control @error('dob') is-invalid @enderror" name="dob"
                                                id="datepicker" placeholder="Enter Birthdate">
                                            @error('dob')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div> -->

                                        <!-- <div class="form-group">
                                            <label for="avatar">Profile Picture</label>
                                            <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                                name="avatar" required id="avatar">
                                            @error('avatar')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div> -->

                                        <div class="form-group">
                                            <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_SITE_KEY') }}"></div>
                                            @if ($errors->has('g-recaptcha-response'))
                                                <span class="invalid-feedback" style="display: block;">
                                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-primary btn-block waves-effect waves-light"
                                                type="submit">Register</button>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <h5 class="font-size-14 mb-3">Sign up with</h5>

                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <a href="#"
                                                        class="social-list-item bg-primary text-white border-primary">
                                                        <i class="mdi mdi-facebook"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="#" class="social-list-item bg-info text-white border-info">
                                                        <i class="mdi mdi-twitter"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="#" class="social-list-item bg-danger text-white border-danger">
                                                        <i class="mdi mdi-google"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <p class="mb-0">By registering you agree to the Skote <a href="#"
                                                    class="text-primary">Terms of Use</a></p>
                                        </div>

                                    </form>

                                </div>
                            </div>

                        </div>

                        <div class="mt-5 text-center">
                            <p>Already have an account ? <a href="{{ url('login') }}"
                                    class="font-weight-medium text-primary"> Login </a> </p>
                            <p>© <script>
                                    document.write(new Date().getFullYear())

                                </script> Skote. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    @endsection
    @section('script')
       
        <script src='https://www.google.com/recaptcha/api.js'></script>

        <script>
            $(document).ready(function() {
                $("#phone").keypress(function(event) {
                    return /\d/.test(String.fromCharCode(event.keyCode));
                });
            });

            function check_format(phone){
                var phone_number = $(phone).val();
                if(phone_number.length==3){
                    $(phone).val(phone_number+'-');
                }else if(phone_number.length==7){
                    $(phone).val(phone_number+'-');
                }else if(phone_number.length>=12){
                    $(phone).val(phone_number.substr(0, 11));
                }
            }
        </script>
         
         
    @endsection
