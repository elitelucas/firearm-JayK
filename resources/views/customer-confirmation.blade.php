@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.Customers') @lang('translation.Confirmation')
@endsection

@section('body')

    <body>
    @endsection

    @section('content')

        <div class="home-btn d-none d-sm-block">
            <a href="{{ url('/') }}" class="text-dark"><i class="fas fa-home h2"></i></a>
        </div>
        <div class="account-pages my-3 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-10 col-xl-8">
                        <div class="card overflow-hidden">
                            <div class="card-body pt-5">                                
                                <div class="p-2">
                                    <table class="table table-bordered" style="color:#B9B9B9">
                                        <thead>
                                        <tr style="background-color:#D0D7DB;color:#92A2AB">
                                            <th colspan="2" style="padding:0 0.75rem;position:relative">
                                                <i class="mdi mdi-pencil-circle mr-2" style="font-size:35px;color:white"></i>
                                                <span style="font-size:25px;font-family:Times New Roman;position:absolute;top:8px">Order details</span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><i class="fa fa-calculator mr-2"></i>Event Name:</td>
                                            <td>{{$event_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Attendee Name:</td>
                                            <td>{{$attendee->fname}} {{$attendee->lname}}</td>
                                        </tr>
                                        <tr>
                                            <td>Email Address:</td>
                                            <td>{{$attendee->email}}</td>
                                        </tr>
                                        <tr>
                                            <td>Number of Attendees:</td>
                                            <td>{{$attendee->quantity}}</td>
                                        </tr>
                                        <tr>
                                            <td>Order Details:</td>
                                            <td>Admission USD {{number_format($attendee->order_total/$attendee->quantity, 2)}}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Cost:</td>
                                            <td>USD {{$attendee->order_total}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="mr-4 mb-3 text-right">
                                <a class="btn btn-primary" type="button" href="{{Url('customers/confirmation')}}?attendee_id={{$attendee->id}}">Confirm</a>
                            </div>
                        </div>

                        <div class="mt-3 text-center">
                            <p><span style="color:red">*</span> {!!$customer_message!!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
