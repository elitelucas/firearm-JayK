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
                            <div class="card-title mt-5 mb-3">
                                <div class="text-center">
                                    <a class="btn btn-success" type="button" href="{{Url('customers/registration')}}/{{$id}}">New Registration</a>
                                </div>
                            </div>
                            <div class="card-body pt-5 text-center">
                                @if(Session::has('success'))
                                    <div class="p-2">
                                        Congratulations! You registered successfully.                                    
                                    </div>
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                        <i class="fa fa-check margin-separator"></i> {{Session::get('success')}}
                                    </div>
                                @endif                                
                                @if(Session::has('error'))
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                        <i class="fa fa-check margin-separator"></i> {{Session::get('error')}}
                                    </div>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
