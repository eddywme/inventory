@extends('layouts.app')
@section('title', 'Item Assignment')
@section('styles')
    <link href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <style>
        .main-content{
            background: #fff;
        }
        footer{
            margin-top: 0px;
        }
    </style>
@endsection
@section('content')
    <div class="container">



        <div class="row main-content">
            <div class="col-md-10 col-md-offset-1">

                @if (session('status'))
                    <div class="alert alert-success" style="margin-top: 10px">
                        <h5>{{ session('status') }}</h5>
                    </div>
                @endif

                <h1 class="page-header" align="center"> <strong>API TOKEN ASSIGNMENT PROCESS</strong> </h1>
                <h6>An API Token will be sent to the user's mail after a successful operation. The user will be using the API token to make requests to the REST Service</h6>
                <div class="row">

                        @if (session('error-status'))
                            <div class="alert alert-danger" style="padding: 5px">
                                <h5>{{ session('error-status') }}</h5>
                            </div>
                        @endif

                        @if (session('success-status'))
                            <div class="alert alert-success" style="padding: 5px">
                                <h5>{{ session('success-status') }}</h5>
                            </div>
                        @endif

                        <div class="panel panel-info">

                            <div class="panel-heading">
                                FIND USER TO ASSIGN THE API TOKEN
                            </div>

                            <form action="" class="form" method="post">

                                {{ csrf_field() }}

                            <div class="panel-body">


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="First Name" id="first_name_" name="first_name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Last Name" id="last_name_" name="last_name" required>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="E-mail" id="email_" name="email" required>
                                    </div>

                                    <div class="form-group">
                                        <textarea name="comment" id="comment"  rows="8" class="form-control" placeholder="Comment [ Optional ]"></textarea>
                                    </div>


                            </div>
                            <div class="panel-footer">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-ticket"></i>
                                    ASSIGN ITEM
                                </button>
                            </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>




        </div>
        </div>

@endsection
@section('scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.confirm.js') }}"></script>

    <script>
        $(document).ready(function () {

            $('#first_name_').autocomplete({
                serviceUrl: '/assignment/firstNamesEndPoint'
            });

            $('#last_name_').autocomplete({
                serviceUrl: '/assignment/lastNamesEndPoint'
            });

            $('#email_').autocomplete({
                serviceUrl: '/assignment/emailsEndPoint'
            });

        });

    </script>
@endsection

