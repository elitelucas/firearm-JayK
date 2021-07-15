@extends('layouts.master-layouts')

@section('title')
    @lang('translation.Admin_Users')
@endsection

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <style>
        .btn-toggle.btn-sm:before,
        .btn-toggle.btn-sm:after {
            line-height: -0.5rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.4125rem;
            width: 2.325rem;
        }
        .btn-toggle.btn-sm:before {
            text-align: right;
        }
        .btn-toggle.btn-sm:after {
            text-align: left;
            opacity: 0;
        }
        .btn-toggle.btn-sm.active:before {
            opacity: 0;
        }
        .btn-toggle.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-sm {
            margin: 3px 0.5rem;
            padding: 0;
            position: relative;
            border: none;
            height: 1.5rem;
            width: 3rem;
            border-radius: 1.5rem;
        }
        .btn-toggle.btn-sm:focus,
        .btn-toggle.btn-sm.focus,
        .btn-toggle.btn-sm:focus.active,
        .btn-toggle.btn-sm.focus.active {
            outline: none;
        }
        .btn-toggle.btn-sm:before,
        .btn-toggle.btn-sm:after {
            line-height: 1.5rem;
            width: 0.5rem;
            text-align: center;
            font-weight: 600;
            font-size: 0.55rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            bottom: 0;
            transition: opacity 0.25s;
        }
        .btn-toggle.btn-sm:before {
            content: "Off";
            left: -0.5rem;
        }
        .btn-toggle.btn-sm:after {
            content: "On";
            right: -0.5rem;
            opacity: 0.5;
        }
        .btn-toggle.btn-sm > .handle {
            position: absolute;
            top: 0.1875rem;
            left: 0.1875rem;
            width: 1.125rem;
            height: 1.125rem;
            border-radius: 1.125rem;
            background: #fff;
            transition: left 0.25s;
        }
        .btn-toggle.btn-sm.active {
            transition: background-color 0.25s;
        }
        .btn-toggle.btn-sm.active > .handle {
            left: 1.6875rem;
            transition: left 0.25s;
        }
        .btn-toggle.btn-sm.active:before {
            opacity: 0.5;
        }
        .btn-toggle.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-sm.btn-sm:before,
        .btn-toggle.btn-sm.btn-sm:after {
            line-height: -0.5rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.4125rem;
            width: 2.325rem;
        }
        .btn-toggle.btn-sm.btn-sm:before {
            text-align: right;
        }
        .btn-toggle.btn-sm.btn-sm:after {
            text-align: left;
            opacity: 0;
        }
        .btn-toggle.btn-sm.btn-sm.active:before {
            opacity: 0;
        }
        .btn-toggle.btn-sm.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-secondary {
            color: #6b7381;
            background: #bdc1c8;
        }
        .btn-toggle.btn-secondary:before,
        .btn-toggle.btn-secondary:after {
            color: #6b7381;
        }
        .btn-toggle.btn-secondary.active {
            background-color: #ff8300!important;
        }

    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Admin Users</h4>
                    <button class="float-left btn btn-primary waves-effect waves-light mb-2" onclick="manage_users(0)"><i class="bx bx-plus-medical mr-1"></i>Add Admin Users</button>
                    <button class="float-left btn btn-info waves-effect waves-light mb-2" id="edit_commission_fee_btn" onclick="edit_commission_fee()" style="display:none"><i class="far fa-check-square mr-1"></i>Edit Commission Fee</button>
                    <div class="float-right">
                        <label class="control-label">Payout Status: </label>
                        <button type="button" class="btn btn-sm btn-secondary btn-toggle" data-toggle="button" aria-pressed="{{$payout == 1?'true':'false'}}" autocomplete="off" onclick="toggle_payout()">
                            <div class="handle"></div>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-centered table-nowrap mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 20px;">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_all" onclick="check_all()">
                                            <label class="custom-control-label" for="check_all">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>Name</th>
                                    <th>Cell Phone</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Paypal Payout Email</th>
                                    <th>Commission Fee</th>
                                    <th>Mannual Pay</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($admin_users)!=0)
                                    @foreach($admin_users as $key=>$admin_user)
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck{{$key}}" value="{{$admin_user->id}}" onclick="check_admin_user()">
                                                <label class="custom-control-label" for="customCheck{{$key}}">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>{{$admin_user->name}}</td>
                                        <td>{{$admin_user->phone}}</td>
                                        <td>{{$admin_user->email}}</td>
                                        <td>{{$admin_user->address}}</td>
                                        <td>{{$admin_user->paypal_payout_email}}</td>
                                        <td>USD {{number_format($admin_user->commission_fee, 2)}}</td>
                                        <td>USD {{number_format($admin_user->commission, 2)}}</td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button"
                                                class="btn btn-primary btn-sm waves-effect waves-light mr-1" onclick="view_customers({{$admin_user->id}})">
                                                <i class="fa fa-eye" title="View Customers"></i>
                                            </button>

                                            <button type="button"
                                                class="btn btn-success btn-sm waves-effect waves-light mr-1" onclick="manage_users({{$admin_user->id}})">
                                                <i class="fa fa-edit" title="Edit"></i>
                                            </button>

                                            <button type="button"
                                                class="btn btn-danger btn-sm waves-effect waves-light" onclick="delete_users({{$admin_user->id}})">
                                                <i class="fa fa-trash" title="Delete"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                                            <label class="custom-control-label" for="customCheck2">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td><a href="javascript: void(0);" class="text-body font-weight-bold">#SK2540</a>
                                    </td>
                                    <td>Neal Matthews</td>
                                    <td>
                                        07 Oct, 2019
                                    </td>
                                    <td>
                                        $400
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-soft-success font-size-12">Paid</span>
                                    </td>
                                    <td>
                                        <i class="fab fa-cc-mastercard mr-1"></i> Mastercard
                                    </td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button"
                                            class="btn btn-primary btn-sm waves-effect waves-light mr-1" onclick="view_customers(1)">
                                            <i class="fa fa-eye" title="View Customers"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-success btn-sm waves-effect waves-light mr-1" onclick="manage_users(1)">
                                            <i class="fa fa-edit" title="Edit"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-danger btn-sm waves-effect waves-light" onclick="delete_users(2)">
                                            <i class="fa fa-trash" title="Delete"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck3">
                                            <label class="custom-control-label" for="customCheck3">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td><a href="javascript: void(0);" class="text-body font-weight-bold">#SK2541</a>
                                    </td>
                                    <td>Jamal Burnett</td>
                                    <td>
                                        07 Oct, 2019
                                    </td>
                                    <td>
                                        $380
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-soft-danger font-size-12">Chargeback</span>
                                    </td>
                                    <td>
                                        <i class="fab fa-cc-visa mr-1"></i> Visa
                                    </td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button"
                                            class="btn btn-primary btn-sm waves-effect waves-light mr-1" onclick="view_customers(1)">
                                            <i class="fa fa-eye" title="View Customers"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-success btn-sm waves-effect waves-light mr-1" onclick="manage_users(1)">
                                            <i class="fa fa-edit" title="Edit"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-danger btn-sm waves-effect waves-light" onclick="delete_users(2)">
                                            <i class="fa fa-trash" title="Delete"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck4">
                                            <label class="custom-control-label" for="customCheck4">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td><a href="javascript: void(0);" class="text-body font-weight-bold">#SK2542</a>
                                    </td>
                                    <td>Juan Mitchell</td>
                                    <td>
                                        06 Oct, 2019
                                    </td>
                                    <td>
                                        $384
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-soft-success font-size-12">Paid</span>
                                    </td>
                                    <td>
                                        <i class="fab fa-cc-paypal mr-1"></i> Paypal
                                    </td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button"
                                            class="btn btn-primary btn-sm waves-effect waves-light mr-1" onclick="view_customers(1)">
                                            <i class="fa fa-eye" title="View Customers"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-success btn-sm waves-effect waves-light mr-1" onclick="manage_users(1)">
                                            <i class="fa fa-edit" title="Edit"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-danger btn-sm waves-effect waves-light" onclick="delete_users(2)">
                                            <i class="fa fa-trash" title="Delete"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck5">
                                            <label class="custom-control-label" for="customCheck5">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td><a href="javascript: void(0);" class="text-body font-weight-bold">#SK2543</a>
                                    </td>
                                    <td>Barry Dick</td>
                                    <td>
                                        05 Oct, 2019
                                    </td>
                                    <td>
                                        $412
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-soft-success font-size-12">Paid</span>
                                    </td>
                                    <td>
                                        <i class="fab fa-cc-mastercard mr-1"></i> Mastercard
                                    </td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button"
                                            class="btn btn-primary btn-sm waves-effect waves-light mr-1" onclick="view_customers(1)">
                                            <i class="fa fa-eye" title="View Customers"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-success btn-sm waves-effect waves-light mr-1" onclick="manage_users(1)">
                                            <i class="fa fa-edit" title="Edit"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-danger btn-sm waves-effect waves-light" onclick="delete_users(2)">
                                            <i class="fa fa-trash" title="Delete"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck6">
                                            <label class="custom-control-label" for="customCheck6">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td><a href="javascript: void(0);" class="text-body font-weight-bold">#SK2544</a>
                                    </td>
                                    <td>Ronald Taylor</td>
                                    <td>
                                        04 Oct, 2019
                                    </td>
                                    <td>
                                        $404
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-soft-warning font-size-12">Refund</span>
                                    </td>
                                    <td>
                                        <i class="fab fa-cc-visa mr-1"></i> Visa
                                    </td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button"
                                            class="btn btn-primary btn-sm waves-effect waves-light mr-1" onclick="view_customers(1)">
                                            <i class="fa fa-eye" title="View Customers"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-success btn-sm waves-effect waves-light mr-1" onclick="manage_users(1)">
                                            <i class="fa fa-edit" title="Edit"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-danger btn-sm waves-effect waves-light" onclick="delete_users(2)">
                                            <i class="fa fa-trash" title="Delete"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck7">
                                            <label class="custom-control-label" for="customCheck7">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td><a href="javascript: void(0);" class="text-body font-weight-bold">#SK2545</a>
                                    </td>
                                    <td>Jacob Hunter</td>
                                    <td>
                                        04 Oct, 2019
                                    </td>
                                    <td>
                                        $392
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-soft-success font-size-12">Paid</span>
                                    </td>
                                    <td>
                                        <i class="fab fa-cc-paypal mr-1"></i> Paypal
                                    </td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button"
                                            class="btn btn-primary btn-sm waves-effect waves-light mr-1" onclick="view_customers(1)">
                                            <i class="fa fa-eye" title="View Customers"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-success btn-sm waves-effect waves-light mr-1" onclick="manage_users(1)">
                                            <i class="fa fa-edit" title="Edit"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-danger btn-sm waves-effect waves-light" onclick="delete_users(2)">
                                            <i class="fa fa-trash" title="Delete"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <!-- Modal -->
    <div class="modal fade exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">                
            </div>
        </div>
    </div>

    <div class="modal fade" id="commission_fee_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New commission Fee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="admin-users/save_commission_fee" method="GET">
                    <input type="hidden" name="checked_admin_users" id="checked_admin_users">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="commission_fee" value="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end modal -->


