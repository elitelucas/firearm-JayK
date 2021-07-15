@extends('layouts.master-layouts')

@section('title')
    @lang('translation.Customers')
@endsection

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('content')
    @if ($message = Session::get('success'))
        <div class="custom-alerts alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {!! $message !!}
        </div>
        <?php Session::forget('success');?>
    @endif

    @if ($message = Session::get('error'))
        <div class="custom-alerts alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {!! $message !!}
        </div>
        <?php Session::forget('error');?>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Customers</h4>
                    @if(Auth::user()->is_admin!=1)
                    <div class="form-inline mb-3">
                        <label class="control-label mr-2">Provide this link for students to register under your account:</label> 
                        <input type="text" id="short_url" class="form-control" style="width:300px" value="{{$url}}" readonly></span>
                        <button type="button" class="btn btn-success waves-effect waves-light ml-2" onclick="copyToClipboard()">Copy</button>
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table id="datatable" class="table table-centered table-nowrap mb-0">
                            <thead class="thead-light">
                                <tr>                                    
                                    @if(Auth::user()->is_admin==1)
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Event</th>
                                    <th>QTY</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    @else
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($customers)!=0)
                                    @foreach($customers as $customer)
                                        @if($customer->attendee != null)
                                        <tr>
                                            @if(Auth::user()->is_admin==1)
                                            <td>{{$customer->fname}} {{$customer->lname}}</td>
                                            <td>{{$customer->attendee->email}}</td>
                                            <td>{{$customer->attendee->phone}}</td>
                                            <td>{{$customer->attendee->city}} {{$customer->attendee->address}}</td>
                                            <td>{{$customer->attendee->event->event_name}}</td>
                                            <td>{{$customer->attendee->quantity}}</td>
                                            <td>{{$customer->attendee->order_total}}</td>
                                            <td>{{$customer->attendee->date}}</td>
                                            @else
                                            <td>{{$customer->fname}}</td>
                                            <td>{{$customer->lname}}</td>
                                            @endif
                                        </tr>
                                        @endif
                                    @endforeach
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


@endsection

@section('script')
    <!-- Plugin Js-->
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Init js-->
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script>
        function copyToClipboard() {  
            $("#short_url").select();
            document.execCommand("copy");
        }
    </script>
@endsection
