@extends('layouts.master-layouts')

@section('title') @lang('translation.Dashboard') @endsection

@section('css')
    <!-- Summernote css -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/summernote/summernote.min.css') }}">
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Dashboard @endslot
        @slot('li_1') Contacts @endslot
        @slot('li_2') Profile @endslot
    @endcomponent


    <!-- end page title -->

    <div class="row">
        <div class="col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-soft-primary">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Welcome Back !</h5>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="{{ URL::asset('/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="avatar-md profile-user-wid mb-4">
                                <img src="{{ isset(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('/assets/images/users/avatar-1.jpg') }}"
                                    alt="" class="img-thumbnail rounded-circle">
                            </div>
                            <h5 class="font-size-15 text-truncate">{{ Auth::user()->name }}</h5>
                            <p class="text-muted mb-0 text-truncate">{{Auth::user()->company}}</p>
                        </div>

                        <div class="col-sm-8">
                            <div class="pt-4">

                                <div class="row">
                                    @if(Auth::user()->is_admin==1)
                                    <div class="col-6">
                                        <h5 class="font-size-15">{{count($admin_users)}}</h5>
                                        <p class="text-muted mb-0">Admin Users</p>
                                    </div>
                                    @endif
                                    <div class="col-6">
                                        <h5 class="font-size-15">{{count($customers)}}</h5>
                                        <p class="text-muted mb-0">Customers</p>
                                    </div>
                                </div>
                                <div class="mt-4 text-right">
                                    <a href="{{ url('/contacts-profile/edit') }}"
                                        class="btn btn-primary waves-effect waves-light btn-sm">Edit Profile <i
                                            class="mdi mdi-arrow-right ml-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Personal Information</h4>                   
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Full Name :</th>
                                    <td>{{ Auth::user()->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Mobile :</th>
                                    <td>{{ Auth::user()->phone }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">E-mail :</th>
                                    <td>{{ Auth::user()->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Address :</th>
                                    <td>{{ Auth::user()->address}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Paypal Payout Email :</th>
                                    <td>{{ Auth::user()->paypal_payout_email }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end card -->

            @if(Auth::user()->is_admin==1)
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Commission fee</h4>
                    <div class="">
                        <ul class="verti-timeline list-unstyled">
                            <li class="event-list active">
                                <div class="event-timeline-dot">
                                    <i class="bx bx-right-arrow-circle bx-fade-right"></i>
                                </div>
                                <div class="media">
                                    <div class="mr-3">
                                        <i class="bx bx-server h4 text-primary"></i>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <h5 class="font-size-15"><a href="#" class="text-dark">Default Commission Fee</a>
                                            </h5>
                                            <span class="text-primary">USD {{number_format($commission_fee->value, 2)}}</span>
                                        </div>
                                    </div>
                                    <div class="media-footer">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded" data-toggle=modal data-target=#commission_fee_modal>Edit</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- end card -->
            @endif
        </div>

        <div class="col-xl-8">

            <div class="row">
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Total QTY</p>
                                    <h4 class="mb-0">{{$total_qty}}</h4>
                                </div>

                                <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-group font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Total Orders</p>
                                    <h4 class="mb-0">${{number_format($total_order, 2)}}</h4>
                                </div>

                                <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-hourglass font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Paid Orders</p>
                                    <h4 class="mb-0">${{number_format($paid_order, 2)}}</h4>
                                </div>

                                <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-package font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Received</p>
                                    <h4 class="mb-0">${{number_format($admin_received, 2)}}</h4>
                                </div>

                                <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-money font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Revenue</h4>
                    <div id="revenue-chart" class="apex-charts"></div>
                </div>
            </div>
            @if(Auth::user()->is_admin==1)
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Customer Message <button type="button" class="btn btn-primary btn-sm btn-rounded float-right" data-toggle="modal" data-target="#customer_message_modal">Edit</button></h4>
                    <div>{!!$customer_message->value!!}</div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Select Categories</h4>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Categories</th>
                                    <th style="text-align:center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td style="vertical-align:middle">{{$category->category_name}}</td>
                                    <td style="text-align:center"><input type="checkbox" style="width:24px;height:24px;cursor:pointer" onclick="check_category({{$category->id}})" @if($category->display==1) checked @endif/></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <!-- end row -->

    @if(Auth::user()->is_admin==1)
        <!-- Modal -->
        <div class="modal fade" id="commission_fee_modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New commission Fee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{Url('contacts-profile/save_commission_fee')}}" method="GET">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="commission_fee" value="{{$commission_fee->value}}" required>
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

        <div class="modal fade" id="customer_message_modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Customer Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="summernote" name="customer_message">{{$customer_message->value}}</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" onclick="edit_customer_message()">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modal -->
    @endif

@endsection

@section('script')

    <script>
        window.onload = function() {
            var qty = [];
            var order = [];
            var paid = [];
            var received = [];
            var admin_users = [];
            <?php foreach($admin_users as $admin_user){ ?>
                qty.push(<?= $admin_user->total_qty?>);
                order.push(<?= $admin_user->total_order?>);
                paid.push(<?= $admin_user->paid_order?>);
                received.push(<?= $admin_user->user_received?>);
                admin_users.push("<?= $admin_user->name?>");
            <?php } ?>
            var options = {
                chart: {
                    height: 300,
                    type: "bar",
                    toolbar: {
                    show: !1
                    }
                },
                plotOptions: {
                    bar: {
                    horizontal: !1,
                    <?php if(Auth::user()->is_admin==1){?>
                        columnWidth: "10%",
                    <?php }else{?>
                        columnWidth: "100%",
                    <?php }?>
                    endingShape: "rounded"
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ["transparent"]
                },
                series: [
                    {
                        name: "QTY",
                        data: qty
                    },{
                        name: "Order",
                        data: order
                    },{
                        name: "Paid",
                        data: paid
                    },{
                        name: "Received",
                        data: received
                    }
                ],
                xaxis: {
                    categories: admin_users
                },
                yaxis: {
                    title: {
                    text: "Details"
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                        return "$ " + val 
                        }
                    }
                },
                colors: ["#556ee6","#00e396","#feb019","#fe1919"]
            },
            chart = new ApexCharts(document.querySelector("#revenue-chart"), options);
            chart.render();
        }
        function edit_customer_message(){
            var message = $(".note-editable").html();
            $.ajax({
                url: "{{Url('contacts-profile/save_customer_message')}}",
                data: {message: message},
                success:function(data){
                    window.location.reload();
                }
            })
        }
        function check_category(id){
            $.ajax({
                url: "{{Url('contacts-profile/check_category')}}",
                data: {id: id},
                success:function(){}
            })
        }
    </script>

    <!-- Summernote js -->
    <script src="{{ URL::asset('assets/libs/summernote/summernote.min.js') }}"></script>

    <script src="{{ URL::asset('assets/js/pages/form-editor.init.js') }}"></script>

    <!-- flot plugins -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    
    <!-- <script src="{{ URL::asset('/assets/js/pages/profile.init.js') }}"></script> -->

@endsection
