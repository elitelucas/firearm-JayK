@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.Edit_Details')
@endsection

@section('body')

    <body>
    @endsection

    @section('content')

        <div class="home-btn d-none d-sm-block">
            <a href="{{ url('/') }}" class="text-dark"><i class="fas fa-home h2"></i></a>
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
                                            <h5 class="text-primary">Edit Details</h5>
                                            <p>Get your free Partner account now.</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{asset('assets/images/profile-img.png')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div>
                                    <a href="{{ url('/') }}">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{asset('assets/images/logo.svg')}}" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2">
                                    <form method="POST" class="form-horizontal mt-4" action="{{Url('contacts-profile/save')}}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('post')

                                        @if (session('error') !== null)
                                            <div class="alert alert-danger">
                                                <strong>{{ session('error') ?? '' }}</strong>
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <label for="fullname">Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                value="{{ Auth::user()->name }}" id="fullname" name="name" required
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
                                                value="{{ Auth::user()->company }}" id="company" name="company"
                                                placeholder="Enter the company name">
                                        </div>

                                        <div class="form-group">
                                            <label for="phone">Cell phone</label>
                                            <input type="tel" class="form-control"
                                                value="{{ Auth::user()->phone }}" id="phone" name="phone"
                                                placeholder="Enter your cell phone number" required onkeypress = "check_format(this)">
                                        </div>

                                        <div class="form-group">
                                            <label for="useremail">Email</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                                value="{{ Auth::user()->email }}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->address }}" id="address" name="address" required
                                                placeholder="Enter your address">
                                        </div>

                                        <div class="form-group">
                                            <label for="paypal_payout_email">Paypal Payout Email</label>
                                            <input type="email" class="form-control"
                                                value="{{ Auth::user()->paypal_payout_email }}" id="paypal_payout_email" name="paypal_payout_email" required
                                                placeholder="Enter your paypal payout email">
                                        </div>

                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                value="{{ Auth::user()->username }}" required name="username" id="username"
                                                placeholder="Enter username">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="userpassword">New Password</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" id="userpassword"
                                                placeholder="Enter new password">
                                            <small style="color:red">* If you don't want to set new password, please leave this empty</small>
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
                                                placeholder="Enter password">
                                        </div>

                                        <div class="form-group">
                                            <label for="avatar">Profile Picture</label>
                                            <img src="{{ asset(Auth::user()->avatar) }}" alt=""
                                                class="img-thumbnail rounded-circle" style="width:70px; height:70px">
                                            <input type="file" class="mt-2 form-control @error('avatar') is-invalid @enderror"
                                                name="avatar" id="avatar">
                                            <small style="color:red">* If you don't want to set new avatar, please leave this empty</small>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-primary btn-block waves-effect waves-light"
                                                type="submit">Update</button>
                                        </div>

                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

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
