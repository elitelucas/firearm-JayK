@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.Customers') @lang('translation.Register')
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
                    <div class="col-md-10 col-lg-8 col-xl-6">
                        <div class="card overflow-hidden">
                            <div class="bg-soft-primary pt-4 text-center">
                                <h5 class="text-primary">Concealed Certification Course Registration</h5>
                                <p class="mt-4 mb-2">{{$user->name}} Authorized Agent for</p>
                                <img src="{{URL::asset('assets/images/logo.png')}}" height="80px">
                                <br>
                                <p class="mt-2">Please complete the below registration form to register</p>
                            </div>
                            <div class="card-body pt-0 mt-3">
                                <div class="p-2">
                                    <form method="POST" class="form-horizontal mt-4" action="{{Url('customers/save')}}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$user->id}}">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <i class="bx bxs-user" style="position:absolute;top:11px;left:25px"></i>
                                                    <input type="text" class="form-control" style="padding-left:35px"
                                                        value="" id="firstname" name="firstname" required
                                                        placeholder="First Name">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <i class="bx bxs-user" style="position:absolute;top:11px;left:25px"></i>
                                                    <input type="text" class="form-control" style="padding-left:35px"
                                                        value="" id="lastname" name="lastname" required
                                                        placeholder="Last Name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <i class="bx bxs-envelope" style="position:absolute;top:11px;left:25px"></i>
                                                    <input type="email" class="form-control" style="padding-left:35px"
                                                        value="" id="useremail" name="email" required
                                                        placeholder="Email Address">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <i class="bx bxs-phone" style="position:absolute;top:11px;left:25px"></i>
                                                    <input type="text" class="form-control" style="padding-left:35px"
                                                        value="+1" id="phone" name="phone" required onkeypress = "check_format(this)">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <i class="fas fa-home" style="position:absolute;top:11px;left:25px"></i>
                                                    <input type="text" class="form-control" style="padding-left:35px"
                                                        value="" id="address" name="address" required
                                                        placeholder="Street/PO Address">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        value="" id="city" name="city" required
                                                        placeholder="City">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        value="" id="state" name="state" required
                                                        placeholder="State">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        value="" id="zip" name="zip" required
                                                        placeholder="Postal/Zip Code">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <i class="fas fa-map-marker-alt" style="position:absolute;top:11px;left:25px"></i>
                                                    <select class="form-control" id="location" name="location" style="padding-left:35px" onchange="select_class_date(this)" >
                                                        <option value="">Select Location</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <i class="fas fa-calendar-alt" style="position:absolute;top:11px;left:25px"></i>
                                                    <select class="form-control" id="class_date" name="class_date" style="padding-left:35px" onchange="select_QTY()" >
                                                        <option value="">Select Class Date</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="registration_fee"></div>

                                        <div class="form-group">
                                            <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_SITE_KEY') }}"></div>
                                            @if ($errors->has('g-recaptcha-response'))
                                                <span class="invalid-feedback" style="display: block;">
                                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label"><input type="checkbox" id="accept_term" name="accept_term" value="1" style="margin-right:5px" required> I accept the terms and conditions</label>
                                            <div style="background-color: #fafafb;border: 1px solid #bdc3c7;font-weight: 400;font-size: 14px;color: #aaa;padding: 20px;height: 270px;overflow-y: scroll;">Whereas, in consideration of being permitted to attend a course for instruction in firearms, for the instruction in firearms, for use of premises, and for other good and valuable consideration, the receipt and sufficiency of which is hereby acknowledged, Undersigned agrees to the following:&nbsp; Undersigned agrees to indemnify, hold harmless and defend Firearm Training Pro and their Instructors (hereinafter referred to as “Instructor”), from any and all fault, liabilities, costs, expenses, claim, demands, or lawsuits arising out of, related to or connected with: Undersigned’s presence at and/or and/or Gun Show Team participation in the course of instruction; the discharge of firearms by Undersigned; Undersigned’s presence on or use of the range, buildings, land and premises (“Premise’s”); and, any and all acts or omissions of Undersigned. Undersigned furthermore waives for himself/herself and for his/her executors, personal representatives, administrators, assignees, heirs and next of kin, any and all rights and claims for damages, losses, demands and any other actions or claims whatsoever, which he/she may have or which may arise against instructor (including but not limited to the death of Undersigned and/or any and all injuries, damages or illnesses suffered by Undersigned or Undersigned’s property), which may, in any way whatsoever, arise out of, be related to or be connected with: the course of instruction; the Premises, including any latent defect in the Premises; Undersigned’s presence on or use of said Premises; Undersigned’s property (whether or not entrusted to instructor); and, the discharge of firearms. Instructor shall not be liable for, and Undersigned, on behalf of himself/herself and on behalf of his/her executors, personal representatives, administrators, assignees, heirs and next of kin, hereby expressly releases the Instructor from any and all such claims and liabilities.&nbsp; Undersigned hereby expressly assumes the risk of taking part in the course of instruction in firearms and taking part in activities on the Premises, which include, but are not limited to, instruction in the use of firearms, the discharge of firearms and the firing of live ammunition.&nbsp; Undersigned hereby acknowledges and agrees that Undersigned has read this instrument and understands its terms and is executing this instrument voluntarily. Undersigned furthermore hereby acknowledges and agrees that he/she has read, understands, and will at all times abide by all range rules and procedures and any other rules and procedures stated by the instructor.&nbsp; Undersigned expressly agrees that this instrument is intended to be as broad and inclusive as permitted by law, and that if any provisions of this instrument is held invalid or otherwise unenforceable, the enforceability of the remaining provisions shall not be impaired thereby. No remedy conferred by any of the specific provisions of this instrument is intended to be exclusive of any other remedy, and each and every remedy shall be cumulative and shall be cumulative and shall be in addition to every other remedy now or hereafter existing at law or in equity or by statue or otherwise. The election of any one or more remedy hereunder by the Instructor shall not constitute any waiver of Instructor’s right to pursue other available remedies. This instrument binds Undersigned and his/her executors, personal representatives, administrators, assignees, heirs and next of kin. In addition by checking this box, you understand Firearm Training Pro, Gun Show Team or Affiliates, may call individual(s) at the telephone number or numbers provided about educational products, services, events, specials, discounts or about 3rd party products or services which Firearm Training Pro, Gun Show Team or Affiliates, believes you may be interested in. I understand that I am not required to enter or otherwise provide to Firearm Training Pro, Gun Show Team or Affiliates, my contact information or agree to be contacted as a condition of purchasing any products or services from Firearm Training Pro, Gun Show Team or Affiliates and will provide in writing if I wish to be excluded from any and all forms of communications which are not limited to and include automated calls, mobile text and/or emails from Firearm Training Pro, Gun Show Team or Affiliates. Furthermore the customer agrees that all payments applied for training and/or deposits for further training are non-refundable and you agree to our terms and conditions.</div>
                                        </div>

                                        <button class="btn btn-light waves-effect waves-light mr-3" style="box-shadow:0 2px 2px gray"
                                            type="submit">Submit</button>
                                        <button class="btn waves-effect waves-light" onclick="window.reload()" style="background-color:#798d8f;color:white;box-shadow:0 2px 2px gray"
                                            type="button">Reset</button>

                                    </form>

                                </div>
                            </div>

                        </div>

                        <div class="mt-5 text-center">
                            <p>© <script>
                                    document.write(new Date().getFullYear())
                                </script> Admin panel. Crafted with <i class="mdi mdi-heart text-danger"></i> by Artem</p>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    @endsection
    @section('script')
        <script>
            window.onload = function() {
                var $recaptcha = document.querySelector('#g-recaptcha-response');

                if($recaptcha) {
                    $recaptcha.setAttribute("required", "required");
                }
            }

            $(document).ready(function() {
                $("#phone").keypress(function(event) {
                    return /\d/.test(String.fromCharCode(event.keyCode));
                });
            });

            function check_format(phone){
                var phone_number = $(phone).val();
                if(phone_number.length==2){
                    $(phone).val(phone_number+'(');
                }else if(phone_number.length==6){
                    $(phone).val(phone_number+')');
                }else if(phone_number.length==10){
                    $(phone).val(phone_number+'-');
                }else if(phone_number.length>=15){
                    $(phone).val(phone_number.substr(0, 14));
                }
            }

            function select_class_date(location){
                var location = $(location).val();
                $.ajax({
                    url: "{{Url('customers/select_class_date')}}",
                    data: {
                        location: location
                    },
                    success:function(data){
                        $("#class_date").html(data);
                    }
                })
            }

            function select_QTY(){
                var location = $("#location").val();
                var date = $("#class_date").val();
                $.ajax({
                    url: "{{Url('customers/select_QTY')}}",
                    data: {
                        location: location,
                        date: date
                    },
                    success:function(data){
                        $("#registration_fee").html(data);
                    }
                })
            }

            function total_fee(qty){
                var qty = $(qty).val();
                if(qty != 0){
                    $("#fees_table").css('display', 'block')
                    var fee = $("#fee").html();
                    var total = Number(qty)*Number(fee);
                    $("#fees").val(total.toFixed(2));
                    $("#displaytotal").val(total.toFixed(2));
                    $("#total").val(total);
                }else{
                    $("#fees_table").css('display', 'none');
                    $("#fees").val("");
                    $("#displaytotal").val("");
                    $("#total").val("");
                }
            }
        </script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    @endsection