@endsection

@section('script')
    <script>
        function toggle_payout(){
            $.ajax({
                url: "{{Url('admin-users/payout')}}",                    
            })
        }

        function check_all(){
            var not_selected = 0;
            $("td input[type='checkbox']").each(function(){
                if($(this).prop("checked") == false){
                    not_selected++;
                }
            })
            if(not_selected>0){
                $("td input[type='checkbox']").each(function(){
                    $(this).prop('checked', true);
                });
                $("#edit_commission_fee_btn").css('display', 'inline-block');
            }else{
                $("td input[type='checkbox']").each(function(){
                    $(this).prop('checked', false);
                });
                $("#edit_commission_fee_btn").css('display', 'none');
            }
        }

        function check_admin_user(){
            var selected = 0;
            var all_selected = true;
            $("td input[type='checkbox']").each(function(){
                if($(this).prop("checked") == true){
                    selected++;
                }else{
                    all_selected = false;
                }
            })
            if(selected>0){
                $("#edit_commission_fee_btn").css('display', 'inline-block');
            }else{
                $("#edit_commission_fee_btn").css('display', 'none');
            }
            if(all_selected==true){
                $("#check_all").prop('checked', true);
            }else{
                $("#check_all").prop('checked', false);
            }
        }

        function edit_commission_fee(){
            var checked_admin_users = [];
            $("td input[type='checkbox']").each(function(){
                if($(this).prop("checked") == true){
                    checked_admin_users.push($(this).val());
                }
            })
            $("#checked_admin_users").val(checked_admin_users);
            $("#commission_fee_modal").modal();
        }

        function view_customers(id){
            window.location.href="{{Url('customers')}}?id="+id
        }

        function manage_users(id){
            $.ajax({
                url: "{{Url('admin-users/manage')}}/"+id,
                success:function(data){
                    $(".exampleModal .modal-content").html(data);
                    $(".exampleModal").modal();
                }
            })
        }

        function delete_users(id){
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#34c38f",
                cancelButtonColor: "#f46a6a",
                confirmButtonText: "Yes, delete it!"
            }).then(function (t) {
                if(t.value){
                    $.ajax({
                        url: "{{Url('admin-users/delete')}}/"+id,
                        success:function(data){
                            Swal.fire("Deleted!", "Your file has been deleted.", "success");
                            window.location.reload();
                        }
                    })                    
                }
            });
        }
    </script>

    <!-- Plugin Js-->
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Init js-->
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
